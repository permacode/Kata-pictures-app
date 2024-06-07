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
class AddPictureController extends AbstractPictureController
{

    #[Route('/add', name: 'app_add_picture', methods: ['GET', 'POST'])]
    public function add(
        Request $request,
        EntityManagerInterface $entityManager,
    ): Response {
        $user = $this->takeUser();
        $picture = new Picture();

        $form = $this->createForm(PictureType::class, $picture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->addPicture($picture);
            //TODO: add a request to ChatGPT
            $entityManager->persist($picture);
            $entityManager->persist($user);
            $entityManager->flush();

            $this->sendMailWhenPictureAdded($user, $picture);

            return $this->redirectToRoute('app_user_show', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('picture/add.html.twig', [
            'picture' => $picture,
            'user' => $user,
            'form' => $form,
        ]);
    }
}
