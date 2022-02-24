<?php
declare(strict_types=1);

namespace App\Controller\Ajax;


use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessengerController extends AbstractController
{
    /**
     * @Route ("/teacher/messenger/ajax/unread-messages", name="teacher_messenger_ajax_unread_messages", methods={"POST"})
     */
    public function teacherUnreadMessages(MessageRepository $messageRepo): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        $result = 0;
        if(!empty($user)) {
            $result = $messageRepo->count(['receiver' => $user, 'isReaded' => false]);
        }

        return new JsonResponse([
            'result' => $result
        ]);

    }

    /**
     * @Route ("/student/messenger/ajax/unread-messages", name="student_messenger_ajax_unread_messages", methods={"POST"})
     */
    public function studentUnreadMessages(MessageRepository $messageRepo): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        $result = 0;
        if(!empty($user)) {
            $result = $messageRepo->count(['receiver' => $user, 'isReaded' => false]);
        }

        return new JsonResponse([
            'result' => $result
        ]);

    }
}