<?php


namespace App\Controller\Security;


use App\DTO\UserDTO;
use App\Form\Security\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{

    /**
     * @Route("teacher/login", name="teacher_login")
     */
    public function teacherLogin(AuthenticationUtils $authenticationUtils): Response
    {
        $form = $this->createForm(LoginType::class);
        $error = $authenticationUtils->getLastAuthenticationError();

        return $this->render("pages/security/login.html.twig", [
            'type' => UserDTO::TEACHER,
            'form' => $form->createView(),
            'error' => $error
        ]);
    }

    /**
     * @Route ("/student/login", name="student_login")
     */
    public function studentLogin(): Response
    {
        return $this->render("pages/security/login.html.twig", [
            'type' => UserDTO::STUDENT
        ]);
    }

    /**
     * @Route("/teacher/logout", name="teacher_logout")
     */
    public function logout()
    {
        throw new \Exception('logout() should never be reached');
    }
}