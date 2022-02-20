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

    /**
     * @Route ("", name="new")
     */
    public function create(): Response
    {
        return $this->render("admin/teacher/pages/lecture/manage.html.twig");
    }

    /**
     * @Route ("/{lecture}/edit", name="edit")
     */
    public function edit(int $lecture): Response
    {
        return $this->render("admin/teacher/pages/lecture/manage.html.twig");
    }

    /**
     * @Route ("/{lecture}", name="show")
     */
    public function show(int $lecture): Response
    {

        return $this->render("admin/teacher/pages/lecture/show.html.twig", [
            'lecture' => $lecture
        ]);
    }

    /**
     * @Route ("/{lecture}/delete", name="delete")
     */
    public function delete(int $lecture)
    {

    }
}