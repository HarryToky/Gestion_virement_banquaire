<?php

namespace App\Controller;


use App\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ClientController extends AbstractController
{
    private $entityManager;
    private $passwordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    #[Route('/ajouterClient', name: 'ajouterClient', methods: ['POST'])]
    public function ajouterClient(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        // Récupérer les données du formulaire
        $nomClient = $data['nomClient'];
        $solde = 0;
        $email = $data['email'];
        $mdp = 'test123';
        // Générer un numéro de compte aléatoire
        $numeroCompte = '';
        for ($i = 0; $i <= 15; $i++) {
            $numeroCompte .= mt_rand(0, 9);
        }

        // Créer une nouvelle instance de Client
        $client = new Client();
        // Définir les propriétés du client
        $client->setNumeroCompte($numeroCompte);
        $client->setNomClient($nomClient);
        $client->setSolde($solde);
        $client->setEmail($email);

        // Hacher le mot de passe
        $hashedPassword = $this->passwordHasher->hashPassword($client, $mdp);
        $client->setPassword($hashedPassword);

        // Persistez et flush les données
        $this->entityManager->persist($client);
        $this->entityManager->flush();

        // Répondre avec un message JSON
        return $this->json(['message' => 'Utilisateur ajouté avec succès'], Response::HTTP_CREATED);
    }

    #[Route('/afficherClients', name: 'afficherClients', methods: ['GET'])]
    public function afficherClients(): JsonResponse
    {
        $clients = $this->entityManager->getRepository(Client::class)->findAll();

        $data = [];

        foreach ($clients as $client) {
            $data[] = [
                'id' => $client->getId(),
                'nomClient' => $client->getNomClient(),
                'numeroCompte' => $client->getNumeroCompte(),
                'email' => $client->getEmail(),
                'solde' => $client->getSolde()
            ];
        }


        return new JsonResponse($data);
    }

    #[Route('/modifierClient/{id}', name: 'modifierClient', methods: ['PUT'])]
    public function modifierClient(Request $request, int $id): Response
    {
        $data = json_decode($request->getContent(), true);

        $client = $this->entityManager->getRepository(Client::class)->find($id);

        if (!$client) {
            return new JsonResponse(['message' => 'Client non trouvé'], Response::HTTP_NOT_FOUND);
        }

        if (isset($data['nomClient'])) {
            $client->setNomClient($data['nomClient']);
        }
        if (isset($data['solde'])) {
            $client->setSolde($data['solde']);
        }
        if (isset($data['email'])) {
            $client->setEmail($data['email']);
        }

        $this->entityManager->flush();

        $responseData = [
            'id' => $client->getId(),
            'numeroCompte' => $client->getNumeroCompte(),
            'nomClient' => $client->getNomClient(),
            'solde' => $client->getSolde(),
            'email' => $client->getemail()
        ];

        return new JsonResponse(['client' => $responseData, 'message' => 'Client modifié avec succès'], Response::HTTP_OK);
    }

    #[Route('/supprimerClient/{id}', name: 'supprimerClient', methods: ['DELETE'])]
    public function supprimerCliens(Client $client, int $id): Response
    {
        $client = $this->entityManager->getRepository(Client::class)->find($id);
        
        if (!$client) {
            return new JsonResponse(['message' => 'Client non trouvé'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($client);
        $this->entityManager->flush();

        return $this->json(['message' => 'Client Supprimer avec succès'], Response::HTTP_OK);
    }
}


