<?php
declare(strict_types=1);

namespace App\Controller\Admin\Teacher;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("/teacher/discipline", name="teacher_discipline_")
 */
class DisciplineController extends AbstractController
{
    /**
     * @Route("/list", name="list")
     */
    public function list(): Response
    {
        return $this->render('admin/teacher/pages/discipline/list.html.twig');
    }

    /**
     * @Route ("", name="new")
     */
    public function create(): Response
    {
        return $this->render('admin/teacher/pages/discipline/manage.html.twig');
    }

    /**
     * @Route ("/{discipline}", name="show")
     */
    public function show(int $discipline)
    {
        return $this->render("admin/teacher/pages/discipline/show.html.twig");
    }

    /**
     * @Route ("/{discipline}/edit", name="edit")
     */
    public function edit(int $discipline): Response
    {
        return $this->render('admin/teacher/pages/discipline/manage.html.twig');
    }

    /**
     * @Route ("/{discipline}/delete", name="delete")
     */
    public function delete(int $discipline)
    {

    }

}