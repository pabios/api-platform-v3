<?php
// for CustomRessource look at in there provider
namespace App\ApiResource;

class QuestProduct
{

    public function __construct(
        public string $name,
        public string $slug,
        public string $price
    ){

    }
}