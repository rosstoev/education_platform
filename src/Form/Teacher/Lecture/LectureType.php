<?php
declare(strict_types=1);

namespace App\Form\Teacher\Lecture;


use App\Entity\Education\Discipline;
use App\Entity\Education\Group;
use App\Entity\Education\Lecture;
use App\Entity\Teacher;
use App\Repository\Education\DisciplineRepository;
use App\Repository\Education\GroupRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Constraints\NotBlank;

class LectureType extends AbstractType
{
    /**
     * @var Security
     */
    private Security $security;

    /**
     * @var \App\Repository\Education\DisciplineRepository
     */
    private DisciplineRepository $disciplineRepo;

    public function __construct(Security $security, DisciplineRepository $disciplineRepo)
    {

        $this->security = $security;
        $this->disciplineRepo = $disciplineRepo;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Teacher $teacher */
        $teacher = $this->security->getUser();
        $builder->add('startDate', DateTimeType::class, [
            'label' => 'Дата и час на провеждане',
            'widget' => 'single_text',
            'constraints' => [
                new NotBlank()
            ]
        ]);

        $builder->add('name', TextType::class, [
            'label' => 'Тема',
            'attr' => ['placeholder' => 'Тема на занятието'],
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

        $builder->add('description', TextareaType::class, [
            'label' => 'Описание',
            'attr' => ['rows' => '5', 'placeholder' => 'Описание на занятието'],
        ]);



        $builder->addEventListener(FormEvents::PRE_SET_DATA, [$this, 'preSetData']);
        $builder->addEventListener(FormEvents::PRE_SUBMIT, [$this, 'preSubmit']);
    }

    public function preSetData(FormEvent $event)
    {
        $form = $event->getForm();
        /** @var Lecture $data */
        $data = $event->getData();
        $groups = [];
        if (!empty($data) && !empty($data->getDiscipline())) {
            $groups = $data->getDiscipline()->getStudentGroups()->getValues();
        }

        $form->add('studentGroup', ChoiceType::class, [
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

    public function preSubmit(FormEvent $event)
    {
        $form = $event->getForm();
        $data = $event->getData();

        if (!empty($data['discipline'])) {
            $discipline = $this->disciplineRepo->find($data['discipline']);
            $groups = $discipline->getStudentGroups()->getValues();
            $form->add('studentGroup', ChoiceType::class, [
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
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        return $resolver->setDefaults([
            'required' => false,
            'data_class' => Lecture::class
        ]);
    }
}