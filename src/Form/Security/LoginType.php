<?php
declare(strict_types=1);

namespace App\Form\Security;


use App\Validation\ValidationGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', EmailType::class, [
            'label' => 'Имейл',
            'attr' => [
                'placeholder' => 'имейл'
            ],
            'row_attr' => [
                'class' => 'form-floating my-3'
            ],
        ]);

        $builder->add('password', PasswordType::class, [
            'label' => 'Парола',
            'attr' => [
                'placeholder' => 'въведи парола'
            ],
            'row_attr' => [
                'class' => 'form-floating my-3'
            ],
        ]);
    }
}