<?php
declare(strict_types=1);

namespace App\Controller\Admin\Student;


use App\Entity\Exam\Answer\Answer;
use App\Entity\Exam\Question\Question;
use App\Entity\Exam\StudentExam;
use App\Entity\Student;
use App\Form\Student\TestExam\AnswerType;
use App\Handler\StudentExamHandler;
use App\Repository\Exam\StudentExamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

/**
 * @Route ("/student/test", name="student_test_")
 */
class ExamTestController extends AbstractController
{
    /**
     * @Route ("/take/{token}/{questionIndex}", name="take", defaults={"questionIndex":1}, requirements={"questionIndex":"\d+"})
     */
    public function take(
        Request $request,
        string $token,
        int $questionIndex,
        StudentExamRepository $studentExamRepo,
        StudentExamHandler $studentExamHandler,
        EntityManagerInterface $em
    ): Response
    {
        /** @var Student $student */
        $student = $this->getUser();
        /** @var StudentExam $exam */
        $exam = $studentExamRepo->findByToken($student, $token);
        try {
            $studentExamHandler->validateForTaking($exam);
        }catch (\Exception $ex) {
            $this->addFlash('warning', $ex->getMessage());
            return $this->redirectToRoute('student_exam_list');
        }
        $now = new \DateTime();
        $nowTimestamp = $now->getTimestamp();
        $endAtTimestamp = $exam->getTeacherExam()->getEndAt()->getTimestamp();

        /** @var Question $question */
        $question = $exam->getTeacherExam()->getTest()->getQuestions()->get($questionIndex - 1);
        if (empty($question)) {
            return $this->redirectToRoute('student_test_take', ['token' => $token]);
        }

        /** @var Answer $answer */
        $answer = $exam->getAnswers()->filter(function (Answer $answer)use ($question){
            return $answer->getQuestion() == $question;
        })->first();
        if (!empty($answer)) {
            if ($answer->getType() == Question::TYPE_CHOICES) {
                $answer->setChoice($answer->getChoices()->first());
            }
        } else {
            $answer = null;
        }

        $form = $this->createForm(AnswerType::class, $answer, ['question' => $question, 'exam' => $exam]);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            /** @var Answer $answer */
            $answer = $form->getData();
            if (!empty($answer)) {
                if($answer->getChoice()) {
                    $answer->addChoice($answer->getChoice());
                    $answer->setPoints($answer->getChoice()->getPoints());
                } else {
                    $answer->setPoints($question->getPoints());
                }
                $answer->setQuestion($question);
                $answer->setType($question->getType());
                $answer->setStudentExam($exam);
                $em->persist($answer);
                $em->flush();
            }
            if($form->get('back')->isClicked()){
                return $this->redirectToRoute('student_test_take', ['token' => $token, 'questionIndex' => ($questionIndex - 1)]);
            }
            if ($form->get('next')->isClicked()) {
                return $this->redirectToRoute('student_test_take', ['token' => $token, 'questionIndex' => ($questionIndex + 1)]);
            }
            if ($form->get('finish')->isClicked()) {
                $exam->setFinishedAt(new \DateTime());
                $em->persist($exam);
                $em->flush();
                $this->addFlash('success', 'Вие завършихте изпита.');
                return $this->redirectToRoute('student_exam_result', ['token' => $token]);

            }
        }

        return $this->render('admin/student/pages/exam/take.html.twig', [
            'form' => $form->createView(),
            'questionIndex' => $questionIndex,
            'nowTimestamp' => $nowTimestamp,
            'endAtTimestamp' => $endAtTimestamp
        ]);
    }
}