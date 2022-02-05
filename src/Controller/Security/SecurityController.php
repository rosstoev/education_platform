<?php


namespace App\Controller\Security;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{

    /**
     * @Route("/teacher/login", name="teacher_login")
     */
    public function teacherLogin(): Response
    {
        return $this->render("pages/security/login.html.twig");
    }

    /**
     * @Route ("/student/login", name="student_login")
     */
    public function studentLogin(): Response
    {
        return $this->render("pages/security/login.html.twig");
    }
}