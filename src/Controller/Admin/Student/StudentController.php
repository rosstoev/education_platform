<?php

declare(strict_types=1);

namespace App\Controller\Admin\Student;


use App\DTO\UserDTO;
use App\Entity\Student;
use App\Entity\Teacher;
use App\Form\ProfileType;
use App\Handler\CalendarHandler;
use App\Handler\UserHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("/student", name="student_")
 */
class StudentController extends AbstractController
{
    /**
     * @Route ("/dashboard", name="dashboard")
     */
    public function dashboard(CalendarHandler $calendarHandler): Response
    {
        /** @var \App\Entity\Student $student */
        $student = $this->getUser();
        $events = $calendarHandler->getStudentEvents($student);

        return $this->render("admin/student/pages/dashboard.html.twig", [
            'calendarEvents' => $events
        ]);
    }

    /**
     * @Route ("/profile/show/{student}", name="profile", defaults={"student": null})
     */
    public function profile(?Student $student): Response
    {
        if (empty($student)) {
            /** @var Student $student */
            $student = $this->getUser();
        }
        return $this->render('admin/student/pages/profile/show.html.twig', [
            'student' => $student
        ]);
    }

    /**
     * @Route ("/profile/edit", name="profile_edit")
     */
    public function editProfile(Request $request, UserHandler $userHandler, EntityManagerInterface $em):Response
    {
        /** @var Student $student */
        $student = $this->getUser();
        $userDTO = $userHandler->createDTO($student);
        $form = $this->createForm(ProfileType::class, $userDTO, ['userType' => UserDTO::STUDENT]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userDTO = $form->getData();
            $userHandler->update($student, $userDTO);
            $em->flush();
            $this->addFlash('success', 'Информацията е обновена.');
            return $this->redirectToRoute('student_profile');
        }

        return $this->render('admin/student/pages/profile/manage.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("/profile/delete", name="profile_delete")
     */
    public function deleteProfile(EntityManagerInterface $em): Response
    {
        $student = $this->getUser();

        $em->remove($student);
        $em->flush();
        return $this->redirectToRoute('student_logout');

    }

    /**
     * @Route ("/teacher/{teacher}", name="teacher")
     */
    public function teacher(Teacher $teacher): Response
    {
        return $this->render("admin/student/pages/profile/teacher-page.html.twig", [
            'teacher' => $teacher
        ]);
    }
}