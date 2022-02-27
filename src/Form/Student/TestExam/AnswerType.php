<?php
declare(strict_types=1);

namespace App\Form\Student\TestExam;


use App\Entity\Exam\Answer\Answer;
use App\Entity\Exam\Question\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnswerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var \App\Entity\Exam\Question\Question $question */
        $question = $options['question'];

        /** @var \App\Entity\Exam\StudentExam $exam */
        $exam = $options['exam'];
        $now = new \DateTime();
        $endDate = $exam->getTeacherExam()->getEndAt()->modify('+ 2 minutes');
        $startDate = $exam->getTeacherExam()->getStartedAt()->modify('-2 minutes');

        if ($now < $endDate && $now > $startDate) {
            if ($question->getType() == Question::TYPE_OPEN) {
                $builder->add('text', TextareaType::class, [
                    'label' => $question->getText(),
                    'attr' => ['placeholder' => 'Отговор...', 'rows' => '8']
                ]);
            }

            if ($question->getType() == Question::TYPE_CHOICES) {
                $choices = $question->getChoices();

                $builder->add('choice', ChoiceType::class, [
                    'label' => $question->getText(),
                    'choices' => $choices,
                    'choice_label' => 'possibility',
                    'expanded' => true,
                    'placeholder' => false,
                ]);
            }
        }

        $builder->add('back', SubmitType::class, [
            'label' => 'Назад',
            'attr' => ['class' => 'btn-secondary btn']
        ]);

        $builder->add('next', SubmitType::class, [
            'label' => 'Напред',
            'attr' => ['class' => 'btn-secondary btn']
        ]);

        $builder->add('finish', SubmitType::class, [
            'label' => 'Завърши',
            'attr' => ['class' => 'btn-secondary btn']
        ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        return $resolver->setDefaults([
            'required' => false,
            'data_class' => Answer::class,
            'question' => null,
            'exam' => null
        ]);
    }
}