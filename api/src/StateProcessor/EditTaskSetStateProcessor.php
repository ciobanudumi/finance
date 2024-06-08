<?php

namespace App\StateProcessor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\TaskSet;

class EditTaskSetStateProcessor implements ProcessorInterface
{
    public function __construct(
        private ProcessorInterface $processor
    )
    {}

    /**
     * @param mixed $data
     * @param Operation $operation
     * @param array $uriVariables
     * @param array $context
     * @return TaskSet
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): TaskSet
    {
        if ($data->getPlanned() && $data->getAssignee() &&  TaskSet::TASK_SET_STATUS_NEW === $data->getStatus()) {
            $data->setStatus(TaskSet::TASK_SET_STATUS_TO_DO);
        } elseif (TaskSet::TASK_SET_STATUS_TO_DO === $data->getStatus() && (!$data->getPlanned() || !$data->getAssignee())) {
            $data->setStatus(TaskSet::TASK_SET_STATUS_NEW);
        }

        return $this->processor->process($data, $operation, $uriVariables, $context);
    }
}