<?php
declare(strict_types=1);

namespace App\Controller\Admin\Teacher;


use App\Entity\Education\Lecture;
use App\Form\Teacher\Lecture\FilterLectureType;
use App\Form\Teacher\Lecture\LectureType;
use App\Repository\Education\LectureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function list(Request $request, LectureRepository $lectureRepo): Response
    {
        /** @var \App\Entity\Teacher $teacher */
        $teacher = $this->getUser();

        $form = $this->createForm(FilterLectureType::class);
        $form->handleRequest($request);
        $formData = $form->getData();
        $lectures = $lectureRepo->findByTeacher($teacher, $formData);

        return $this->render("admin/teacher/pages/lecture/list.html.twig", [
            'form' => $form->createView(),
            'lectures' => $lectures
        ]);
    }

    /**
     * @Route ("", name="new")
     */
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(LectureType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var \App\Entity\Education\Lecture $lecture */
            $lecture = $form->getData();
            $em->persist($lecture);
            $em->flush();
            $this->addFlash('createLectureSuccess', \sprintf('Занятието на тема "%s" е създадена успешно', $lecture->getName()));
            return $this->redirectToRoute('teacher_lecture_show', ['lecture' => $lecture->getId()]);

        }

        return $this->render("admin/teacher/pages/lecture/manage.html.twig", [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("/{lecture}/edit", name="edit")
     */
    public function edit(Request $request,Lecture $lecture, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(LectureType::class, $lecture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var \App\Entity\Education\Lecture $lecture */
            $lecture = $form->getData();
            $em->persist($lecture);
            $em->flush();
            $this->addFlash('createLectureSuccess', \sprintf('Занятието на тема "%s" е редактирано успешно', $lecture->getName()));
            return $this->redirectToRoute('teacher_lecture_show', ['lecture' => $lecture->getId()]);

        }

        return $this->render("admin/teacher/pages/lecture/manage.html.twig", [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("/{lecture}", name="show")
     */
    public function show(Lecture $lecture): Response
    {

        return $this->render("admin/teacher/pages/lecture/show.html.twig", [
            'lecture' => $lecture
        ]);
    }

    /**
     * @Route ("/{lecture}/delete", name="delete")
     */
    public function delete(Lecture $lecture, EntityManagerInterface $em)
    {
        $em->remove($lecture);
        $em->flush();
        $this->addFlash('deleteLectureSuccess', 'Занятието е изтрита успешно.');
        return $this->redirectToRoute('teacher_lecture_list');
    }
}