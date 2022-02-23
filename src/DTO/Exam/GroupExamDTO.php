<?php
declare(strict_types=1);

namespace App\DTO\Exam;


use App\Entity\Education\Group;

class GroupExamDTO
{
    private ?Group $studentGroup = null;

    /**
     * @return \App\Entity\Education\Group|null
     */
    public function getStudentGroup(): ?Group
    {
        return $this->studentGroup;
    }

    /**
     * @param \App\Entity\Education\Group|null $studentGroup
     */
    public function setStudentGroup(?Group $studentGroup): void
    {
        $this->studentGroup = $studentGroup;
    }

}