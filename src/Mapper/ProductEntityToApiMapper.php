<?php

namespace App\Mapper;

use App\ApiResource\ProductResource;
use App\Entity\Product;
use Symfonycasts\MicroMapper\AsMapper;
use Symfonycasts\MicroMapper\MapperInterface;

#[AsMapper(from: Product::class, to: ProductResource::class)]
class ProductEntityToApiMapper implements MapperInterface
{
    public function load(object $from, string $toClass, array $context): object
    {
        $entity = $from;
        assert($entity instanceof Product);
        $dto = new ProductResource();
        $dto->id = $entity->getId();
        return $dto;
    }
    public function populate(object $from, object $to, array $context): object
    {
        $entity = $from;
        $dto = $to;
        assert($entity instanceof Product);
        assert($dto instanceof ProductResource);
        $dto->name = $entity->getName();
        $dto->slug = $entity->getSlug();
//        $dto->dragonTreasures = $entity->getPublishedDragonTreasures()->getValues();
//        $dto->flameThrowingDistance = rand(1, 100);
        return $dto;
    }

}