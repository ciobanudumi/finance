<?php
declare(strict_types=1);


namespace App\StateProcessor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use ApiPlatform\Validator\Exception\ValidationException;
use ApiPlatform\Validator\ValidatorInterface;
use App\Dto\ContactPersonDto;
use App\Entity\ContactPerson;
use App\Entity\Task;
use App\Entity\TaskSet;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;

readonly class CreateTaskStateProcessor implements ProcessorInterface
{
    /**
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $entityManager
     * @param ProcessorInterface $processor
     * @param ValidatorInterface $validator
     */
    public function __construct(
        private SerializerInterface $serializer,
        private EntityManagerInterface $entityManager,
        private ProcessorInterface $processor,
        private ValidatorInterface $validator,
    )
    {}

    /**
     * @param mixed $data
     * @param Operation $operation
     * @param array $uriVariables
     * @param array $context
     * @return mixed
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        $contactPerson = $this->createContactPerson($data->contactPerson);
        $data->contactPerson = null;

        $task = $this->serializer->deserialize(json_encode($data), $this->getObjectClass(), 'json');
        $task->setContactPerson($contactPerson);
        if ($task->getTaskSet() === null) {
            $task->setTaskSet($this->createTaskSet());
        }

        return $this->processor->process($task, $operation, $uriVariables, $context);
    }

    /**
     * @return TaskSet
     */
    private function createTaskSet(): TaskSet
    {
        $taskSet = new TaskSet();
        $taskSet->setStatus(TaskSet::TASK_SET_STATUS_NEW);
        $this->entityManager->persist($taskSet);
        $this->entityManager->flush();

        return $taskSet;
    }

    /**
     * @param string $contactPersonJson
     * @return ContactPerson
     */
    private function createContactPerson(string $contactPersonJson): ContactPerson
    {
        try {
            $contactPersonDto = $this->serializer->deserialize($contactPersonJson, ContactPersonDto::class, 'json');
            $this->validator->validate($contactPersonDto);
        } catch (ValidationException $e) {
            throw new ValidationException("ContactPerson:". $e->getMessage());
        }

        $contactPerson = $this->serializer->deserialize($contactPersonJson, ContactPerson::class, 'json');
        $this->entityManager->persist($contactPerson);
        $this->entityManager->flush();

        return $contactPerson;
    }

    /**
     * @return string
     */
    protected function getObjectClass(): string
    {
        return Task::class;
    }
}