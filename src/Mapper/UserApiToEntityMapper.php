<?php

namespace App\Mapper;

use App\ApiResource\UserRessource;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfonycasts\MicroMapper\AsMapper;
use Symfonycasts\MicroMapper\MapperInterface;

#[AsMapper(from: UserRessource::class, to: User::class)]
class UserApiToEntityMapper implements MapperInterface
{
    public function __construct(
        private UserRepository $userRepository,
        private UserPasswordHasherInterface $userPasswordHasher,
    )
    {
    }

    public function load(object $from, string $toClass, array $context): object
    {
        $dto = $from;
        assert($dto instanceof UserRessource);
        $userEntity = $dto->id ? $this->userRepository->find($dto->id) : new User();
        if (!$userEntity) {
            throw new \Exception('User not found');
        }
        return $userEntity;
    }

    public function populate(object $from, object $to, array $context): object
    {
        $dto = $from;
        assert($dto instanceof UserRessource);
        $entity = $to;
        assert($entity instanceof User);
        $entity->setEmail($dto->email);
        $entity->setUsername($dto->username);
        if ($dto->password) {
            $entity->setPassword($this->userPasswordHasher->hashPassword($entity, $dto->password));
        }
        // TODO dragonTreasures if we change them to writeable
        return $entity;
    }
}