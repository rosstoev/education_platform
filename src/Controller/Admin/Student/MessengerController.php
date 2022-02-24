<?php
declare(strict_types=1);

namespace App\Controller\Admin\Student;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("/student/messenger", name="student_messenger_")
 */
class MessengerController extends AbstractController
{
    /**
     * @Route ("/inbox", name="inbox")
     */
    public function inbox(): Response
    {

        return $this->render("admin/messenger/inbox.html.twig", [
            'student' => true
        ]);
    }

    /**
     * @Route ("/read/{message}", name="read")
     */
    public function read(int $message): Response
    {
        return $this->render("admin/messenger/read.html.twig", [
            'student' => true
        ]);
    }

    /**
     * @Route ("/send", name="send_new")
     */
    public function sendNew(): Response
    {
        return $this->render("admin/messenger/new.html.twig", [
            'student' => true
        ]);
    }

    /**
     * @Route ("/sended", name="sended")
     */
    public function sended(): Response
    {
        return $this->render("sent.html.twig", [
            'student' => true
        ]);
    }
}