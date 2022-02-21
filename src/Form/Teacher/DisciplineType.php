<?php
declare(strict_types=1);

namespace App\Form\Teacher;


use App\Entity\Education\Discipline;
use App\Entity\Education\Group;
use App\Entity\Teacher;
use App\Repository\Education\GroupRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Constraints\NotBlank;

class DisciplineType extends AbstractType
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Teacher $teacher */
        $teacher = $this->security->getUser();

        $builder->add('name', TextType::class, [
            'label' => 'Име*',
            'attr' => ['placeholder' => 'Име на дисциплината'],
            'constraints' => [
                new NotBlank()
            ]
        ]);

        $builder->add('description', TextareaType::class, [
            'label' => 'Описание',
            'attr' => ['placeholder' => 'Описание на дисциплината', 'rows' => '3']
        ]);

        $builder->add('studentGroups', EntityType::class, [
            'class' => Group::class,
            'label' => 'Групи',
            'query_builder' => function (GroupRepository $groupRepo) use ($teacher) {
                return $groupRepo->createQueryBuilder('g')
                    ->where('g.teacher = :teacher')
                    ->setParameter('teacher', $teacher);
            },
            'choice_label' => function (Group $group) {
                return $group->getCourse() . ' | ' . $group->formatStudyYear();
            },
            'multiple' => true,
            'attr' => ['class' => 'my-select2-js', 'data-placeholder' => 'Избери...'],
//            'placeholder' => 'Избери...'
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        return $resolver->setDefaults([
            'required' => false,
            'data_class' => Discipline::class
        ]);
    }
}