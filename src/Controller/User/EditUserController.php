<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Form\UserType;
use App\Traits\UserControllerTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/dashboard')]
#[IsGranted('ROLE_USER')]
class EditUserController extends AbstractController
{
    use UserControllerTrait;

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isLoggedUser($user)) {
            $form = $this->createForm(UserType::class, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->flush();

                return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('user/edit.html.twig', [
                'user' => $user,
                'form' => $form,
            ]);
        }
    }
}
