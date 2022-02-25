<?php
declare(strict_types=1);

namespace App\Form;


use App\DTO\UserDTO;
use App\Validation\ValidationGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $userType = $options['userType'];

        $builder->add('firstName', TextType::class, [
            'label' => 'Име',
            'attr' => [
                'placeholder' => 'Име'
            ],
            'constraints' => [
                new NotBlank(),
            ]
        ]);

        $builder->add('secondName', TextType::class, [
            'label' => 'Презиме',
            'attr' => [
                'placeholder' => 'Презиме'
            ],
            'constraints' => [
                new NotBlank()
            ]
        ]);

        $builder->add('lastName', TextType::class, [
            'label' => 'Фамилия',
            'attr' => [
                'placeholder' => 'Фамилия'
            ],
            'constraints' => [
                new NotBlank()
            ]
        ]);

        $builder->add('email', EmailType::class, [
            'required' => false,
            'label' => 'Имейл адрес',
            'attr' => [
                'placeholder' => 'имейл адрес'
            ],
            'constraints' => [
                new NotBlank(),
                new Email(['mode' => 'html5'])
            ]

        ]);

        $builder->add('mobileNumber', TextType::class, [
            'label' => '+359',
            'row_attr' => [
                'class' => 'input-group mb-3'
            ],
            'attr' => ['placeholder' => 'XXXXXXXXX'],
            'constraints' => [
                new Length([
                    'max' => 9,
                    'min' => 9,
                ])
            ]
        ]);

        if ($userType == UserDTO::STUDENT) {
            $builder->add('courseNumber', TextType::class, [
                'label' => 'Курсов номер',
                'attr' => [
                    'placeholder' => 'Курсов номер'
                ],
                'constraints' => [
                    new NotBlank()
                ]
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        return $resolver->setDefaults([
            'required' => false,
            'data_class' => UserDTO::class,
            'userType' => null
        ]);
    }
}