<?php
declare(strict_types=1);

namespace App\Handler;


use App\DTO\UserDTO;
use App\Entity\Student;
use App\Entity\Teacher;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserHandler
{

    private EntityManagerInterface $em;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher)
    {
        $this->em = $em;
        $this->passwordHasher = $passwordHasher;
    }

    public function register(UserDTO $userDTO)
    {
        if ($userDTO->getType() == UserDTO::TEACHER) {
            $user = new Teacher();
        } else {
            $user = new Student();
            $user->setCourseNumber($userDTO->getCourseNumber());
        }

        $user->setEmail($userDTO->getEmail());
        $hashPassword = $this->passwordHasher->hashPassword($user, $userDTO->getPassword());
        $user->setPassword($hashPassword);
        $user->setMobileNumber($userDTO->getMobileNumber());
        $user->setFirstName($userDTO->getFirstName());
        $user->setSecondName($userDTO->getSecondName());
        $user->setLastName($userDTO->getLastName());
        $user->setRoles(['ROLE_USER']);
        $this->em->persist($user);

    }
}