<?php

namespace App\Infrastructure\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

class AuthenticationEntryPoint implements AuthenticationEntryPointInterface
{
    public function __construct(
        private UrlGeneratorInterface $urlGenerator,
    )
    {
    }

    public function start(Request $request, ?AuthenticationException $authException = null): RedirectResponse
    {
        if ($authException) {
            // Por ejemplo, puedes registrar el mensaje de excepción.
             $request->getSession()->getFlashBag()->add('danger', $authException->getMessage());
        }

        // add a custom flash message and redirect to the login page
        $request->getSession()->getFlashBag()->add('success', 'You have to login in order to access this page.');

        return new RedirectResponse($this->urlGenerator->generate('app_login'));
    }
}