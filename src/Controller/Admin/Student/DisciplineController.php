<?php
declare(strict_types=1);

namespace App\Controller\Admin\Student;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("/student/discipline", name="student_discipline_")
 */
class DisciplineController extends AbstractController
{
    /**
     * @Route ("/{discipline}", name="show")
     */
    public function show(int $discipline): Response
    {
        return $this->render("admin/student/pages/discipline/show.html.twig");
    }
}