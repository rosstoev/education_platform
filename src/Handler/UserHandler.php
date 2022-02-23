<?php
declare(strict_types=1);

namespace App\Handler;


use App\DTO\UserDTO;
use App\Entity\Student;
use App\Entity\Teacher;
use App\Entity\User;
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

    public function createDTO(User $user): UserDTO
    {
        $userDTO = new UserDTO();
        $userDTO->setFirstName($user->getFirstName());
        $userDTO->setSecondName($user->getSecondName());
        $userDTO->setLastName($user->getLastName());
        $userDTO->setEmail($user->getEmail());
        $userDTO->setMobileNumber($user->getMobileNumber());

        if ($user instanceof Student) {
            $userDTO->setCourseNumber($user->getCourseNumber());
        }

        return $userDTO;
    }

    public function update(User $user, UserDTO $userDTO): void
    {
        $user->setMobileNumber($userDTO->getMobileNumber());
        $user->setFirstName($userDTO->getFirstName());
        $user->setSecondName($userDTO->getSecondName());
        $user->setLastName($userDTO->getLastName());
        $user->setEmail($userDTO->getEmail());
        if ($user instanceof Student) {
            $user->setCourseNumber($userDTO->getCourseNumber());
        }
        $this->em->persist($user);
    }
}