<?php

declare(strict_types=1);

namespace App\Controller\Admin\Student;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("/student", name="student_")
 */
class StudentController extends AbstractController
{
    /**
     * @Route ("/dashboard", name="dashboard")
     */
    public function dashboard(): Response
    {
        return $this->render("admin/student/pages/dashboard.html.twig");
    }
}