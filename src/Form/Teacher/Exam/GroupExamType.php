<?php
declare(strict_types=1);

namespace App\Form\Teacher\Exam;


use App\DTO\Exam\GroupExamDTO;
use App\Entity\Education\Group;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class GroupExamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var \App\Entity\Education\Discipline $discipline */
        $discipline = $options['discipline'];
        $groups = $discipline->getStudentGroups()->getValues();

        $builder->add('studentGroup', ChoiceType::class, [
            'label' => 'Група',
            'attr' => ['class' => 'my-select2-js'],
            'placeholder' => 'Избери...',
            'choices' => $groups,
            'choice_value' => 'id',
            'choice_label' => function (Group $group) {
                return $group->getCourse() . ' | ' . $group->formatStudyYear();
            },
            'constraints' => [
                new NotBlank()
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        return $resolver->setDefaults([
            'data_class' => GroupExamDTO::class,
            'discipline' => null
        ]);
    }
}