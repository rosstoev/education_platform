<?php
declare(strict_types=1);

namespace App\Validation;


use App\DTO\UserDTO;
use Symfony\Component\Form\FormInterface;

class RegistrationResolver
{

    public function __invoke(FormInterface $form): iterable
    {
        /** @var UserDTO $user */
        $user = $form->getData();
        $groups[] = ValidationGroup::GROUP_DEFAULT;

        if ($user->getType() == UserDTO::STUDENT) {
            $groups[] = ValidationGroup::GROUP_STUDENT;
        }

        return $groups;
    }
}