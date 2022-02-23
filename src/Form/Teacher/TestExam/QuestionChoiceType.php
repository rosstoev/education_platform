<?php
declare(strict_types=1);

namespace App\Form\Teacher\TestExam;


use App\Entity\Exam\Question\Choice;
use App\Validation\ValidationGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class QuestionChoiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('possibility', TextType::class, [
            'label' => 'Отговор',
            'attr' => ['placeholder' => 'Отговор'],
            'constraints' => [
                new NotBlank(['groups' => ValidationGroup::GROUP_CHOICE_QUESTION])
            ]
        ]);

        $builder->add('isCorrect', ChoiceType::class, [
            'label' => 'Верен',
            'expanded' => true,
            'placeholder' => false,
            'choices' => ['Да' => 1, 'Не' => 0],
            'label_attr' => [
                'class' => 'radio-inline'
            ],
            'constraints' => [
                new NotBlank(['groups' => ValidationGroup::GROUP_CHOICE_QUESTION])
            ]
        ]);

        $builder->add('points', IntegerType::class, [
            'label' => 'Точки',
            'attr' => ['placeholder' => 'Брой точки', 'min' => '0'],
            'constraints' => [
                new NotBlank(['groups' => ValidationGroup::GROUP_CHOICE_QUESTION])
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        return $resolver->setDefaults([
            'required' => false,
            'data_class' => Choice::class
        ]);
    }
}