<?php
declare(strict_types=1);

namespace App\DTO;


use App\Entity\Education\Discipline;

class GroupFilterDTO
{
    private ?Discipline $discipline = null;
    private ?\DateTimeInterface $year = null;

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
     * @return \DateTimeInterface|null
     */
    public function getYear(): ?\DateTimeInterface
    {
        return $this->year;
    }

    /**
     * @param \DateTimeInterface|null $year
     */
    public function setYear(?\DateTimeInterface $year): void
    {
        $this->year = $year;
    }

}