<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/dashboard')]
#[IsGranted('ROLE_USER')]
class ShowUserController extends AbstractController
{
    #[Route('/', name: 'app_user_show', methods: ['GET'])]
    public function index(UserRepository $repo): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }
}
