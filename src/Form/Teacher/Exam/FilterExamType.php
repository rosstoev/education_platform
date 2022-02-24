<?php
declare(strict_types=1);

namespace App\Form\Teacher\Exam;


use App\DTO\Exam\TeacherExamFilterDTO;
use App\Entity\Education\Discipline;
use App\Repository\Education\DisciplineRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class FilterExamType extends AbstractType
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
        $teacher = $this->security->getUser();

        $builder->setMethod("GET");
        $builder->add('discipline', EntityType::class, [
            'class' => Discipline::class,
            'label' => 'Дисциплина',
            'query_builder' => function (DisciplineRepository $disciplineRepo) use ($teacher) {
                return $disciplineRepo->createQueryBuilder('discipline')
                    ->where('discipline.teacher = :teacher')
                    ->setParameter('teacher', $teacher);
            },
            'choice_label' => 'name',
            'placeholder' => 'Избери...',
        ]);

        $builder->add('from', DateType::class, [
            'widget' => 'single_text',
            'html5' => false,
            'label_html' => true,
            'format' => 'dd.MM.yyyy',
            'label' => '<i class="fa fa-calendar"></i>',
            'row_attr' => ['class' => 'input-group date'],
            'attr' => ['class' => 'datepicker-field']
        ]);

        $builder->add('to', DateType::class, [
            'widget' => 'single_text',
            'html5' => false,
            'label_html' => true,
            'format' => 'dd.MM.yyyy',
            'label' => '<i class="fa fa-calendar"></i>',
            'row_attr' => ['class' => 'input-group date'],
            'attr' => ['class' => 'datepicker-field']
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        return $resolver->setDefaults([
            'required' => false,
            'data_class' => TeacherExamFilterDTO::class,
            'csrf_protection' => false
        ]);
    }
}