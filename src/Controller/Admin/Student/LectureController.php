<?php
declare(strict_types=1);

namespace App\Controller\Admin\Student;


use App\Entity\Education\Lecture;
use App\Form\Student\FilterLectureType;
use App\Repository\Education\LectureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function list(Request $request, LectureRepository $lectureRepo): Response
    {
        /** @var \App\Entity\Student $student */
        $student = $this->getUser();
        $form = $this->createForm(FilterLectureType::class);
        $form->handleRequest($request);
        $formData = $form->getData();

        $lectures = $lectureRepo->findByStudent($student, $formData);

        return $this->render("admin/student/pages/lecture/list.html.twig", [
            'lectures' => $lectures,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("/{lecture}", name="show")
     */
    public function show(Lecture $lecture): Response
    {

        return $this->render("admin/student/pages/lecture/show.html.twig", [
            'lecture' => $lecture
        ]);
    }
}