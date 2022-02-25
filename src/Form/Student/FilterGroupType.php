<?php
declare(strict_types=1);

namespace App\Form\Student;


use App\DTO\GroupFilterDTO;
use App\Entity\Education\Discipline;
use App\Repository\Education\DisciplineRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class FilterGroupType extends AbstractType
{
    /**
     * @var \Symfony\Component\Security\Core\Security
     */
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var \App\Entity\Student $student */
        $student = $this->security->getUser();

        $builder->setMethod("GET");

        $builder->add('discipline', EntityType::class, [
            'class' => Discipline::class,
            'label' => 'Дисциплина',
            'query_builder' => function (DisciplineRepository $disciplineRepo) use ($student) {
                return $disciplineRepo->createQueryBuilder('discipline')
                    ->leftJoin('discipline.studentGroups', 'studentGroup')
                    ->leftJoin('studentGroup.students', 'student')
                    ->where('student = :student')
                    ->setParameter('student', $student);
            },
            'choice_label' => 'name',
            'placeholder' => 'Избери...'
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
        ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        return $resolver->setDefaults([
            'required' => false,
            'data_class' => GroupFilterDTO::class,
            'csrf_protection' => false
        ]);
    }
}