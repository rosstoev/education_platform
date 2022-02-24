<?php
declare(strict_types=1);

namespace App\DTO;


use App\Entity\Education\Discipline;

class LectureFilterDTO
{
    private ?Discipline $discipline = null;
    private ?\DateTimeInterface $from = null;
    private ?\DateTimeInterface $to = null;

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
    public function getFrom(): ?\DateTimeInterface
    {
        return $this->from;
    }

    /**
     * @param \DateTimeInterface|null $from
     */
    public function setFrom(?\DateTimeInterface $from): void
    {
        $this->from = $from;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getTo(): ?\DateTimeInterface
    {
        return $this->to;
    }

    /**
     * @param \DateTimeInterface|null $to
     */
    public function setTo(?\DateTimeInterface $to): void
    {
        $this->to = $to;
    }

}