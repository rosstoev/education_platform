<?php
declare(strict_types=1);

namespace App\Controller\Admin\Teacher;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function list(): Response
    {
        return $this->render("admin/teacher/pages/examination-test/list.html.twig");
    }

    /**
     * @Route ("", name="new")
     */
    public function create(): Response
    {
        return $this->render("admin/teacher/pages/examination-test/manage.html.twig");
    }

    /**
     * @Route ("/{test}/edit", name="edit")
     */
    public function edit(int $test): Response
    {
        return $this->render("admin/teacher/pages/examination-test/manage.html.twig");
    }

    /**
     * @Route ("/{test}/delete", name="delete")
     */
    public function delete()
    {

    }

    /**
     * @Route ("/{test}", name="show")
     */
    public function show(int $test): Response
    {
        return $this->render("admin/teacher/pages/examination-test/show.html.twig", [
            'test' => $test
        ]);
    }
}