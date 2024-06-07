<?php

namespace App\Service;

use App\Entity\Picture;
use App\Entity\User;
use Symfony\Bridge\Twig\Mime\NotificationEmail;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Mailer\MailerInterface;

class UserMailer
{
    // #[Autowire('%admin_email%')] private string $adminEmail;
    private MailerInterface $mailer;

    public function sendMailWhenPictureAdded(User $user, Picture $picture): void
    {
        $this->mailer->send((new NotificationEmail())
                ->subject('New picture posted')
                ->htmlTemplate('emails/picture_notification.html.twig')
                // TODO: delete those lines if not necessary
                // ->from($this->adminEmail)
                // ->to($this->adminEmail)
                ->context([
                    'user' => $user,
                    'picture' => $picture
                ])
        );
    }
}
