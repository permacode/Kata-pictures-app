<?php

namespace App\Controller\Picture;

use App\Entity\Picture;
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
        $updatedAt = null !== $picture->getUpdatedAt() ? $picture->getUpdatedAt()->format('d-m-Y H:i') : null;

        return $this->render('picture/show.html.twig', [
            'picture' => $picture,
            'user' => $user,
            'createdAt' => $picture->getCreatedAt()->format('d-m-Y H:i'),
            'updatedAt' => $updatedAt
        ]);
    }
}
