<?php
declare(strict_types=1);

namespace App\Form;


use App\DTO\UserDTO;
use App\Entity\User;
use App\Validation\RegistrationResolver;
use App\Validation\ValidationGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationType extends AbstractType
{

    private RegistrationResolver $resolver;

    public function __construct(RegistrationResolver $resolver)
    {
        $this->resolver = $resolver;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('type', ChoiceType::class, [
            'required' => false,
            'label' => false,
            'expanded' => true,
            'placeholder' => false,
            'choices' => ['Преподавател' => UserDTO::TEACHER, 'Ученик' => UserDTO::STUDENT],
            'label_attr' => [
                'class' => 'radio-inline'
            ],
            'constraints' => [
                new NotBlank([
                    'groups' => [ValidationGroup::GROUP_DEFAULT]
                ])
            ],
        ]);

        $builder->add('email', EmailType::class, [
            'required' => false,
            'label' => 'Имейл адрес',
            'attr' => [
                'placeholder' => 'имейл адрес'
            ],
            'row_attr' => [
                'class' => 'form-floating my-3'
            ],
            'constraints' => [
                new NotBlank([
                    'groups' => [ValidationGroup::GROUP_DEFAULT]
                ])
            ]

        ]);

        $builder->add('password', RepeatedType::class, [
            'required' => false,
            'type' => PasswordType::class,
            'invalid_message' => 'Паролите не съвпадат.',
            'first_options' => [
                'label' => 'Парола',
                'attr' => [
                    'placeholder' => 'въведи парола'
                ],
                'row_attr' => [
                    'class' => 'form-floating mb-3'
                ],
            ],
            'second_options' => [
                'label' => 'Потвърди парола',
                'attr' => [
                    'placeholder' => 'повтори въведената парола'
                ],
                'row_attr' => [
                    'class' => 'form-floating mb-2'
                ],
            ],
            'constraints' => [
                new NotBlank([
                    'groups' => [ValidationGroup::GROUP_DEFAULT]
                ])
            ]
        ]);

        $builder->add('mobileNumber', TextType::class, [
            'required' => false,
            'label' => '+359',
            'row_attr' => [
                'class' => 'input-group mb-3'
            ],
            'attr' => ['placeholder' => 'XXXXXXXXX']
        ]);

        $builder->add('firstName', TextType::class, [
            'required' => false,
            'label' => 'Име',
            'row_attr' => [
                'class' => 'form-floating my-3'
            ],
            'attr' => [
                'placeholder' => 'Име'
            ],
            'constraints' => [
                new NotBlank([
                    'groups' => [ValidationGroup::GROUP_DEFAULT]
                ])
            ]
        ]);

        $builder->add('secondName', TextType::class, [
            'required' => false,
            'label' => 'Презиме',
            'row_attr' => [
                'class' => 'form-floating mb-3'
            ],
            'attr' => [
                'placeholder' => 'Презиме'
            ],
            'constraints' => [
                new NotBlank([
                    'groups' => [ValidationGroup::GROUP_DEFAULT]
                ])
            ]
        ]);

        $builder->add('lastName', TextType::class, [
            'required' => false,
            'label' => 'Фамилия',
            'row_attr' => [
                'class' => 'form-floating mb-3'
            ],
            'attr' => [
                'placeholder' => 'Фамилия'
            ],
            'constraints' => [
                new NotBlank([
                    'groups' => [ValidationGroup::GROUP_DEFAULT]
                ])
            ]

        ]);
        $builder->add('courseNumber', TextType::class, [
            'required' => false,
            'label' => 'Курсов номер',
            'row_attr' => [
                'class' => 'form-floating mb-3 course-number-js',
                'style' => 'display: none'
            ],
            'attr' => [
                'placeholder' => 'Курсов номер'
            ],
            'constraints' => [
                new NotBlank([
                    'groups' => [ValidationGroup::GROUP_STUDENT]
                ])
            ]
        ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        return $resolver->setDefaults([
           'data_class' => UserDTO::class,
            'validation_groups' => $this->resolver
        ]);
    }
}