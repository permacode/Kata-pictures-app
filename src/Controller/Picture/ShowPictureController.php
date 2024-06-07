<?php

namespace App\Controller\Picture;

use App\Entity\Picture;
use App\Entity\User;
use App\Form\PictureType;
use App\Repository\PictureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/picture')]
#[IsGranted('ROLE_USER')]
class ShowPictureController extends AbstractPictureController
{
    #[Route('/{id}', name: 'app_picture_show', methods: ['GET'])]
    public function show(Picture $picture): Response
    {
        $user = $this->takeUser();
        return $this->render('picture/show.html.twig', [
            'picture' => $picture,
            'user' => $user,
            'createdAt' => $picture->getCreatedAt()->format('d-m-Y H:i'),
            'updatedAt' => $picture->getUpdatedAt()->format('d-m-Y H:i')
        ]);
    }
}
