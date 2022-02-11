<?php

declare(strict_types=1);

namespace App\Controller\Admin\Teacher;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("/teacher/group", name="teacher_group_")
 */
class GroupController extends AbstractController
{
    /**
     * @Route ("/list", name="list")
     */
    public function list(): Response
    {
        return $this->render("admin/teacher/pages/group/list.html.twig");
    }

    /**
     * @Route ("", name="new")
     */
    public function create(): Response
    {
        return $this->render("admin/teacher/pages/group/manage.html.twig");
    }

    /**
     * @Route ("/{group}/edit", name="edit")
     */
    public function edit(int $group): Response
    {
        return $this->render("admin/teacher/pages/group/manage.html.twig");
    }

    /**
     * @Route ("/{group}", name="show")
     */
    public function show(int $group): Response
    {
        return $this->render('admin/teacher/pages/group/show.html.twig', [
            'group' => $group
        ]);
    }
}