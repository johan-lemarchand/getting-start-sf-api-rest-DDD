<?php

namespace App\AppUser\Controller\UserProfile;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/app/user', name: 'user_')]
class UserProfileController extends AbstractController
{
    const TWIG_PATH = 'AppUser/UserProfile/';

    #[Route('/profile', name: 'profile')]
    public function profile(TranslatorInterface $translatable): Response
    {
        $user = $this->getUser();

        return $this->render(
            self::TWIG_PATH.'profile.html.twig',
            [
                'user' => $user
            ]
        );
    }
}