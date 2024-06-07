<?php

namespace App\Controller\Picture;

use App\Entity\Picture;
use App\Repository\PictureRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/picture')]
#[IsGranted('ROLE_USER')]
class IndexPictureController extends AbstractPictureController
{
    #[Route('/', name: 'app_picture_list', methods: ['GET'])]
    public function index(PictureRepository $repo, Picture $picture): Response
    {
        $user = $this->takeUser();
        return $this->render('picture/show.html.twig', [
            'pictures' => $repo->findAll(),
        ]);
    }
}
