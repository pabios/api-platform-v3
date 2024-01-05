<?php

namespace App\Controller\Product;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[AsController]
class GetOneByProductIdController extends AbstractController
{
    public function __construct(
        private ProductRepository $productRepository,
        private MailerInterface $mailer
    ){

    }
    public function __invoke(Product $product)
    {
        $appName = $this->getParameter('app.name');
        $singleProduct =  $this->productRepository->findOneBy(['id' => $product->getId()]);

        if(empty($singleProduct) ){
            throw new NotFoundHttpException('Product not found');
        }

        $name = $product->getName();
        $price = $product->getPrice();

        $email = (new Email())
            ->from('hello@example.com')
            ->to('you@example.com')
            ->subject('Votre produit')
            ->text("bonjour  bonsoir le monde")
            ->html("<p> hello
                            <ul>
                                   <li> <strong> Nom Produit </strong>: $name</li>
                                   <li> <strong> Prix Produit </strong>: $price</li>
                                   <li>Merci  mailler good buy</li>
                            </ul>
                           </p>");

        $this->mailer->send($email);

        return [
            "appName"=>$appName,
            "product"=>$singleProduct
            ];
    }
}