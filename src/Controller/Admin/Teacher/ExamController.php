<?php
declare(strict_types=1);

namespace App\Controller\Admin\Teacher;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("teacher/exam", name="teacher_exam_")
 */
class ExamController extends AbstractController
{
    /**
     * @Route ("/list", name="list")
     */
    public function list(): Response
    {
        return $this->render('admin/teacher/pages/exam/list.html.twig');
    }

    /**
     * @Route ("", name="new")
     */
    public function create(): Response
    {
        return $this->render('admin/teacher/pages/exam/manage.html.twig');
    }

    /**
     * @Route ("/{exam}", name="show")
     */
    public function show(int $exam): Response
    {
        return $this->render('admin/teacher/pages/exam/show.html.twig', [
            'exam' => $exam
        ]);
    }

    /**
     * @Route ("/{exam}/edit", name="edit")
     */
    public function edit(int $exam): Response
    {
        return $this->render("admin/teacher/pages/exam/manage.html.twig");
    }

    /**
     * @Route ("/{exam}/delete", name="delete")
     */
    public function delete(int $exam)
    {

    }

    /**
     * @Route ("/{exam}/add-student", name="add_student")
     */
    public function addStudent(int $exam): Response
    {

        return $this->render('admin/teacher/pages/exam/add-student.html.twig');
    }

    /**
     * @Route ("/{exam}/finished/list", name="finished_exam_list")
     */
    public function finishedExamList(int $exam): Response
    {
        return $this->render("admin/teacher/pages/exam/finished/list.html.twig");
    }

    /**
     * @Route ("/{exam}/finished/detail/{studentExam}", name="finished_exam_detail")
     */
    public function finishedExamDetail(int $exam, int $studentExam): Response
    {
        return $this->render("admin/teacher/pages/exam/finished/show.html.twig");
    }

    /**
     * @Route ("/{exam}/finished/check/{studentExam}", name="finished_exam_check")
     */
    public function checkFinishedExam(int $exam, int $studentExam): Response
    {
        return $this->render('admin/teacher/pages/exam/finished/check.html.twig');
    }
}