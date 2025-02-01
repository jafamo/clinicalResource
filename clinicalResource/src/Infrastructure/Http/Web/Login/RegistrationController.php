<?php

namespace App\Infrastructure\Http\Web\Login;

use App\Domain\DTO\Email\EmailDTO;
use App\Domain\Entity\User;
use App\Domain\Service\EmailSenderInterface;
use App\Infrastructure\Form\RegistrationFormType;
use App\Infrastructure\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{

    public function __construct(
        private EmailVerifier $emailVerifier,
        private EmailSenderInterface $emailSender
    )
    {
    }

    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        Security $security,
        EntityManagerInterface $entityManager
    ): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var string $plainPassword */
            $plainPassword = $form->get('plainPassword')->getData();

            // encode the plain password
            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));

            //TODO: Validate if email exists before persists

            $entityManager->persist($user);
            $entityManager->flush();

//            // generate a signed url and email it to the user
//            $this->emailVerifier->sendEmailConfirmation(
//                'app_verify_email',
//                $user,
//                (new TemplatedEmail())
//                    ->from(new Address('jafamo@gmail.com', 'Clinic Medical'))
//                    ->to((string) $user->getEmail())
//                    ->subject('Please Confirm your Email')
//                    ->htmlTemplate('registration/confirmation_email.html.twig')
//            );

            $emailDto = new EmailDTO(
                'medicalCener@gmail.com',
                $user->getEmail(),
                'Registration sucessfull medical center',
                'Thank you from Medical center team',
                '<h1>Medical Center</h1> <br> <p>This link is created from medical center team, we apreciate your interest in our application</p>',
            );
            $this->addFlash('success', 'Registration successful! Welcome to Medical Center. We send you an email');
            // do anything else you need here, like send an email
            $this->emailSender->sendEmail($emailDto);
            return $security->login($user, 'form_login', 'main');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            /** @var User $user */
            $user = $this->getUser();
            $this->emailVerifier->handleEmailConfirmation($request, $user);
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('app_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('app_register');
    }
}
