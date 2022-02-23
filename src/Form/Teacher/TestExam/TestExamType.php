<?php
declare(strict_types=1);

namespace App\Form\Teacher\TestExam;


use App\Entity\Exam\Test;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class TestExamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class, [
            'label' => 'Заглавие',
            'attr' => ['placeholder' => 'Име на теста'],
            'constraints' => new NotBlank()
        ]);

        $builder->add('questions', CollectionType::class, [
            'entry_type' => QuestionType::class,
            'entry_options' => ['label' => false],
            'label' => false,
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        return $resolver->setDefaults([
            'required' => false,
            'data_class' => Test::class
        ]);
    }
}