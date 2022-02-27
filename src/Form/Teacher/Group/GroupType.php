<?php
declare(strict_types=1);

namespace App\Form\Teacher\Group;


use App\Entity\Education\Group;
use App\Entity\Student;
use App\Form\DataTransformer\YearToDateTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class GroupType extends AbstractType
{
    private YearToDateTransformer $yearToDateTransformer;

    public function __construct(YearToDateTransformer $yearToDateTransformer)
    {
        $this->yearToDateTransformer = $yearToDateTransformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('course', IntegerType::class, [
            'label' => 'Номер на курс/клас*',
            'attr' => ['placeholder' => 'номер', 'min' => '1'],
            'constraints' => [
                new NotBlank()
            ]
        ]);

        $builder->add('year', TextType::class, [
            'label' => '<i class="far fa-calendar-alt"></i>',
            'label_html' => true,
            'row_attr' => ['class' => 'input-group'],
            'attr' => [
                'class' => 'year-mask',
                'data-inputmask-alias' => 'datetime',
                'data-inputmask-inputformat' => 'yyyy',
            ],
            'constraints' => [
                new NotBlank()
            ]
        ]);

        $builder->add('students', EntityType::class, [
            'class' => Student::class,
            'label' => 'Ученици',
            'choice_label' => 'email',
            'multiple' => true,
            'attr' => ['class' => 'my-select2-js', 'data-placeholder' => 'Избери...'],
        ]);

        $builder->get('year')->addModelTransformer($this->yearToDateTransformer);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        return $resolver->setDefaults([
            'data_class' => Group::class,
            'required' => false
        ]);
    }
}