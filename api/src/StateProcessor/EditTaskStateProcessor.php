<?php

declare(strict_types=1);

namespace App\StateProcessor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use ApiPlatform\Validator\Exception\ValidationException;
use ApiPlatform\Validator\ValidatorInterface;
use App\Dto\EditContactPersonDto;
use App\Dto\EditTaskDto;
use App\Entity\ContactPerson;
use App\Entity\Task;
use App\Util\EntityMergeHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;

readonly class EditTaskStateProcessor implements ProcessorInterface
{
    public function __construct(
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
        private EntityManagerInterface $entityManager,
        private EntityMergeHelper $entityMergeHelper
    )
    {}

    /**
     * @param EditTaskDto $data
     * @param Operation $operation
     * @param array $uriVariables
     * @param array $context
     * @return Task
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Task
    {
        $this->updateContactPerson($data->contactPerson);
        $data->contactPerson = null;
        $task = $this->serializer->deserialize(json_encode($data), $this->getObjectClass(), 'json');

        /** @var Task $taskEntity */
        $taskEntity = $this->entityMergeHelper->mergeDeserialisedEntity(
            $task,
            $data->taskId,
            $this->getObjectClass()
        );

        $this->entityManager->flush();

        return $taskEntity;
    }

    /**
     * @param string $contactPersonJson
     * @return void
     */
    private function updateContactPerson(string $contactPersonJson): void
    {
        try {
            $contactPersonDto = $this->serializer->deserialize(
                $contactPersonJson,
                EditContactPersonDto::class,
                'json'
            );
            $this->validator->validate($contactPersonDto);
        } catch (ValidationException $e) {
            throw new ValidationException("ContactPerson:". $e->getMessage());
        }

        $contactPerson = $this->serializer->deserialize($contactPersonJson, ContactPerson::class, 'json');

        $this->entityMergeHelper->mergeDeserialisedEntity(
            $contactPerson,
            $contactPersonDto->contactPersonId,
            ContactPerson::class
        );
    }

    /**
     * @return string
     */
    protected function getObjectClass(): string
    {
        return Task::class;
    }
}