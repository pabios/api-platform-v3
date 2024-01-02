<?php

namespace App\Tests\Fonctionnal;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Browser\Test\HasBrowser;

class ProductRessourceTest extends KernelTestCase
{
    use HasBrowser;

    public function testGetCollectionOfProduct(){
        $this->browser()
            ->get('api/products')
            ->dump();
    } // php ./vendor/bin/phpunit
}