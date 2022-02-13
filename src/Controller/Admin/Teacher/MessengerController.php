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

        return $this->render("admin/teacher/pages/messenger/inbox.html.twig");
    }

    /**
     * @Route ("/read/{message}", name="read")
     */
    public function read(int $message): Response
    {
        return $this->render("admin/teacher/pages/messenger/read.html.twig");
    }

    /**
     * @Route ("/send", name="send")
     */
    public function sendNew(): Response
    {
        return $this->render("admin/teacher/pages/messenger/new.html.twig");
    }

    /**
     * @Route ("/sended", name="sended")
     */
    public function sended(): Response
    {
        return $this->render("admin/teacher/pages/messenger/sended.html.twig");
    }
}