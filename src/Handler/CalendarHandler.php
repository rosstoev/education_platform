<?php
declare(strict_types=1);

namespace App\Handler;


use App\Entity\Education\Lecture;
use App\Entity\Exam\TeacherExam;
use App\Entity\Student;
use App\Entity\Teacher;
use App\Repository\Education\LectureRepository;
use App\Repository\Exam\StudentExamRepository;
use App\Repository\Exam\TeacherExamRepository;

class CalendarHandler
{
    /**
     * @var \App\Repository\Exam\TeacherExamRepository
     */
    private TeacherExamRepository $teacherExamRepo;
    /**
     * @var \App\Repository\Education\LectureRepository
     */
    private LectureRepository $lectureRepo;
    /**
     * @var \App\Repository\Exam\StudentExamRepository
     */
    private StudentExamRepository $studentExamRepo;

    public function __construct(
        TeacherExamRepository $teacherExamRepo,
        LectureRepository $lectureRepo,
        StudentExamRepository $studentExamRepo
    )
    {
        $this->teacherExamRepo = $teacherExamRepo;
        $this->lectureRepo = $lectureRepo;
        $this->studentExamRepo = $studentExamRepo;
    }

    public function getTeacherEvents(Teacher $teacher): iterable
    {
        $events = [];
        $exams = $this->teacherExamRepo->findByTeacher($teacher);
        $lectures = $this->lectureRepo->findByTeacher($teacher);

        /* 2022-04-12T12:00:00 */
        foreach ($exams as $exam) {
            $events[] = $this->createExamEvent($exam);
        }

        foreach ($lectures as $lecture) {
            $events[] = $this->createLectureEvent($lecture);
        }

        return $events;

    }

    public function getStudentEvents(Student $student): iterable
    {
        $events = [];
        $exams = $this->studentExamRepo->findBy(['author' => $student]);
        $lectures = $this->lectureRepo->findByStudent($student);
        foreach ($exams as $exam) {
            $events[] = $this->createExamEvent($exam->getTeacherExam());
        }

        foreach ($lectures as $lecture) {
            $events[] = $this->createLectureEvent($lecture);
        }

        return $events;
    }

    private function createExamEvent(TeacherExam $exam): object
    {
        $event = new \stdClass();
        $event->title = 'Изпит по ' . $exam->getDiscipline()->getName();
        $event->start = $exam->getStartedAt()->format('Y-m-d H:i:s');
        $event->end = $exam->getEndAt()->format('Y-m-d H:i:s');
        return $event;
    }

    private function createLectureEvent(Lecture $lecture): object
    {
        $event = new \stdClass();
        $event->title = 'Занятие на тема - '. $lecture->getName() . ', по ' . $lecture->getDiscipline()->getName();
        $event->start = $lecture->getStartDate()->format('Y-m-d H:i:s');
        return $event;
    }
}