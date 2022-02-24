<?php
declare(strict_types=1);

namespace App\Controller\Ajax\Teacher;


use App\Entity\Education\Lecture;
use App\Form\Teacher\Lecture\LectureType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("/teacher/ajax/lecture", name="teacher_ajax_lecture_")
 */
class LectureController extends AbstractController
{
    /**
     * @Route ("/discipline-group", name="discipline_group", methods={"POST"})
     */
    public function disciplineGroup(Request $request): JsonResponse
    {
        $form = $this->createForm(LectureType::class);
        $form->handleRequest($request);
        /** @var Lecture $formData */
        $formData = $form->getData();
        !empty($formData) ? $formData->setStudentGroup(null) : null;
        $form = $this->createForm(LectureType::class, $formData);

        $template = $this->renderView('admin/teacher/form/lecture/discipline_group.html.twig', [
            'form' => $form->createView()
        ]);

        return new JsonResponse([
            'output' => $template
        ]);

    }
}