<?php
declare(strict_types=1);

namespace App\Controller\Admin\Teacher;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/teacher/lecture", name="teacher_lecture_")
 */
class LectureController extends AbstractController
{
    /**
     * @Route ("/list", name="list")
     */
    public function list(): Response
    {
        return $this->render("admin/teacher/pages/lecture/list.html.twig");
    }
}