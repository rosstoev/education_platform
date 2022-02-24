<?php
declare(strict_types=1);

namespace App\Handler;


use App\Entity\Teacher;
use App\Repository\Education\LectureRepository;
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

    public function __construct(TeacherExamRepository $teacherExamRepo, LectureRepository $lectureRepo)
    {
        $this->teacherExamRepo = $teacherExamRepo;
        $this->lectureRepo = $lectureRepo;
    }

    public function getTeacherEvents(Teacher $teacher): iterable
    {
        $events = [];
        $exams = $this->teacherExamRepo->findByTeacher($teacher);
        $lectures = $this->lectureRepo->findByTeacher($teacher);

        /* 2022-04-12T12:00:00 */
        foreach ($exams as $exam) {
            $event = new \stdClass();
            $event->title = 'Изпит по ' . $exam->getDiscipline()->getName();
            $event->start = $exam->getStartedAt()->format('Y-m-d H:i:s');
            $event->end = $exam->getEndAt()->format('Y-m-d H:i:s');
            $events[] = $event;
        }

        foreach ($lectures as $lecture) {
            $event = new \stdClass();
            $event->title = 'Занятие на тема '. $lecture->getName() . ', по ' . $lecture->getDiscipline()->getName();
            $event->start = $lecture->getStartDate()->format('Y-m-d H:i:s');
            $events[] = $event;
        }

        return $events;

    }
}