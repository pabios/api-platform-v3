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
use App\Controller\Product\GetOneByProductIdController;
use App\Entity\Product;
use App\State\EntityClassDtoStateProcessor;
use App\State\EntityToDtoStateProvider;

#[ApiResource(
    shortName: 'Product',
    operations: [
        new Get(
            formats: ['json'=>['application/+json']],
            controller: GetOneByProductIdController::class
        ),
        new GetCollection(
//            formats: ['json'=>['application/+json']]
        ),
        new Post(
            security: 'is_granted("ROLE_PRODUCT_CREATE")',
        ),
        new Patch(
            security: 'is_granted("EDIT", object)',
        ),
        new Delete(
            security: 'is_granted("ROLE_ADMIN")',
        )
    ],
    paginationItemsPerPage: 5,
    provider: EntityToDtoStateProvider::class,
    processor: EntityClassDtoStateProcessor::class,
    stateOptions: new Options(entityClass: Product::class),
)]

#[ApiFilter(SearchFilter::class, properties: [
    'name' => 'partial',
])]
class ProductResource
{
    #[ApiProperty(readable: false, writable: false, identifier: true)]
    public ?int $id;

    #[ApiProperty]
    public ?string $name;                                               //pabios_af

    #[ApiProperty]
    public ?string $slug;
    #[ApiProperty]
    public ?string $price;
}


