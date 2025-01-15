<?php

namespace App\Infrastructure\Http\Web\Login;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[AsController]
class LoginController extends AbstractController
{

    public function __construct(
        private UrlGeneratorInterface $urlGenerator
    )
    {
    }

    #[Route(
        path: '/login',
        name: 'app_login',
        defaults: [
            'resource_class' => TokenStorageInterface::class
        ],
//        methods: ['POST'],
    )]
    public function login(AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('Login/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(
        path: '/logout',
        name: 'app_logout'
    )]
    public function logout(Security $security): void
    {
        // logout the user in on the current firewall
        $response = $security->logout();

        // you can also disable the csrf logout
        $response = $security->logout(false);

        // configure a custom logout response to the homepage
        $response = new RedirectResponse(
            $this->urlGenerator->generate('app_home'),
            RedirectResponse::HTTP_SEE_OTHER
        );

        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

}