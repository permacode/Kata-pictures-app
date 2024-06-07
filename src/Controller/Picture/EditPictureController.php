<?php

namespace App\Controller\Picture;

use App\Entity\Picture;
use App\Form\PictureType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/picture')]
#[IsGranted('ROLE_USER')]
class EditPictureController extends AbstractPictureController
{
    #[Route('/{id}/edit', name: 'app_picture_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Picture $picture, EntityManagerInterface $entityManager): Response
    {
        $user = $this->takeUser();
        $form = $this->createForm(PictureType::class, $picture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //TODO: add a request to ChatGPT
            $entityManager->flush();

            return $this->redirectToRoute('app_user_show', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('picture/edit.html.twig', [
            'user' => $user,
            'picture' => $picture,
            'form' => $form,
        ]);
    }
}
