<?php

namespace App\Controller\Picture;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AbstractPictureController extends AbstractController
{
    protected function takeUser(): User
    {
        /** @var User $user */
        $user = $this->getUser();
        return $user;
    }
}
