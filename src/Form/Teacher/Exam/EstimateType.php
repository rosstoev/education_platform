<?php
declare(strict_types=1);

namespace App\Form\Teacher\Exam;


use App\DTO\Exam\EstimationDTO;
use App\Validation\ValidationGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class EstimateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('estimate', ChoiceType::class, [
            'label' => 'Оценка',
            'choices' => ['2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6],
            'placeholder' => 'Избери',
            'constraints' => [
                new NotBlank([
                    'groups' => [ValidationGroup::GROUP_DEFAULT]
                ])
            ]
        ]);

        $builder->add('answers', CollectionType::class, [
            'entry_type' => AnswerType::class,
            'label' => false
        ]);

        $builder->add('check', SubmitType::class, [
            'label' => 'Изчисли',
            'attr' => ['class' => 'btn btn-primary']
        ]);

        $builder->add('confirm', SubmitType::class, [
            'label' => 'Потвърди',
            'attr' => ['class' => 'btn btn-primary']
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        return $resolver->setDefaults([
            'required' => false,
            'data_class' => EstimationDTO::class,
            'validation_groups'=> function(Form $form){
                $groups = [];
                if ($form->get('confirm')->isClicked()){
                    $groups[] = ValidationGroup::GROUP_DEFAULT;
                }
                return $groups;
            }
        ]);
    }
}