<?php

declare(strict_types=1);

namespace App\Controller\Admin\Teacher;


use App\Entity\Education\Group;
use App\Entity\Teacher;
use App\Form\Teacher\Group\FilterType;
use App\Form\Teacher\Group\GroupType;
use App\Repository\Education\GroupRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function list(Request $request, GroupRepository $groupRepo): Response
    {
        /** @var Teacher $teacher */
        $teacher = $this->getUser();

        $form = $this->createForm(FilterType::class);
        $form->handleRequest($request);
        /** @var \App\DTO\GroupFilterDTO $formData */
        $formData = $form->getData();

        $groups = $groupRepo->findByCriteria($teacher, $formData);

        return $this->render("admin/teacher/pages/group/list.html.twig", [
            'form' => $form->createView(),
            'groups' => $groups
        ]);
    }

    /**
     * @Route ("", name="new")
     */
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        /** @var Teacher $teacher */
        $teacher = $this->getUser();
        $form = $this->createForm(GroupType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var \App\Entity\Education\Group $group */
            $group = $form->getData();
            $group->setTeacher($teacher);
            $em->persist($group);
            $em->flush();

            $this->addFlash('createGroupSuccess', \sprintf('Група "%s" е създадена успешно', $group->getCourse()));
            return $this->redirectToRoute('teacher_group_show', ['group' => $group->getId()]);

        }

        return $this->render("admin/teacher/pages/group/manage.html.twig", [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("/{group}/edit", name="edit")
     */
    public function edit(Request $request, Group $group, EntityManagerInterface $em): Response
    {
        /** @var Teacher $teacher */
        $teacher = $this->getUser();
        $form = $this->createForm(GroupType::class, $group);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var \App\Entity\Education\Group $group */
            $group = $form->getData();
            $group->setTeacher($teacher);
            $em->persist($group);
            $em->flush();

            $this->addFlash('createGroupSuccess', \sprintf('Група "%s" е редактирана успешно', $group->getCourse()));
            return $this->redirectToRoute('teacher_group_show', ['group' => $group->getId()]);

        }

        return $this->render("admin/teacher/pages/group/manage.html.twig", [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("/{group}", name="show")
     */
    public function show(Group $group): Response
    {
        return $this->render('admin/teacher/pages/group/show.html.twig', [
            'group' => $group
        ]);
    }

    /**
     * @Route ("/{group}/delete", name="delete")
     */
    public function delete(Group $group, EntityManagerInterface $em): Response
    {
        $em->remove($group);
        $em->flush();

        $this->addFlash('deleteGroupSuccess', 'Групата е изтрита успешно.');
        return $this->redirectToRoute('teacher_group_list');
    }
}