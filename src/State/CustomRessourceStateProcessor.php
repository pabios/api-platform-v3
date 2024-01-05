<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\ApiResource\CustomRessource;
use App\ApiResource\ProductResource;
use App\Repository\ProductRepository;

class CustomRessourceStateProcessor implements ProcessorInterface
{

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        //assert($data instanceof CustomRessource);

        $data->lastUpdated = new \DateTimeImmutable('now');

//        return $context['data']->product->name;
        dd( $context['data']);

//        $this->updateProductInDatabase($data);
    }

//    public function updateProductInDatabase(CustomRessource $data): void
//    {
//        $productRepo =  $this->container->get('App\Repository\ProductRepository');
//        $product = $productRepo->find($data->product->name);
//        $product->setName($data->name);
//        $productRepo->save($product);
//    }
}
