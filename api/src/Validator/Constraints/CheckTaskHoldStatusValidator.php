<?php

namespace App\Validator\Constraints;

use App\Dto\ChangeTaskStatusDto;
use App\Entity\Task;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Contracts\Translation\TranslatorInterface;

class CheckTaskHoldStatusValidator extends ConstraintValidator
{
    public function __construct(private readonly TranslatorInterface $translator)
    {
    }

    /**
     * @param ChangeTaskStatusDto $value
     * @param Constraint $constraint
     * @return void
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof CheckTaskHoldStatus) {
            throw new UnexpectedTypeException($constraint, CheckTaskHoldStatus::class);
        }

        if ($value->status === Task::TASK_STATUS_HOLD
            && (!$value->holdCode || !$value->holdReason || !$value->holdExpectedResumeDate)) {
            $this->context
                ->buildViolation($this->translator->trans($constraint->messageRequiredFields))
                ->addViolation();
        } elseif ($value->status !== Task::TASK_STATUS_HOLD
            && ($value->holdCode || $value->holdReason || $value->holdExpectedResumeDate)) {
            $this->context
                ->buildViolation($this->translator->trans($constraint->messageSpecificFields))
                ->addViolation();
        }
    }
}