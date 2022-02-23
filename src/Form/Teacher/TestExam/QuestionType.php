<?php
declare(strict_types=1);

namespace App\Form\Teacher\TestExam;


use App\Entity\Exam\Question\Question;
use App\Validation\ValidationGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

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
            'constraints' => [
                new NotBlank(['groups' => ValidationGroup::GROUP_DEFAULT])
            ]
        ]);

        $builder->add('text', TextareaType::class, [
            'label' => 'Въпрос',
            'attr' => ['placeholder' => 'Същност на въпроса', 'rows' => '3'],
             'constraints' => [
                 new NotBlank(['groups' => ValidationGroup::GROUP_DEFAULT])
             ]
        ]);

        $builder->add('textLength', IntegerType::class, [
            'label' => 'Мин. дължина на отговора',
            'attr' => ['placeholder' => 'Брой думи', 'min' => '1'],
            'constraints' => [
                new NotBlank(['groups' => ValidationGroup::GROUP_OPEN_QUESTION])
            ]
        ]);

        $builder->add('points', IntegerType::class, [
            'label' => 'Макс. точки',
            'attr' => ['placeholder' => 'Брой точки', 'min' => '1'],
            'constraints' => [
                new NotBlank(['groups' => ValidationGroup::GROUP_OPEN_QUESTION])
            ]
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
            'data_class' => Question::class,
            'validation_groups' => function (FormInterface $form) {
                $groups[] = ValidationGroup::GROUP_DEFAULT;
                /** @var Question $question */
                $question = $form->getData();

                if ($question->getType() == Question::TYPE_OPEN) {
                    $groups[] = ValidationGroup::GROUP_OPEN_QUESTION;
                }

                if ($question->getType() == Question::TYPE_CHOICES) {
                    $groups[] = ValidationGroup::GROUP_CHOICE_QUESTION;
                }

                return $groups;
            }
        ]);
    }
}