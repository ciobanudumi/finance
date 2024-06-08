<?php

namespace App\Trait;

use App\Entity\Task;
use App\Entity\TaskSet;

trait DetermTaskSetStatus
{
    /**
     * @param TaskSet $taskSet
     * @return string
     */
    private function determTaskSetStatus(TaskSet $taskSet): string
    {
        $isATaskDone = false;
        $countTasksDoneAndCancel = 0;
        foreach ($taskSet->getTasks() as $task) {
            if ($task->getStatus() === Task::TASK_STATUS_HOLD) {
                return TaskSet::TASK_SET_STATUS_HOLD;
            } elseif ($task->getStatus() === Task::TASK_STATUS_DONE) {
                $isATaskDone = true;
                $countTasksDoneAndCancel++;
            } elseif ($task->getStatus() === Task::TASK_STATUS_CANCEL) {
                $countTasksDoneAndCancel++;
            }
        }

        if ($isATaskDone && count($taskSet->getTasks()) === $countTasksDoneAndCancel) {
            return TaskSet::TASK_SET_STATUS_COMPLETED;
        } elseif (!$isATaskDone && count($taskSet->getTasks()) === $countTasksDoneAndCancel) {
            return TaskSet::TASK_SET_STATUS_CANCELLED;
        } elseif (in_array($taskSet->getStatus(), [TaskSet::TASK_SET_STATUS_NEW, TaskSet::TASK_SET_STATUS_HOLD], true)
            && $taskSet->getPlanned() && $taskSet->getAssignee()) {
            return TaskSet::TASK_SET_STATUS_TO_DO;
        }

        return TaskSet::TASK_SET_STATUS_NEW;
    }
}