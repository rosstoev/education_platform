<?php
declare(strict_types=1);

namespace App\Form\Teacher\TestExam;


use App\DTO\UserDTO;
use App\Entity\Exam\Question\Question;
use App\Validation\ValidationGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('type', ChoiceType::class, [
            'label' => 'Тип въпрос',
            'expanded' => true,
            'placeholder' => false,
            'choices' => ['Отворен' => Question::TYPE_OPEN, 'С отговори' => Question::TYPE_CHOICES],
            'label_attr' => [
                'class' => 'radio-inline'
            ],
        ]);

        $builder->add('text', TextareaType::class, [
            'label' => 'Въпрос',
            'attr' => ['placeholder' => 'Същност на въпроса', 'rows' => '3']
        ]);

        $builder->add('textLength', IntegerType::class, [
            'label' => 'Мин. дължина на отговора',
            'attr' => ['placeholder' => 'Брой думи', 'min' => '1']
        ]);

        $builder->add('points', IntegerType::class, [
            'label' => 'Макс. точки',
            'attr' => ['placeholder' => 'Брой точки', 'min' => '1']
        ]);

        $builder->add('choices', CollectionType::class, [
            'entry_type' => QuestionChoiceType::class,
            'label' => false,
            'entry_options' => ['label' => false],
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false
        ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        return $resolver->setDefaults([
            'required' => false,
            'data_class' => Question::class
        ]);
    }
}