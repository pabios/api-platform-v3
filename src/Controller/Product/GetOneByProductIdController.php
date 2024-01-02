<?php

namespace App\Controller\Product;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class GetOneByProductIdController extends AbstractController
{
    public function __construct(
        private ProductRepository $productRepository
    ){

    }
    public function __invoke(Product $product){

        return $this->productRepository->findOneBy(['id' => $product->getId()]);
    }
}