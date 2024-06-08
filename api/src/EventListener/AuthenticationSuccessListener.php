<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Entity\User;
use App\Exception\NoSendEmailException;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
final class AuthenticationSuccessListener
{

    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event): void
    {
        /** @var User|null $user */
        $user = $event->getUser();

        if($user->getDeletedAt()){
            throw new NoSendEmailException('Invalid credentials', 401);
        }

        $data = $event->getData();

        $data['user']=[
            'id' => $user->getId(),
            'name' => $user->getName(),
            'roles' => $user->getRoles()
        ];

        $event->setData($data);
    }
}
