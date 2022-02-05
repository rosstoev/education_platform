<?php

declare(strict_types=1);

namespace App\Controller\Admin\Teacher;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("/teacher", name="teacher_")
 */
class TeacherController extends AbstractController
{
    /**
     * @Route ("/dashboard", name="dashboard")
     */
    public function dashboard()
    {
        return $this->render('admin/teacher/dashboard.html.twig');
    }
}