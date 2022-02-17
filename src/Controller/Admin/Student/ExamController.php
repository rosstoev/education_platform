<?php
declare(strict_types=1);

namespace App\Controller\Admin\Student;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("/student/exam", name="student_exam_")
 */
class ExamController extends AbstractController
{
    /**
     * @Route ("/list", name="list")
     */
    public function list(): Response
    {
        return $this->render('admin/student/pages/exam/list.html.twig');
    }
}