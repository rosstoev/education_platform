<?php
declare(strict_types=1);

namespace App\Form\Teacher\Exam;


use App\Entity\Exam\Answer\Answer;
use App\Entity\Exam\Question\Question;
use App\Validation\ValidationGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class AnswerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, [$this, 'preSetData']);
    }

    public function preSetData(FormEvent $event)
    {
        $form = $event->getForm();
        /** @var Answer $answer */
        $answer = $event->getData();
        $disabled = false;
        $label = 'Точки:';

        if ($answer->getType() == Question::TYPE_CHOICES) {
            $label = 'Получени точки:';
            $disabled = true;
        }

        $form->add('points', IntegerType::class, [
            'label' => $label,
            'disabled' => $disabled,
            'constraints' => [
                new NotBlank([
                    'groups' => [ValidationGroup::GROUP_DEFAULT]
                ])
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        return $resolver->setDefaults([
            'required' => false,
            'data_class' => Answer::class
        ]);
    }
}