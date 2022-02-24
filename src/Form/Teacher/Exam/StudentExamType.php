<?php
declare(strict_types=1);

namespace App\Form\Teacher\Exam;


use App\DTO\Exam\StudentExamDTO;
use App\Entity\Student;
use App\Repository\StudentRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class StudentExamType extends AbstractType
{
    /**
     * @var \App\Repository\StudentRepository
     */
    private StudentRepository $studentRepo;

    public function __construct(StudentRepository $studentRepo)
    {
        $this->studentRepo = $studentRepo;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var \App\Entity\Education\Group $group */
        $group = $options['group'];
        /** @var \App\Entity\Exam\TeacherExam $teacherExam */
        $teacherExam = $options['exam'];
        $students = $this->studentRepo->findNotParticipateInExam($group, $teacherExam);

        $builder->add('students', ChoiceType::class, [
            'label' => 'Ученици',
            'expanded' => true,
            'placeholder' => false,
            'multiple' => true,
            'choices' => $students,
            'choice_value' => 'id',
            'choice_label' => function(Student $student){
                return $student->getFirstName() . ' ' . $student->getLastName();
            },
            'constraints' => [
                new NotBlank()
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        return $resolver->setDefaults([
            'data_class' => StudentExamDTO::class,
            'group' => null,
            'exam' => null
        ]);
    }
}