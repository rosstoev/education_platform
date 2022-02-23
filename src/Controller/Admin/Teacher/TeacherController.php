<?php

declare(strict_types=1);

namespace App\Controller\Admin\Teacher;

use App\DTO\UserDTO;
use App\Entity\Student;
use App\Form\ProfileType;
use App\Handler\CalendarHandler;
use App\Handler\UserHandler;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("/teacher", name="teacher_")
 */
class TeacherController extends AbstractController
{
    /**
     * @Route ("/dashboard", name="dashboard")
     */
    public function dashboard(CalendarHandler $calendarHandler): Response
    {
        /** @var \App\Entity\Teacher $teacher */
        $teacher = $this->getUser();
        $events = $calendarHandler->getTeacherEvents($teacher);
        dump($events);
        return $this->render('admin/teacher/pages/dashboard.html.twig', [
            'calendarEvents' => $events
        ]);
    }

    /**
     * @Route ("/profile", name="profile")
     */
    public function profile(): Response
    {
        /** @var \App\Entity\Teacher $teacher */
        $teacher = $this->getUser();

        return $this->render("admin/teacher/pages/profile/show.html.twig", [
            'teacher' => $teacher
        ]);
    }

    /**
     * @Route ("/profile/edit", name="profile_edit")
     */
    public function editProfile(Request $request, UserHandler $userHandler, EntityManagerInterface $em): Response
    {
        /** @var \App\Entity\Teacher $teacher */
        $teacher = $this->getUser();
        $userDTO = $userHandler->createDTO($teacher);

        $form = $this->createForm(ProfileType::class, $userDTO, ['userType' => UserDTO::TEACHER]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userDTO = $form->getData();
            $userHandler->update($teacher, $userDTO);
            $em->flush();
            $this->addFlash('success', 'Информацията е обновена.');
            return $this->redirectToRoute('teacher_profile');
        }

        return $this->render("admin/teacher/pages/profile/manage.html.twig", [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("/profile/delete", name="profile_delete")
     */
    public function deleteProfile(EntityManagerInterface $em): Response
    {
        /** @var \App\Entity\Teacher $teacher */
        $teacher = $this->getUser();
        $em->remove($teacher);
        $em->flush();

        return $this->redirectToRoute('teacher_logout');
    }

    /**
     * @Route ("/student/{student}", name="student_profile")
     */
    public function student(Student $student): Response
    {
        return $this->render("admin/teacher/pages/profile/student-page.html.twig", [
            'student' => $student
        ]);
    }
}