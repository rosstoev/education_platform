<?php
declare(strict_types=1);

namespace App\Form\Teacher\Exam;


use App\Entity\Education\Discipline;
use App\Entity\Exam\TeacherExam;
use App\Entity\Exam\Test;
use App\Repository\Education\DisciplineRepository;
use App\Repository\Exam\TestRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Constraints\NotBlank;

class ExamType extends AbstractType
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
        /** @var \App\Entity\Teacher $teacher */
        $teacher = $this->security->getUser();

        $builder->add('startedAt', DateTimeType::class, [
            'label' => 'Дата и час на провеждане',
            'widget' => 'single_text',
            'constraints' => [
                new NotBlank()
            ]
        ]);

        $builder->add('executionTime', IntegerType::class, [
            'label' => 'Време на провеждане',
            'attr' => ['placeholder' => 'Минути', 'min' => '1'],
            'constraints' => [
                new NotBlank()
            ]
        ]);

        $builder->add('discipline', EntityType::class, [
            'class' => Discipline::class,
            'label' => 'Дисциплина',
            'query_builder' => function (DisciplineRepository $disciplineRepo) use ($teacher) {
                return $disciplineRepo->createQueryBuilder('discipline')
                    ->where('discipline.teacher = :teacher')
                    ->setParameter('teacher', $teacher);
            },
            'attr' => ['class' => 'my-select2-js'],
            'choice_label' => 'name',
            'placeholder' => 'Избери...',
            'constraints' => [
                new NotBlank()
            ]
        ]);

        $builder->add('test', EntityType::class, [
            'class' => Test::class,
            'label' => 'Тест',
            'query_builder' => function (TestRepository $testRepository) use ($teacher) {
                return $testRepository->createQueryBuilder('testExam')
                    ->where('testExam.author = :teacher')
                    ->setParameter('teacher', $teacher);
            },
            'attr' => ['class' => 'my-select2-js'],
            'choice_label' => 'title',
            'placeholder' => 'Избери...',
            'constraints' => [
                new NotBlank()
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        return $resolver->setDefaults([
           'required' => false,
           'data_class' => TeacherExam::class
        ]);
    }
}