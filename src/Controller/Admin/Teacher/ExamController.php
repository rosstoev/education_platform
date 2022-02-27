<?php
declare(strict_types=1);

namespace App\Controller\Admin\Teacher;


use App\DTO\Exam\EstimationDTO;
use App\Entity\Education\Group;
use App\Entity\Exam\Question\Question;
use App\Entity\Exam\StudentExam;
use App\Entity\Exam\TeacherExam;
use App\Entity\Teacher;
use App\Form\Teacher\Exam\EstimateType;
use App\Form\Teacher\Exam\ExamType;
use App\Form\Teacher\Exam\FilterExamType;
use App\Form\Teacher\Exam\GroupExamType;
use App\Form\Teacher\Exam\StudentExamType;
use App\Handler\StudentExamHandler;
use App\Repository\Exam\StudentExamRepository;
use App\Repository\Exam\TeacherExamRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Comparison;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function list(Request $request,TeacherExamRepository $teacherRepo): Response
    {
        $form = $this->createForm(FilterExamType::class);
        $form->handleRequest($request);
        $filter = $form->getData();

        $exams = $teacherRepo->findByTeacher($this->getUser(), $filter);
        return $this->render('admin/teacher/pages/exam/list.html.twig', [
            'exams' => $exams,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("", name="new")
     */
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        /** @var \App\Entity\Teacher $teacher */
        $teacher = $this->getUser();
        $form = $this->createForm(ExamType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var \App\Entity\Exam\TeacherExam $exam */
            $exam = $form->getData();
            $exam->setCreator($teacher);
            $exam->createToken();
            $exam->createEndAt();
            $em->persist($exam);
            $em->flush();

            $this->addFlash('createExamSuccess', \sprintf('Изпит "%s" е създаден успешно', $exam->getToken()));
            return $this->redirectToRoute('teacher_exam_show', ['exam' => $exam->getId()]);

        }

        return $this->render('admin/teacher/pages/exam/manage.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("/{exam}", name="show")
     */
    public function show(Request $request, TeacherExam $exam): Response
    {
        $exam->createExecutionMinutes();
        $form = $this->createForm(GroupExamType::class, null, ['discipline' => $exam->getDiscipline()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $group = $form->getData()->getStudentGroup();
            return $this->redirectToRoute('teacher_exam_add_student', ['exam' => $exam->getId(), 'group' => $group->getId()]);
        }

        return $this->render('admin/teacher/pages/exam/show.html.twig', [
            'exam' => $exam,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("/{exam}/edit", name="edit")
     */
    public function edit(Request $request,TeacherExam $exam, EntityManagerInterface $em): Response
    {
        $exam->createExecutionMinutes();
        /** @var \App\Entity\Teacher $teacher */
        $teacher = $this->getUser();
        $form = $this->createForm(ExamType::class, $exam);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var \App\Entity\Exam\TeacherExam $exam */
            $exam = $form->getData();
            $exam->setCreator($teacher);
            $exam->createEndAt();
            $em->persist($exam);
            $em->flush();

            $this->addFlash('createExamSuccess', \sprintf('Изпит "%s" е редактиран успешно', $exam->getToken()));
            return $this->redirectToRoute('teacher_exam_show', ['exam' => $exam->getId()]);

        }

        return $this->render("admin/teacher/pages/exam/manage.html.twig", [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("/{exam}/delete", name="delete")
     */
    public function delete(TeacherExam $exam, EntityManagerInterface $em): Response
    {
        $em->remove($exam);
        $em->flush();
        $this->addFlash('examListWarning', 'Занятието е изтрито.');
        return $this->redirectToRoute('teacher_exam_list');

    }

    /**
     * @Route ("/{exam}/add-student/{group}", name="add_student")
     */
    public function addStudent(
        Request $request,
        TeacherExam $exam,
        Group $group,
        EntityManagerInterface $em,
        StudentExamHandler $studentExamHandler
    ): Response
    {
        /** @var \App\Entity\Teacher $teacher */
        $teacher = $this->getUser();
        $examDiscipline = $exam->getDiscipline();
        $groupDisciplines = $group->getDisciplines();
        if ($teacher !== $exam->getCreator() && $teacher !== $group->getTeacher()) {
            $this->addFlash('examListWarning', 'Вие не сте създадел на този изпит или група.');
            return $this->redirectToRoute('teacher_exam_list');
        }

        if (!$groupDisciplines->contains($examDiscipline)) {
            $this->addFlash('examListWarning', 'Избраната група не присъства в изпита.');
            return $this->redirectToRoute('teacher_exam_list');
        }

        $form = $this->createForm(StudentExamType::class, null, ['group' => $group, 'exam' => $exam]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $students = $form->getData()->getStudents();
            $em->beginTransaction();
            try {
                $studentExamHandler->create($students, $exam);
                $em->flush();
                $em->commit();
                $this->addFlash('success', 'Участниците бяха добавени успешно.');
                return $this->redirectToRoute('teacher_exam_show', ['exam' => $exam->getId()]);
            } catch (\Exception $ex) {
                $em->rollback();
                $this->addFlash('error', 'Нещо се обърка, опитайте отново.');
            }
        }

        return $this->render('admin/teacher/pages/exam/add-student.html.twig', [
            'exam' => $exam,
            'group' => $group,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("/{exam}/finished/list", name="finished_exam_list")
     */
    public function finishedExamList(TeacherExam $exam, StudentExamRepository $studentExamRepo): Response
    {
        $studentExams = $studentExamRepo->findBy(['teacherExam' => $exam]);

        return $this->render("admin/teacher/pages/exam/finished/list.html.twig", [
            'studentExams' => $studentExams
        ]);
    }

    /**
     * @Route ("/{exam}/finished/detail/{studentExam}", name="finished_exam_detail")
     */
    public function finishedExamDetail(TeacherExam $exam, StudentExam $studentExam): Response
    {
        return $this->render("admin/teacher/pages/exam/finished/show.html.twig", [
            'studentExam' => $studentExam
        ]);
    }

    /**
     * @Route ("/{exam}/finished/check/{studentExam}", name="finished_exam_check")
     */
    public function checkFinishedExam(
        Request $request,
        TeacherExam $exam,
        StudentExam $studentExam,
        StudentExamHandler $studentExamHandler,
        EntityManagerInterface $em
    ): Response
    {
        try {
            $studentExamHandler->validateForCheck($studentExam);
        } catch (\Exception $ex) {
            $this->addFlash('warning', $ex->getMessage());
            return $this->redirectToRoute('teacher_exam_finished_exam_detail', ['exam' => $exam->getId(), 'studentExam' => $studentExam->getId()]);
        }
        $estimationDTO = new EstimationDTO();
        $estimationDTO->setAnswers($studentExam->getAnswers());
        $maxPoints = 0;
        $answerPoints = 0;
        foreach ($exam->getTest()->getQuestions() as $question) {
            $maxPoints+= $question->getPoints();
        }

        foreach ($studentExam->getAnswers() as $answer) {
            $answerPoints+= $answer->getPoints();
        }

        $form = $this->createForm(EstimateType::class, $estimationDTO);
        $form->handleRequest($request);

        if ($form->get('check')->isClicked()) {
            /** @var EstimationDTO $data */
            $data = $form->getData();
            $temporaryEstimate = $studentExamHandler->temporaryEstimation($data, $maxPoints);
            $data->setEstimate($temporaryEstimate);
            $form = $this->createForm(EstimateType::class, $data);
        }

        if ($form->get('confirm')->isClicked()) {
            /** @var EstimationDTO $data */
            $data = $form->getData();
            foreach ($data->getAnswers() as $key => $answer) {
                if ($answer->getType() == Question::TYPE_OPEN) {
                    $studentExam->getAnswers()->get($key)->setPoints($answer->getPoints());
                }
            }
            $studentExam->setEvaluation($data->getEstimate());
            $em->beginTransaction();
            try {
                $em->persist($studentExam);
                $em->flush();
                $em->commit();
                $this->addFlash('success', 'Оценяването беше успешно!');
                return $this->redirectToRoute('teacher_exam_finished_exam_detail', ['exam' => $exam->getId(), 'studentExam' => $studentExam->getId()]);
            } catch (\Exception $ex) {
                $em->rollback();
                $this->addFlash('danger', 'Записа не може да бъде изпълнен, моля опитайте отново.');
            }
        }

        return $this->render('admin/teacher/pages/exam/finished/check.html.twig', [
            'form' => $form->createView(),
            'studentExam' => $studentExam,
            'maxPoints' => $maxPoints,
            'answerPoints' => $answerPoints

        ]);
    }
}