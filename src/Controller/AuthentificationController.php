<?php

namespace App\Controller;

use App\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class AuthentificationController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/connexion', name: 'connexion', methods: ['POST'])]
    Public function authentifier(Request $request, UserPasswordHasherInterface $mdpHasher) {
        $check = true;
        $client = $this->entityManager->getRepository(Client::class)->findOneBy(["email" => $request->request->get('email')]);

        if(!$client || !$mdpHasher->isPasswordValid($client, $request->request->get('password'))) {
            $check = false;
            return $this->json(['message' => "L'email ou le mot de passe est erroné", 'check' => $check], Response::HTTP_OK);
        }


        $data = [];

        $data = [
            'id' => $client->getId(), 
            'numeroCompte' => $client->getNumeroCompte(),
            'nomClient' => $client->getNomClient(),
            'solde' => $client->getSolde(),
            'email' => $client->getEmail()

        ];

        return $this->json(['utilisateur' => $data, 'message' => 'Vous êtes connecté avec succès'], Response::HTTP_CREATED);
    }
}