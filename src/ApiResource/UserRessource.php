<?php

namespace App\ApiResource;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Entity\User;

use App\State\EntityClassDtoStateProcessor;
use App\State\EntityToDtoStateProvider;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'User',
    operations: [
        new Get(),
        new GetCollection(),
        new Post(
            security: 'is_granted("PUBLIC_ACCESS")',
            validationContext: ['groups' => ['Default', 'postValidation']],
        ),
        new Patch(
            security: 'is_granted("ROLE_USER_EDIT")'
        ),
        new Delete(),
    ],
    paginationItemsPerPage: 5,
    security: 'is_granted("ROLE_USER")',
    provider: EntityToDtoStateProvider::class,
    processor: EntityClassDtoStateProcessor::class,
    stateOptions: new Options(entityClass: User::class),
)]
#[ApiFilter(SearchFilter::class, properties: [
    'username' => 'partial',
])]
//#[UniqueEntity(fields: ['email'],message: 'un compte existe deja avec cet Email')]
class UserRessource
{
    #[ApiProperty(readable: false, writable: false, identifier: true)]
    public ?int $id = null;
    #[Assert\NotBlank]
    #[Assert\Email]
    public ?string $email = null;
    #[Assert\NotBlank]
    public ?string $username = null;
    /**
     * The plaintext password when being set or changed.
     */
    #[ApiProperty(readable: false)]
    #[Assert\NotBlank(groups: ['postValidation'])]
    public ?string $password = null;

//    /**
//     * @var array<int, Product>
//     */
//    #[ApiProperty(writable: false)]
//    public array $products = [];
    #[ApiProperty(writable: false)]
    public int $flameThrowingDistance = 0;

}