<?php
namespace App\Controller;

use App\Entity\User;
use App\Form\PasswordType;
use App\Form\ResetPasswordType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Twig\Environment;

class PasswordController extends AbstractController
{
    public function __construct(
        private UserRepository $userRepository,
        private MailerInterface $mailer,
        private Environment $twig,
        private TokenGeneratorInterface $tokenGenerator,
        private UserPasswordHasherInterface $hasher,
        private EntityManagerInterface $em
    )
    {
        
    }

    #[Route('/forgotten-password', name: 'app_forgotten_password', methods: ['POST', 'GET'])]
    public function forgottenPassword(Request $request)
    {
        $email = '';

        if($request->getMethod() === 'POST')
        {
            $email = $request->request->get('email');
            /** @var User|null $user */
            if($user = $this->userRepository->findOneBy(['email' => $email]))
            {
                //génération du token
                $token = $this->tokenGenerator->generateToken();
                $user->setToken($token)
                    ->setTokenExpireAt(time() + (3600 * 48))
                    ;
                $this->em->flush();

                //envoi mail
                $link = $this->generateUrl('app_reset_password', [
                    'token' => $user->getId() . '@@@' . $user->getToken()
                ], UrlGeneratorInterface::ABSOLUTE_URL);
                $this->mailer->send(
                    (new Email())
                    ->from('noreply@katapicturesapp.com')
                    ->to($email)
                    ->html($this->twig->render('email/reset_password.html.twig', [
                        'user' => $user,
                        'link' => $link
                    ]))
                );
                $this->addFlash('success', 'Un email vous a été envoyé afin de réinitialiser votre mot de passe.');
                return $this->redirectToRoute('app_user_show');
            }
            $this->addFlash('danger', 'Aucun utilisateur avec cette adresse email.');
            return $this->redirectToRoute('app_forgotten_password');
        }
            
        return $this->render('security/forgotten_password.html.twig', [
            'email' => $email
        ]);
    }

    #[Route('/reset-password', name: 'app_reset_password', methods: ['GET', 'POST'])]
    public function resetPassword(Request $request): Response
    {
        //on vérifie que le token est valide
        try
        {
            $fullToken = $request->query->get('token');
            $userId = explode('@@@', $fullToken)[0];
            $token = explode('@@@', $fullToken)[1];

            /** @var User */
            $user = $this->userRepository->find((int) $userId);

            if(($user->getToken() !== $token) || ($user->getTokenExpireAt() < time()))
            {
                throw new Exception();
            }
        }
        catch(Exception $e)
        {
            $this->addFlash('danger', 'Le lien est invalide ou périmé.');
            return $this->redirectToRoute('app_user_show');
        }

        //on gère le formulaire de création du mot de passe
        $form = $this->createForm(ResetPasswordType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            //vérification supplémentaire
            //confirm_password
            if($form->get('password')->getData() !== $form->get('confirm_password')->getData())
            {
                $form->get('confirm_password')->addError(new FormError('Les deux mots de passe ne sont pas identiques.'));
                return $this->render('security/reset_password.html.twig', [
                    'form' => $form->createView()
                ]);
            }
            
            //si tout est valide
            $user->setPassword(
                $this->hasher->hashPassword($user, $form->get('password')->getData())
            )
                ->setToken(null)
                ->setTokenExpireAt(null)
                ;
            $this->em->flush();
            $this->addFlash('success', 'Le mot de passe a bien été modifié.');
            return $this->redirectToRoute('app_user_show');
        }

        return $this->render('security/reset_password.html.twig', [
            'form' => $form->createView()
        ]);
    }
}