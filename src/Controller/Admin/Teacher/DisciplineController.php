<?php
declare(strict_types=1);

namespace App\Controller\Admin\Teacher;


use App\Entity\Education\Discipline;
use App\Entity\Teacher;
use App\Form\Teacher\DisciplineType;
use App\Repository\Education\DisciplineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
        /** @var Teacher $teacher */
        $teacher = $this->getUser();

        return $this->render('admin/teacher/pages/discipline/list.html.twig', [
            'disciplines' => $teacher->getDisciplines()
        ]);
    }

    /**
     * @Route ("", name="new")
     */
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        /** @var Teacher $teacher */
        $teacher = $this->getUser();
        $form = $this->createForm(DisciplineType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Discipline $discipline */
            $discipline = $form->getData();
            $discipline->setTeacher($teacher);
            $em->persist($discipline);
            $em->flush();
            $this->addFlash('createDisciplineSuccess', \sprintf('Дисциплината "%s" е създадена успешно', $discipline->getName()));

            return $this->redirectToRoute('teacher_discipline_show', ['discipline' => $discipline->getId()]);
        }

        return $this->render('admin/teacher/pages/discipline/manage.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("/{discipline}", name="show")
     */
    public function show(Discipline $discipline): Response
    {
        return $this->render("admin/teacher/pages/discipline/show.html.twig", [
            'discipline' => $discipline
        ]);
    }

    /**
     * @Route ("/{discipline}/edit", name="edit")
     */
    public function edit(Request $request,Discipline $discipline, EntityManagerInterface $em): Response
    {
        /** @var Teacher $teacher */
        $teacher = $this->getUser();
        $form = $this->createForm(DisciplineType::class, $discipline);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Discipline $discipline */
            $discipline = $form->getData();
            $discipline->setTeacher($teacher);
            $em->persist($discipline);
            $em->flush();
            $this->addFlash('createDisciplineSuccess', \sprintf('Дисциплината "%s" е редактирана успешно', $discipline->getName()));

            return $this->redirectToRoute('teacher_discipline_show', ['discipline' => $discipline->getId()]);
        }

        return $this->render('admin/teacher/pages/discipline/manage.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("/{discipline}/delete", name="delete")
     */
    public function delete(Discipline $discipline, EntityManagerInterface $em): Response
    {
        $em->remove($discipline);
        $em->flush();
        $this->addFlash('deleteDisciplineSuccess', 'Дисциплината е изтрита успешно.');
        return $this->redirectToRoute('teacher_discipline_list');
    }

}