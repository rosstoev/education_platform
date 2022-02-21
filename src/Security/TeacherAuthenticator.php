<?php
declare(strict_types=1);

namespace App\Security;


use App\Form\Security\LoginType;
use App\Repository\TeacherRepository;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

class TeacherAuthenticator extends AbstractAuthenticator implements AuthenticationEntryPointInterface
{

    private RouterInterface $router;
    private FormFactoryInterface $formFactory;
    private TeacherRepository $teacherRepository;

    public function __construct(RouterInterface $router, FormFactoryInterface $formFactory, TeacherRepository $teacherRepository)
    {
        $this->router = $router;
        $this->formFactory = $formFactory;
        $this->teacherRepository = $teacherRepository;
    }

    public function supports(Request $request): ?bool
    {
        return ($request->getPathInfo() === '/teacher/login' && $request->isMethod('POST'));
    }

    public function authenticate(Request $request): Passport
    {
        $form = $this->formFactory->create(LoginType::class);
        $form->handleRequest($request);
        $credentials = $form->getData();
        $userBadge = new UserBadge($credentials['email'], function ($userIdentifier) {
            $teacher = $this->teacherRepository->findOneBy(['email' => $userIdentifier]);
            if (!$teacher) {
                throw new UserNotFoundException();
            }
            return $teacher;
        });
        $passwordCredention = new PasswordCredentials($credentials['password']);

        return new Passport($userBadge, $passwordCredention);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return new RedirectResponse(
          $this->router->generate('teacher_dashboard')
        );
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);

       return new RedirectResponse(
           $this->router->generate('teacher_login')
       );
    }

    public function start(Request $request, AuthenticationException $authException = null): Response
    {
        return new RedirectResponse(
            $this->router->generate('teacher_dashboard')
        );
    }
}