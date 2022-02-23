<?php
declare(strict_types=1);

namespace App\Handler;


use App\Entity\Message;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class MessengerHandler
{
    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function send(Message $message, User $sender)
    {

    }
}