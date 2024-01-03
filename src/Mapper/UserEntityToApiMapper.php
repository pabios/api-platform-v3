<?php

namespace App\Mapper;

use App\ApiResource\UserRessource;
use App\Entity\User;
use Symfonycasts\MicroMapper\AsMapper;
use Symfonycasts\MicroMapper\MapperInterface;

#[AsMapper(from: User::class, to: UserRessource::class)]
class UserEntityToApiMapper implements MapperInterface
{
    public function load(object $from, string $toClass, array $context): object
    {
        $entity = $from;
        assert($entity instanceof User);
        $dto = new UserRessource();
        $dto->id = $entity->getId();
        return $dto;
    }

    public function populate(object $from, object $to, array $context): object
    {
        $entity = $from;
        $dto = $to;
        assert($entity instanceof User);
        assert($dto instanceof UserRessource);
        $dto->email = $entity->getEmail();
        $dto->username = $entity->getUsername();
//        $dto->dragonTreasures = $entity->getPublishedProduct()->getValues();
        $dto->flameThrowingDistance = rand(1, 100);
        return $dto;
    }
}