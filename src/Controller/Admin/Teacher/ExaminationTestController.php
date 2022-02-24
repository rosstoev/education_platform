<?php
declare(strict_types=1);

namespace App\Controller\Admin\Teacher;


use App\Entity\Exam\Question\Choice;
use App\Entity\Exam\Question\Question;
use App\Entity\Exam\Test;
use App\Form\Teacher\TestExam\FilterTestExamType;
use App\Form\Teacher\TestExam\TestExamType;
use App\Repository\Exam\TeacherExamRepository;
use App\Repository\Exam\TestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("/teacher/test", name="teacher_test_")
 */
class ExaminationTestController extends AbstractController
{
    /**
     * @Route ("/list", name="list")
     */
    public function list(Request $request, TestRepository $testRepo): Response
    {
        /** @var \App\Entity\Teacher $teacher */
        $teacher = $this->getUser();
        $form = $this->createForm(FilterTestExamType::class);
        $form->handleRequest($request);
        $formData = $form->getData();

        $tests = $testRepo->findByTeacher($teacher, $formData);
        return $this->render("admin/teacher/pages/examination-test/list.html.twig",[
            'tests' => $tests,
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

        $test = new Test();
        $question = new Question();
        $choice = new Choice();
        $question->addChoice($choice);
        $test->addQuestion($question);

        $form = $this->createForm(TestExamType::class, $test);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Test $test */
            $test = $form->getData();
            $test->setAuthor($teacher);
            $em->persist($test);
            $em->flush();

            $this->addFlash('createTestSuccess', \sprintf('Тест "%s" е създадена успешно', $test->getTitle()));
            return $this->redirectToRoute('teacher_test_show', ['test' => $test->getId()]);
        }

        return $this->render("admin/teacher/pages/examination-test/manage.html.twig", [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("/{test}/edit", name="edit")
     */
    public function edit(Request $request,Test $test, EntityManagerInterface $em): Response
    {
        /** @var \App\Entity\Teacher $teacher */
        $teacher = $this->getUser();
        $form = $this->createForm(TestExamType::class, $test);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Test $test */
            $test = $form->getData();
            foreach ($test->getQuestions() as $question) {
                $question->setChoicePoints();
            }
            $test->setAuthor($teacher);
            $em->persist($test);
            $em->flush();

            $this->addFlash('createTestSuccess', \sprintf('Тест "%s" е редактиран успешно', $test->getTitle()));
            return $this->redirectToRoute('teacher_test_show', ['test' => $test->getId()]);
        }

        return $this->render("admin/teacher/pages/examination-test/manage.html.twig", [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("/{test}/delete", name="delete")
     */
    public function delete(Test $test, EntityManagerInterface $em, TeacherExamRepository $examRepository): Response
    {
        $foundedExam = $examRepository->findOneBy(['test' => $test]);
        if ($foundedExam) {
            $this->addFlash('deleteTestSuccess', 'Тестът не може да бъде изтрит, тъй като е добавен в изпит.');
            return $this->redirectToRoute('teacher_test_list');
        }

        $em->remove($test);
        $em->flush();
        $this->addFlash('deleteTestSuccess', 'Тестът е изтрит успешно.');
        return $this->redirectToRoute('teacher_test_list');
    }

    /**
     * @Route ("/{test}", name="show")
     */
    public function show(Test $test): Response
    {
        return $this->render("admin/teacher/pages/examination-test/show.html.twig", [
            'test' => $test
        ]);
    }
}