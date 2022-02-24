<?php
declare(strict_types=1);

namespace App\Controller\Admin\Teacher;


use App\Entity\Message;
use App\Entity\User;
use App\Form\MessengerType;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function inbox(MessageRepository $messengerRepo): Response
    {
        /** @var \App\Entity\Teacher $teacher */
        $teacher = $this->getUser();
        $messages = $messengerRepo->findBy(['receiver' => $teacher]);
        return $this->render("admin/messenger/inbox.html.twig", [
            'teacher' => true,
            'messages' => $messages
        ]);
    }

    /**
     * @Route ("/read/{message}", name="read")
     */
    public function read(Message $message, EntityManagerInterface $em): Response
    {
        $message->setIsReaded(true);
        $em->persist($message);
        $em->flush();

        return $this->render("admin/messenger/read.html.twig", [
            'teacher' => true,
            'message' => $message
        ]);
    }

    /**
     * @Route ("/send/{receiver}", name="send_new", defaults={"receiver":null})
     */
    public function sendNew(Request $request, EntityManagerInterface $em, ?User $receiver): Response
    {
        /** @var \App\Entity\Teacher $teacher */
        $teacher = $this->getUser();
        if ($receiver == $teacher) {
            return $this->redirectToRoute('teacher_messenger_send_new');
        }

        $form = $this->createForm(MessengerType::class, null, ['receiver' => $receiver]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var \App\Entity\Message $message */
            $message = $form->getData();
            !empty($receiver) ? $message->setReceiver($receiver) : null;
            $message->setSender($teacher);
            $em->persist($message);
            $em->flush();
            $this->addFlash('success', 'Успешно изпратено съобщение');
            return $this->redirectToRoute('teacher_messenger_inbox');
        }

        return $this->render("admin/messenger/new.html.twig", [
            'teacher' => true,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("/sent", name="sent")
     */
    public function sent(MessageRepository $messageRepo): Response
    {
        /** @var \App\Entity\Teacher $teacher */
        $teacher = $this->getUser();
        $messages = $messageRepo->findBy(['sender' => $teacher]);

        return $this->render("admin/messenger/sent.html.twig", [
            'teacher' => true,
            'messages' => $messages
        ]);
    }
}