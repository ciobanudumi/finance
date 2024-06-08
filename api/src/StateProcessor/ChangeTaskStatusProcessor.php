<?php

namespace App\StateProcessor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\PortalCode;
use App\Entity\Task;
use App\Entity\TaskSet;
use App\Trait\DetermTaskSetStatus;
use Doctrine\ORM\EntityManagerInterface;

readonly class ChangeTaskStatusProcessor implements ProcessorInterface
{
    use DetermTaskSetStatus;

    public function __construct(
        protected EntityManagerInterface $entityManager,
        private ProcessorInterface $processor,
    )
    {}

    /**
     * @param mixed $data
     * @param Operation $operation
     * @param array $uriVariables
     * @param array $context
     * @return Task
     * @throws \Exception
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Task
    {
        $task = $this->entityManager->getRepository(Task::class)->find($data->taskId);
        $task->setStatus($data->status);

        if ($data->status === Task::TASK_STATUS_HOLD) {
            $portalCode = $this->entityManager->getRepository(PortalCode::class)->find($data->holdCode);
            $task->setHoldCode($portalCode);
            $task->setHoldReason($data->holdReason);
            $expectedResumeDate = new \DateTime($data->holdExpectedResumeDate);
            $task->setHoldExpectedResumeDate($expectedResumeDate);
        }

        if ($data->status === Task::TASK_STATUS_HOLD) {
            $task->getTaskSet()->setStatus(TaskSet::TASK_SET_STATUS_HOLD);
        } else {
            $taskSetStatus = $this->determTaskSetStatus($task->getTaskSet());
            $task->getTaskSet()->setStatus($taskSetStatus);
        }

        $this->entityManager->flush();

        return $this->processor->process($task, $operation, $uriVariables, $context);
    }

}