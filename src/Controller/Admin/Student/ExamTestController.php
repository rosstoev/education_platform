<?php
declare(strict_types=1);

namespace App\Controller\Admin\Student;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("/student/test", name="student_test_")
 */
class ExamTestController extends AbstractController
{
    /**
     * @Route ("/take/{examToken}", name="take")
     */
    public function take(int $examToken): Response
    {
        return $this->render('admin/student/pages/exam/take.html.twig');
    }
}