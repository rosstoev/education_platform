<?php

namespace App\Form\DataTransformer;


use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class YearToDateTransformer implements DataTransformerInterface
{

    /**
     * @param \DateTimeInterface $value
     * @return string
     */
    public function transform($value): string
    {
        if (null === $value) {
            return '';
        }

        return $value->format('Y');
    }

    public function reverseTransform($value)
    {
        if (!$value) {
            return null;
        }

        $dateInit = new \DateTime();
        return date_create($dateInit->format($value. "-m-d"));
    }
}