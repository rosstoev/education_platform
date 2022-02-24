<?php
declare(strict_types=1);

namespace App\Controller\Admin\Student;


use App\Entity\Exam\StudentExam;
use App\Form\Student\FilterExamType;
use App\Repository\Exam\StudentExamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function list(Request $request, StudentExamRepository $studentExamRepository): Response
    {
        /** @var \App\Entity\Student $student */
        $student = $this->getUser();
        $form = $this->createForm(FilterExamType::class);
        $form->handleRequest($request);
        $filter = $form->getData();

        $exams = $studentExamRepository->findByStudent($student, $filter);

        return $this->render('admin/student/pages/exam/list.html.twig', [
            'exams' => $exams,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("/result/{token}", name="result")
     */
    public function result(string $token, StudentExamRepository $studentExamRepo): Response
    {
        /** @var \App\Entity\Student $student */
        $student = $this->getUser();
        /** @var StudentExam $exam */
        $exam = $studentExamRepo->findByToken($student, $token);

        return $this->render('admin/student/pages/exam/result.html.twig', [
            'exam' => $exam
        ]);
    }
}