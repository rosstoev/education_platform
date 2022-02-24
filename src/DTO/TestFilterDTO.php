<?php
declare(strict_types=1);

namespace App\DTO;


class TestFilterDTO
{
    private ?string $title = null;
    private ?\DateTimeInterface $from = null;
    private ?\DateTimeInterface $to = null;

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
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