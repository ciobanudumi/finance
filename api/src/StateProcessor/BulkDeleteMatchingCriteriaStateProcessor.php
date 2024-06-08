<?php

declare(strict_types=1);

namespace App\StateProcessor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\BulkDeleteDto;
use App\Entity\MatchingCriteria;
use App\Repository\MatchingCriteriaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Contracts\Translation\TranslatorInterface;

readonly class BulkDeleteMatchingCriteriaStateProcessor implements ProcessorInterface
{
    public const NOT_FOUND_MATCHING_CRITERIA_ERROR_MESSAGE = 'Matching Criteria were not found for the following ids: {ids}';

    public function __construct(
        private MatchingCriteriaRepository $matchingCriteriaRepository,
        private EntityManagerInterface $entityManager,
        private TranslatorInterface $translator
    )
    {}

    /**
     * @param BulkDeleteDto $data
     * @param Operation $operation
     * @param array $uriVariables
     * @param array $context
     * @return void
     * @throws EntityNotFoundException
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        $notFoundIds = [];
        foreach ($data->ids as $id) {
            $matchingCriteria = $this->matchingCriteriaRepository->find($id);
            if ($matchingCriteria instanceof MatchingCriteria) {
                $this->entityManager->remove($matchingCriteria);
            } else {
                $notFoundIds[] = $id;
            }
        }
        $this->entityManager->flush();

        if (count($notFoundIds) > 0) {
            throw new EntityNotFoundException($this->translator->trans(self::NOT_FOUND_MATCHING_CRITERIA_ERROR_MESSAGE, ['ids' => implode(', ', $notFoundIds)]));
        }
    }
}