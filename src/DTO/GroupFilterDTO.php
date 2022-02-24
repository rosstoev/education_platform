<?php
declare(strict_types=1);

namespace App\DTO;


use App\Entity\Education\Discipline;

class GroupFilterDTO
{
    private ?Discipline $discipline = null;
    private ?string $year = null;

    /**
     * @return \App\Entity\Education\Discipline|null
     */
    public function getDiscipline(): ?Discipline
    {
        return $this->discipline;
    }

    /**
     * @param \App\Entity\Education\Discipline|null $discipline
     */
    public function setDiscipline(?Discipline $discipline): void
    {
        $this->discipline = $discipline;
    }

    /**
     * @return string|null
     */
    public function getYear(): ?string
    {
        return $this->year;
    }

    /**
     * @param string|null $year
     */
    public function setYear(?string $year): void
    {
        $this->year = $year;
    }

}