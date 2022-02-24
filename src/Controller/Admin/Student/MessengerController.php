<?php
declare(strict_types=1);

namespace App\Controller\Admin\Student;


use App\Entity\Message;
use App\Entity\User;
use App\Form\MessengerType;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function inbox(MessageRepository $messageRepo): Response
    {
        /** @var \App\Entity\Student $student */
        $student = $this->getUser();
        $messages = $messageRepo->findBy(['receiver' => $student]);

        return $this->render("admin/messenger/inbox.html.twig", [
            'student' => true,
            'messages' => $messages
        ]);
    }

    /**
     * @Route ("/read/{message}", name="read")
     */
    public function read(Message $message, EntityManagerInterface $em): Response
    {
        /** @var \App\Entity\Student $student */
        $student = $this->getUser();

        if($student == $message->getReceiver()) {
            $message->setIsReaded(true);
            $em->persist($message);
            $em->flush();
        }

        return $this->render("admin/messenger/read.html.twig", [
            'student' => true,
            'message' => $message
        ]);
    }

    /**
     * @Route ("/send/{receiver}", name="send_new", defaults={"receiver" :  null})
     */
    public function sendNew(Request $request, ?User $receiver, EntityManagerInterface $em): Response
    {
        /** @var \App\Entity\Student $student */
        $student = $this->getUser();
        if ($receiver == $student) {
            return $this->redirectToRoute('student_messenger_send_new');
        }

        $form = $this->createForm(MessengerType::class, null, ['receiver' => $receiver]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var \App\Entity\Message $message */
            $message = $form->getData();
            !empty($receiver) ? $message->setReceiver($receiver) : null;
            $message->setSender($student);
            $em->persist($message);
            $em->flush();
            $this->addFlash('success', 'Успешно изпратено съобщение');
            return $this->redirectToRoute('student_messenger_inbox');
        }

        return $this->render("admin/messenger/new.html.twig", [
            'student' => true,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("/sent", name="sent")
     */
    public function sent(MessageRepository $messageRepo): Response
    {
        /** @var \App\Entity\Student $student */
        $student = $this->getUser();
        $messages = $messageRepo->findBy(['sender' => $student]);

        return $this->render("admin/messenger/sent.html.twig", [
            'student' => true,
            'messages' => $messages
        ]);
    }
}