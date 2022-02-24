<?php
declare(strict_types=1);

namespace App\Controller\Admin\Student;


use App\Entity\Education\Group;
use App\Form\Student\FilterGroupType;
use App\Repository\Education\GroupRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function list(Request $request, GroupRepository $groupRepo): Response
    {
        /** @var \App\Entity\Student $student */
        $student = $this->getUser();

        $form = $this->createForm(FilterGroupType::class);
        $form->handleRequest($request);
        $formData = $form->getData();

        $groups = $groupRepo->findByStudent($student, $formData);

        return $this->render("admin/student/pages/group/list.html.twig", [
            'groups' => $groups,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("/{group}", name="show")
     */
    public function show(Group $group): Response
    {
        return $this->render("admin/student/pages/group/show.html.twig", [
            'group' => $group
        ]);
    }
}