<?php

namespace App\Tests\Fonctionnal;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Browser\Json;
use Zenstruck\Browser\Test\HasBrowser;

class ProductRessourceTest extends KernelTestCase
{
    use HasBrowser;
//    use ResetDatabase; // see use Zenstruckt\Foundry\Test\ResetDatabase

    public function testGetCollectionOfProduct(){
        $this->browser()
            ->get('/api/products')
            ->assertJson()
            ->assertJsonMatches('"hydra:totalItems"',0)
            ->use(function (Json $json){
                $json->assertMatches('keys("hydra:member"[0])',[
                    '@id',
                    "@type",
                    'name',
                    'slug',
                    'price'
                ]);
            })
        ;
    }

    // php ./vendor/bin/phpunit
    // symfony php  bin/phpunit
}