<?php

namespace App\Validator\Constraints;

use App\Dto\ChangeTaskStatusDto;
use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Contracts\Translation\TranslatorInterface;

class CheckChangeTaskStatusValidator extends ConstraintValidator
{

    private const ALLOW_NEW_STATUSES_FROM_TO_DO = [
        Task::TASK_STATUS_HOLD,
        Task::TASK_STATUS_CANCEL,
        Task::TASK_STATUS_DONE,
    ];
    private const ALLOW_NEW_STATUSES_FROM_HOLD = [
        Task::TASK_STATUS_TO_DO,
        Task::TASK_STATUS_CANCEL,
        Task::TASK_STATUS_DONE
    ];

    private const FINAL_TASK_STATUSES = [
        Task::TASK_STATUS_CANCEL,
        Task::TASK_STATUS_DONE
    ];

    public function __construct(
        private readonly TranslatorInterface $translator,
        private readonly EntityManagerInterface $entityManager,
    )
    {}

    /**
     * @param ChangeTaskStatusDto $value
     * @param Constraint $constraint
     * @return void
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof CheckChangeTaskStatus) {
            throw new UnexpectedTypeException($constraint, CheckChangeTaskStatus::class);
        }

        $task = $this->entityManager->getRepository(Task::class)->find($value->taskId);
        if (!$task instanceof Task) {
            throw new EntityNotFoundException(sprintf("Task with id %s was not found", $value->taskId));
        }

        if (
            ($task->getStatus() === Task::TASK_STATUS_TO_DO && !in_array($value->status, self::ALLOW_NEW_STATUSES_FROM_TO_DO, true))
            || ($task->getStatus() === Task::TASK_STATUS_HOLD && !in_array($value->status, self::ALLOW_NEW_STATUSES_FROM_HOLD, true))
            || (in_array($task->getStatus(), self::FINAL_TASK_STATUSES))
        ) {
            $this->context
                ->buildViolation($this->translator->trans($constraint->messageStatusCannotBeChanged))
                ->setParameter('{currentStatus}', $task->getStatus())
                ->setParameter('{desiredStatus}', $value->status)
                ->addViolation();
        }

    }
}