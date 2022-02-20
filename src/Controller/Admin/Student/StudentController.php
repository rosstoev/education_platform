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

    /**
     * @Route ("/profile/show/{student}", name="profile", defaults={"student": null})
     */
    public function profile(?int $student): Response
    {
        return $this->render('admin/student/pages/profile/show.html.twig');
    }

    /**
     * @Route ("/profile/edit", name="profile_edit")
     */
    public function editProfile():Response
    {
        return $this->render('admin/student/pages/profile/manage.html.twig');
    }

    /**
     * @Route ("/profile/delete", name="profile_delete")
     */
    public function deleteProfile()
    {

    }

    /**
     * @Route ("/teacher/{teacher}", name="teacher")
     */
    public function teacher(int $teacher): Response
    {
        return $this->render("admin/student/pages/profile/teacher-page.html.twig");
    }
}