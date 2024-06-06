<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Traits\UserControllerTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/dashboard')]
#[IsGranted('ROLE_USER')]
class ShowUserController extends AbstractController
{
    use UserControllerTrait;

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        if ($this->isLoggedUser($user)) {
            return $this->render('user/show.html.twig', [
                'user' => $user,
            ]);
        }
    }
}
