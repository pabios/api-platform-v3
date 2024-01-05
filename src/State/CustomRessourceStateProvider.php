<?php

namespace App\State;

use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use ApiPlatform\State\Pagination\TraversablePaginator;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\CustomRessource;
use App\ApiResource\QuestProduct;
use App\Repository\ProductRepository;

class CustomRessourceStateProvider implements ProviderInterface
{
    public function __construct(
        private ProductRepository $productRepository,
        private  Pagination $pagination
    )
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if ($operation instanceof CollectionOperationInterface) {
            $currentPage = $this->pagination->getPage($context);
            $itemsPerPage = $this->pagination->getLimit($operation, $context);
            $offset = $this->pagination->getOffset($operation, $context);
            $totalItems = $this->countTotalQuests();

            $quests = $this->createQuests($offset, $itemsPerPage);

            return new TraversablePaginator(
                new \ArrayIterator($quests),
                $currentPage,
                $itemsPerPage,
                $totalItems,
            );
        }

        $quests = $this->createQuests(0, $this->countTotalQuests());

        return $quests[$uriVariables['dayString']] ?? null;
    }

    private function countTotalQuests()
    {
        return 20;
    }

    private function createQuests(int $offset, int $limit = 50): array
    {

        $products = $this->productRepository->findBy([], [], 10);
        $totalQuests = $this->countTotalQuests();

        $quests = [];
        for ($i = $offset; $i < ($offset + $limit) && $i < $totalQuests; $i++) {
            $quest = new CustomRessource(new \DateTimeImmutable(sprintf('- %d days', $i)));
            $quest->name = sprintf('Quest %d', $i);
            $quest->description = sprintf('Description %d', $i);
            $quest->lastUpdated= new \DateTimeImmutable(sprintf('-%d days',rand(10,100)));

            $randomProduct = $products[array_rand($products)];
            $quest->product = new QuestProduct(
                $randomProduct->getName(),
                $randomProduct->getSlug(),
                $randomProduct->getPrice(),
            );

            $quests[$quest->getDayString()] = $quest;
        }

        return $quests;
    }
}
