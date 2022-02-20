<?php
declare(strict_types=1);

namespace App\Controller\Admin\Student;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("/student/group", name="student_group_")
 */
class GroupController extends AbstractController
{
    /**
     * @Route ("/list", name="list")
     */
    public function list(): Response
    {
        return $this->render("admin/student/pages/group/list.html.twig");
    }

    /**
     * @Route ("/{group}", name="show")
     */
    public function show(int $group): Response
    {
        return $this->render("admin/student/pages/group/show.html.twig", [
            'group' => $group
        ]);
    }
}