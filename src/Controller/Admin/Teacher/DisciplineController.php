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
        return $this->render('admin/teacher/pages/discipline/new.html.twig');
    }
}