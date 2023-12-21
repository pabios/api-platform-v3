<?php

namespace App\Mapper;

use App\ApiResource\ProductResource;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfonycasts\MicroMapper\AsMapper;
use Symfonycasts\MicroMapper\MapperInterface;

#[AsMapper(from: ProductResource::class, to: Product::class)]
class ProductApiToEntityMapper implements  MapperInterface
{
    public function __construct(
        private ProductRepository $productRepository
    ){

    }

    public function load(object $from, string $toClass, array $context): object
    {
        $dto = $from;
        assert($dto instanceof ProductResource);
        $productEntity = $dto->id ? $this->productRepository->find($dto->id) : new Product();
        if (!$productEntity) {
            throw new \Exception('User not found');
        }
        return $productEntity;
    }

    public function populate(object $from, object $to, array $context): object
    {
        // TODO: Implement populate() method.
        $dto = $from;
        assert($dto instanceof ProductResource);
        $entity = $to;
        assert($entity instanceof Product);
        $entity->setName($dto->name);
        $entity->setSlug($dto->slug);
//        if ($dto->password) {
//            $entity->setPassword($this->userPasswordHasher->hashPassword($entity, $dto->password));
//        }
        $entity->setPrice($dto->price);
        // TODO dragonTreasures if we change them to writeable
        return $entity;
    }
}