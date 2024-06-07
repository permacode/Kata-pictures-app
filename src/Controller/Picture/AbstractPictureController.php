<?php

namespace App\Controller\Picture;

use App\Entity\Picture;
use App\Entity\User;
use Symfony\Bridge\Twig\Mime\NotificationEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;

class AbstractPictureController extends AbstractController
{

    public function __construct(private MailerInterface $mailer)
    {
    }

    protected function takeUser(): User
    {
        /** @var User $user */
        $user = $this->getUser();
        return $user;
    }

    protected function sendMailWhenPictureAdded(User $user, Picture $picture): void
    {
        dump('Mail send in progress...');
        $this->mailer->send((new NotificationEmail())
                ->subject('New picture posted')
                ->htmlTemplate('emails/picture_notification.html.twig')
                // TODO: delete those lines if not necessary
                // ->from($this->adminEmail)
                ->to($user->getEmail())
                ->context([
                    'user' => $user,
                    'picture' => $picture
                ])
        );
        dump($this->mailer);
    }
}
