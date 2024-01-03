<?php

namespace App\Controller;

use ApiPlatform\Api\IriConverterInterface;
use App\Entity\ApiToken;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
class SecurityController extends AbstractController
{

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/login', name: 'app_login', methods: ['POST'])]
    public function login(IriConverterInterface $iriConverter, #[CurrentUser] $user = null): Response
    {
        if (!$user) {
            return $this->json([
                'error' => 'Invalid login request: check that the Content-Type header is "application/json".',
            ], 401);
        }

//        return $this->json([
//            'user'=> '/api/users/'. $user->getId(),
//        ]);

        $token = new ApiToken();
        $token->setOwnedBy($user);
        $expiresAt = new \DateTimeImmutable('+3 minutes');
        $token->setExpiresAt($expiresAt);
        $token->setScopes([ApiToken::SCOPE_USER_EDIT,ApiToken::SCOPE_PRODUCT_CREATE]);

        $user->addApiToken($token);

        $this->entityManager->persist($token);
        $this->entityManager->flush();

        return $this->json(['token' => $token->getToken()]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
//        throw new \Exception('This should never be reached!');
        $user = $this->getUser();

        if ($user) {
            foreach ($user->getApiTokens() as $token) {
                $user->removeApiToken($token);
            }
            $this->entityManager->flush();
        }

        echo $this->json(['info' => 'Goodbye']);

    }
}