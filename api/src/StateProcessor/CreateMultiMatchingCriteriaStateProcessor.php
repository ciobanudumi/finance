<?php

declare(strict_types=1);

namespace App\StateProcessor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\MultiMatchingCriteriaDto;
use App\Dto\ResponseDto;
use App\Entity\Company;
use App\Entity\MatchingCriteria;
use App\Entity\TaskType;
use App\Entity\User;
use App\Repository\MatchingCriteriaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Contracts\Translation\TranslatorInterface;

readonly class CreateMultiMatchingCriteriaStateProcessor implements ProcessorInterface
{
    public const NOT_FOUND_DATA_ERROR_MESSAGE = '{resource}: There is no data in the database for ids: {ids}.';
    public const NOT_FOUND_DATA_WARNING_MESSAGE = '{resource}: The following ids were not found in the database: {ids}.';

    public function __construct(
        private EntityManagerInterface $entityManager,
        private TranslatorInterface $translator
    )
    {}

    /**
     * @param mixed $data
     * @param Operation $operation
     * @param array $uriVariables
     * @param array $context
     * @return ResponseDto
     * @throws EntityNotFoundException
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): ResponseDto
    {
        $response = new ResponseDto();

        $userIds = $data->users;
        $userEntities = $this->entityManager->getRepository(User::class)->findBy(['id' => $userIds]);
        $this->checkEntities($userEntities, User::class, $userIds);

        $companiesIds = $data->companies;
        $companyEntities = $this->entityManager->getRepository(Company::class)->findBy(['id' => $companiesIds]);
        $this->checkEntities($companyEntities, Company::class, $companiesIds);

        $taskTypeIds = $data->taskTypes;
        $taskTypeEntities = $this->entityManager->getRepository(TaskType::class)->findBy(['id' => $taskTypeIds]);
        $this->checkEntities($taskTypeEntities, TaskType::class, $taskTypeIds);

        /** @var User $userEntity */
        foreach ($userEntities as $userEntity) {
            $this->removeIfExist( $userIds, $userEntity->getId());
            /** @var Company $companyEntity */
            foreach ($companyEntities as $companyEntity) {
                $this->removeIfExist( $companiesIds, $companyEntity->getId());
                /** @var TaskType $taskTypeEntity */
                foreach ($taskTypeEntities as $taskTypeEntity) {
                    $this->removeIfExist( $taskTypeIds, $taskTypeEntity->getId());
                    $matchingCriteria = $this->getMatchingCriteria($userEntity, $companyEntity, $taskTypeEntity, $data);
                    $response->data[] = $matchingCriteria;
                }
            }
        }

        $this->entityManager->flush();

        $this->checkDataUnprocessed($response, User::class, $userIds);
        $this->checkDataUnprocessed($response, Company::class, $companiesIds);
        $this->checkDataUnprocessed($response, TaskType::class, $taskTypeIds);

        return $response;
    }

    /**
     * @param array $entities
     * @param string $resource
     * @param array $ids
     * @return void
     * @throws EntityNotFoundException
     */
    private function checkEntities(array $entities, string $resource, array $ids): void
    {
        if (count($entities) === 0) {
            throw new EntityNotFoundException($this->translator->trans(self::NOT_FOUND_DATA_ERROR_MESSAGE, [
                'resource' => $this->getResourceName($resource),
                'ids' => implode(', ', $ids)
            ]));
        }
    }

    /**
     * @param User $user
     * @param Company $company
     * @param TaskType $task
     * @param MultiMatchingCriteriaDto $data
     * @return MatchingCriteria
     */
    private function getMatchingCriteria(User $user, Company $company, TaskType $task, MultiMatchingCriteriaDto $data): MatchingCriteria
    {
        /** @var MatchingCriteriaRepository $matchingCriteriaRepository */
        $matchingCriteriaRepository = $this->entityManager->getRepository(MatchingCriteria::class);
        $matchingCriteriaDb = $matchingCriteriaRepository
            ->ofUser($user)
            ->ofCompany($company)
            ->withTaskType($task)
            ->withOverlappingRegions($data->getMinRegion(), $data->getMaxRegion())
            ->getResult();

        if (count($matchingCriteriaDb) === 0) {
            $matchingCriteriaResponse = (new MatchingCriteria())
                ->setUser($user)
                ->setCompany($company)
                ->setTaskType($task)
                ->setMinRegion($data->getMinRegion())
                ->setMaxRegion($data->getMaxRegion());
            $this->entityManager->persist($matchingCriteriaResponse);
        } else {
            $matchingCriteriaResponse = $matchingCriteriaDb[0];
            unset($matchingCriteriaDb[0]);
            $matchingCriteriaResponse->setMinRegion(min($matchingCriteriaResponse->getMinRegion(), $data->getMinRegion()));
            $matchingCriteriaResponse->setMaxRegion(max($matchingCriteriaResponse->getMaxRegion(), $data->getMaxRegion()));

            /** @var MatchingCriteria $matchingCriteria */
            foreach ($matchingCriteriaDb as $matchingCriteria) {
                $matchingCriteriaResponse->setMinRegion(min($matchingCriteriaResponse->getMinRegion(), $matchingCriteria->getMinRegion()));
                $matchingCriteriaResponse->setMaxRegion(max($matchingCriteriaResponse->getMaxRegion(), $matchingCriteria->getMaxRegion()));
                $this->entityManager->remove($matchingCriteria);
            }
        }

        return $matchingCriteriaResponse;
    }

    /**
     * @param array $ids
     * @param int $id
     * @return void
     */
    private function removeIfExist(array &$ids, int $id): void
    {
        if (($key = array_search($id, $ids)) !== false) {
            unset($ids[$key]);
        }
    }

    /**
     * @param ResponseDto $response
     * @param array $data
     * @return void
     */
    private function checkDataUnprocessed(ResponseDto &$response, string $resource, array $data): void
    {
        if (count($data) !== 0) {
            $response->warningMessages[] = $this->translator->trans(self::NOT_FOUND_DATA_WARNING_MESSAGE, [
                'resource' => $this->getResourceName($resource),
                'ids' => implode(', ', $data)
            ]);
        }
    }

    /**
     * @param string $resourcePath
     * @return string
     */
    private function getResourceName(string $resourcePath): string
    {
        $resourceArray = explode('\\', $resourcePath);

        return end($resourceArray);
    }

}