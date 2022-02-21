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
        if (!empty($this->getUser())) {
            return $this->redirectToRoute('teacher_dashboard');
        }
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
    public function studentLogin(AuthenticationUtils $authenticationUtils): Response
    {
        if (!empty($this->getUser())) {
            return $this->redirectToRoute('student_dashboard');
        }
        $form = $this->createForm(LoginType::class);
        $error = $authenticationUtils->getLastAuthenticationError();

        return $this->render("pages/security/login.html.twig", [
            'type' => UserDTO::STUDENT,
            'form' => $form->createView(),
            'error' => $error
        ]);
    }

    /**
     * @Route("/teacher/logout", name="teacher_logout")
     */
    public function teacherLogout()
    {
        throw new \Exception('logout() should never be reached');
    }

    /**
     * @Route("/student/logout", name="student_logout")
     */
    public function studentLogout()
    {
        throw new \Exception('logout() should never be reached');
    }
}