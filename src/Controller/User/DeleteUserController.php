<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Traits\UserControllerTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/dashboard')]
#[IsGranted('ROLE_USER')]
class DeleteUserController extends AbstractController
{
    use UserControllerTrait;
    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isLoggedUser($user)) {
            if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->getPayload()->get('_token'))) {
                $entityManager->remove($user);
                $entityManager->flush();
            }

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }
    }
}
