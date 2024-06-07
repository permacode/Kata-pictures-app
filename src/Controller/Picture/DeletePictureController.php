<?php

namespace App\Controller\Picture;

use App\Entity\Picture;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/picture')]
#[IsGranted('ROLE_USER')]
class DeletePictureController extends AbstractPictureController
{
    #[Route('/{id}', name: 'app_picture_delete', methods: ['POST'])]
    public function delete(Request $request, Picture $picture, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $picture->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($picture);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_show', [], Response::HTTP_SEE_OTHER);
    }
}
