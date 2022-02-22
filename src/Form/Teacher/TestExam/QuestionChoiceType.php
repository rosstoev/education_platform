<?php
declare(strict_types=1);

namespace App\Form\Teacher\TestExam;


use App\Entity\Exam\Question\Choice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionChoiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('possibility', TextType::class, [
            'label' => 'Отговор',
            'attr' => ['placeholder' => 'Отговор']
        ]);

        $builder->add('isCorrect', ChoiceType::class, [
            'label' => 'Верен',
            'expanded' => true,
            'placeholder' => false,
            'choices' => ['Да' => true, 'Не' => false],
            'label_attr' => [
                'class' => 'radio-inline'
            ],
        ]);

        $builder->add('points', IntegerType::class, [
            'label' => 'Точки',
            'attr' => ['placeholder' => 'Брой точки', 'min' => '1']
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