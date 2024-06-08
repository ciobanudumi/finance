<?php

declare(strict_types=1);

namespace App\StateProcessor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\MoveTaskDto;
use App\Entity\Task;
use App\Entity\TaskSet;
use App\Trait\DetermTaskSetStatus;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;

readonly class MoveTaskStateProcessor implements ProcessorInterface
{
    use DetermTaskSetStatus;

    public function __construct(
        private EntityManagerInterface $entityManager,
    )
    {}

    /**
     * @param MoveTaskDto $data
     * @param Operation $operation
     * @param array $uriVariables
     * @param array $context
     * @return Task|null
     * @throws EntityNotFoundException
     */
    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = []
    ): ?Task
    {
        $task = $this->retrieveTask($data->taskId);
        $taskSet = $this->retrieveTaskSet($data->taskSetId);
        $oldTaskSetId = $task->getTaskSet()->getId();
        $isLastTaskInTaskSet = $task->getTaskSet()->getTasks()->count() === 1;

        if ($isLastTaskInTaskSet) {
            if (!$data->taskId) {
                return $task;
            }
            $this->deleteTaskSet($task);
        }

        if (!$data->taskSetId) {
            $task->setTaskSet($this->createTaskSet());
            $this->entityManager->flush();
            $this->entityManager->clear();

            $taskUpdated = $this->retrieveTask($task->getId());
            $this->updateTaskSetStatus($taskUpdated->getTaskSet()->getId());

            if (!$isLastTaskInTaskSet) {
                $this->updateTaskSetStatus($oldTaskSetId);
            }

            $this->entityManager->flush();

            return $task;
        }

        $task->setTaskSet($taskSet);
        $this->entityManager->persist($task);
        $this->entityManager->flush();

        $this->entityManager->clear();
        $this->updateTaskSetStatus($taskSet->getId());
        if (!$isLastTaskInTaskSet) {
            $this->updateTaskSetStatus($oldTaskSetId);
        }
        $this->entityManager->flush();

        return $task;
    }

    /**
     * @return TaskSet
     */
    private function createTaskSet(): TaskSet
    {
        $taskSet = new TaskSet();
        $taskSet->setStatus(TaskSet::TASK_SET_STATUS_NEW);
        $this->entityManager->persist($taskSet);

        return $taskSet;
    }

    /**
     * @param int $taskId
     * @return Task
     * @throws EntityNotFoundException
     */
    private function retrieveTask(int $taskId): Task
    {
        $task = $this->entityManager->getRepository(Task::class)->find($taskId);
        if (!$task instanceof Task) {
            throw new EntityNotFoundException(sprintf("Task with id %s was not found", $taskId));
        }

        return $task;
    }

    /**
     * @param int|null $taskSetId
     * @return TaskSet|null
     * @throws EntityNotFoundException
     */
    private function retrieveTaskSet(?int $taskSetId): ?TaskSet
    {
        $taskSet = null;
        if ($taskSetId) {
            $taskSet = $this->entityManager->getRepository(TaskSet::class)->find($taskSetId);
            if (!$taskSet instanceof TaskSet) {
                throw new EntityNotFoundException(sprintf("Task Set with id %s was not found", $taskSetId));
            }
        }

        return $taskSet;
    }

    /**
     * @param Task $task
     * @return void
     */
    private function deleteTaskSet(Task $task): void
    {
        $initialTaskSet = $task->getTaskSet();
        $task->setTaskSet(null);
        $this->entityManager->remove($initialTaskSet);
    }

    /**
     * @param int $taskSetId
     * @return void
     * @throws EntityNotFoundException
     */
    private function updateTaskSetStatus(int $taskSetId): void
    {
        $taskSet = $this->retrieveTaskSet($taskSetId);
        if ($taskSet) {
            $taskSetStatus = $this->determTaskSetStatus($taskSet);
            $taskSet->setStatus($taskSetStatus);
            $this->entityManager->persist($taskSet);
        }
    }
}