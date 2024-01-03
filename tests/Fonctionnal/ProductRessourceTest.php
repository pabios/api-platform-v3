<?php

namespace App\Tests\Fonctionnal;

use App\Entity\ApiToken;
use App\Factory\ApiTokenFactory;
use App\Factory\ProductFactory;
use App\Factory\UserFactory;
use http\Client\Curl\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Browser\Json;
use Zenstruck\Browser\Test\HasBrowser;
use Zenstruck\Foundry\Test\ResetDatabase;

class ProductRessourceTest extends KernelTestCase
{ // symfony php  bin/phpunit

    use HasBrowser;
    use ResetDatabase;

    public function testGetCollectionOfProduct()
    { // symfony php  bin/phpunit --filter=testGetCollectionOfProduct
        ProductFactory::createMany(5);
        $this->browser()
            ->get('/api/products')
            ->assertJson()
            ->assertJsonMatches('"hydra:totalItems"',5)
        ;
    }
    public function testGetMatchOfProduct()
    { // symfony php  bin/phpunit --filter=testGetMatchOfProduct

        $this->browser()
            ->get('/api/products')
            ->assertJson()
            ->use(function (Json $json){
                $json->assertMatches('keys("hydra:member"[0])',[
                    '@id',
                    "@type",
                    'name',
                    'slug'
                ]);
            });
    }

    public function testPostToCreateProduct():void
    { // symfony php  bin/phpunit --filter=testPostToCreateProduct

        $user = UserFactory::createOne();

        $this->browser()
            ->actingAs($user)
//            ->post('/login',[
//                'json'=>[
//                    'email'=> $user->getEmail(),
//                    'password' => 'pass'
//                ],
//            ])
            ->post('/api/products',[
                    'json'=>[],
            ])
            ->assertStatus(204)
            ->post('/api/products',[
                'json'=>[
                    'name'=>'mac book',
                    'slug'=>'mac-book',
                    'price'=> '200',
//                    'owner' => '/api/users'.$user->getId()
                ]
            ])
            ->assertStatus(201)
            ->dump()
            ->assertJsonMatches('name','mac book')
        ;
    }

    public function testPostToCreateProductWithApiKey():void
    { // symfony php  bin/phpunit --filter=testPostToCreateProductWithApiKey
        $token = ApiTokenFactory::createOne([
            'scopes'=> ApiToken::SCOPE_PRODUCT_CREATE,
        ]);

        $this->browser()
            ->post('/api/products',[
                'json' => [],
                'header'=>[
                    'Authorization' => 'Bearer '.$token->getToken(),
                ]
            ])
            ->dump()
            ->assertStatus(422)
        ;

    }

    public function testPostToCreateProductDeniedWithoutScope():void
    { // symfony php  bin/phpunit --filter=testPostToCreateProductDeniedWithoutScope
        $token = ApiTokenFactory::createOne([
            'scopes'=> ApiToken::SCOPE_PRODUCT_EDIT,
        ]);

        $this->browser()
            ->post('/api/products',[
                'json' => [],
                'header'=>[
                    'Authorization' => 'Bearer '.$token->getToken(),
                ]
            ])
            ->dump()
            ->assertStatus(403)
        ;

    }

    public function testPatchToUpdateProduct():void
    { // symfony php  bin/phpunit --filter=testPatchToUpdateProduct
        $user = UserFactory::createOne();
        $product = ProductFactory::createOne([
            'owner'=>$user,
        ]);

        $this->browser()
            ->actingAs($user)
            ->patch('/api/products/'.$product->getId(),[
                'json' => [
                    'price' => 1234
                ]
            ])
            ->assertStatus(200)
            ->assertJsonMatches('value',1234)
        ;
    }
}

// php ./vendor/bin/phpunit
// symfony php  bin/phpunit --filter=testPostToCreateProduct