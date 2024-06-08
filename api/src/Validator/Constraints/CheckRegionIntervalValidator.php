<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use App\Entity\MatchingCriteria;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Contracts\Translation\TranslatorInterface;

class CheckRegionIntervalValidator extends ConstraintValidator
{
    public function __construct(private readonly TranslatorInterface $translator)
    {
    }

    /**
     * @param MatchingCriteria $value
     * @param Constraint $constraint
     * @return void
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof CheckRegionInterval) {
            throw new UnexpectedTypeException($constraint, CheckRegionInterval::class);
        }

        if ($value->getMinRegion() > $value->getMaxRegion()) {
            $this->context
                ->buildViolation($this->translator->trans($constraint->messageInvalidRegionInterval))
                ->setParameter('{min}', strval($value->getMinRegion()))
                ->setParameter('{max}', strval($value->getMaxRegion()))
                ->addViolation();
        }
    }
}