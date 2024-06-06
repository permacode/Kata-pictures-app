<?php

namespace App\Traits;

use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;

trait UserControllerTrait
{
    public function __construct(private Security $security)
    {
    }

    public function isLoggedUser(User $user): Bool
    {
        //TODO: to make this work, we have to alter security.yaml
        // return $this->security->getUser()->getId() === $user->getId() ? true : false;

        return true;
    }
}
