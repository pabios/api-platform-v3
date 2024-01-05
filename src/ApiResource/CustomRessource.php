<?php
// Api Ressource without Entity

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use App\State\CustomRessourceStateProcessor;
use App\State\CustomRessourceStateProvider;

#[ApiResource(
    shortName: 'custom ressource',
    operations: [
        new GetCollection(),
        new Get(),
        new Patch(
            formats: ['json'=>['application/+json']],
            processor: CustomRessourceStateProcessor::class
        )
    ],
    provider: CustomRessourceStateProvider::class

)]
class CustomRessource
{
    public  \DateTimeInterface $day;
    public string $name;
    public string $description;
    public  \DateTimeInterface $lastUpdated;

    #[ApiProperty(genId: false)]
    public QuestProduct $product;

    public function __construct(\DateTimeInterface $day)
    {
        $this->day = $day;
    }

    #[ApiProperty(readable: false, identifier: true)]
    public function getDayString():string
    {
        return $this->day->format('Y-m-d');
    }


}

// php bin/console make:state-provider
// php bin/console make:state-processor
