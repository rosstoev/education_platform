<?php
declare(strict_types=1);

namespace App\Controller\Admin\Teacher;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("/teacher/messenger", name="teacher_messenger_")
 */
class MessengerController extends AbstractController
{
    /**
     * @Route ("/inbox", name="inbox")
     */
    public function inbox(): Response
    {

        return $this->render("admin/messenger/inbox.html.twig", [
            'teacher' => true
        ]);
    }

    /**
     * @Route ("/read/{message}", name="read")
     */
    public function read(int $message): Response
    {
        return $this->render("admin/messenger/read.html.twig", [
            'teacher' => true
        ]);
    }

    /**
     * @Route ("/send", name="send_new")
     */
    public function sendNew(): Response
    {
        return $this->render("admin/messenger/new.html.twig", [
            'teacher' => true
        ]);
    }

    /**
     * @Route ("/sended", name="sended")
     */
    public function sended(): Response
    {
        return $this->render("admin/messenger/sended.html.twig", [
            'teacher' => true
        ]);
    }
}