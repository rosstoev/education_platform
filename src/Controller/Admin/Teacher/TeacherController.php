<?php

declare(strict_types=1);

namespace App\Controller\Admin\Teacher;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("/teacher", name="teacher_")
 */
class TeacherController extends AbstractController
{
    /**
     * @Route ("/dashboard", name="dashboard")
     */
    public function dashboard(): Response
    {
        return $this->render('admin/teacher/pages/dashboard.html.twig');
    }

    /**
     * @Route ("/profile", name="profile")
     */
    public function profile(): Response
    {
        return $this->render("admin/teacher/pages/profile/show.html.twig");
    }

    /**
     * @Route ("/profile/edit", name="profile_edit")
     */
    public function editProfile(): Response
    {
        return $this->render("admin/teacher/pages/profile/manage.html.twig");
    }

    /**
     * @Route ("/profile/delete", name="profile_delete")
     */
    public function deleteProfile()
    {

    }
}