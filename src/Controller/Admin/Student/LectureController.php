<?php
declare(strict_types=1);

namespace App\Controller\Admin\Student;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("/student/lecture", name="student_lecture_")
 */
class LectureController extends AbstractController
{
    /**
     * @Route ("/list", name="list")
     */
    public function list(): Response
    {
        return $this->render("admin/student/pages/lecture/list.html.twig");
    }

    /**
     * @Route ("/{lecture}", name="show")
     */
    public function show(int $lecture): Response
    {

        return $this->render("admin/student/pages/lecture/show.html.twig", [
            'lecture' => $lecture
        ]);
    }
}