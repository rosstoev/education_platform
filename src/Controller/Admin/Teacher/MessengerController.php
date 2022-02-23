<?php
declare(strict_types=1);

namespace App\Controller\Admin\Teacher;


use App\Entity\Message;
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
    public function read(Message $message): Response
    {
        return $this->render("admin/messenger/read.html.twig", [
            'teacher' => true,
            'message' => $message
        ]);
    }

    /**
     * @Route ("/send", name="send_new")
     */
    public function sendNew(Request $request, EntityManagerInterface $em): Response
    {
        /** @var \App\Entity\Teacher $teacher */
        $teacher = $this->getUser();
        $form = $this->createForm(MessengerType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var \App\Entity\Message $message */
            $message = $form->getData();
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
     * @Route ("/sended", name="sended")
     */
    public function sended(): Response
    {
        return $this->render("admin/messenger/sended.html.twig", [
            'teacher' => true
        ]);
    }
}