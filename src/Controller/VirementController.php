<?php

namespace App\Controller;

use App\Entity\Virement;
use App\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Psr\Log\LoggerInterface;

class VirementController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, private LoggerInterface $logger)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/ajouterVirement', name: 'ajouterVirement', methods: ['POST'])]
    public function ajouterVirement(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $numeroCompte = $data['numeroCompte'];
        $montant = $data['montant'];
        $dateVirement = new \DateTime(date("Y/m/d"));

        $this->logger->info("hello" . $numeroCompte);

        $numeroVirement = '';
        for ($i = 0; $i <= 6; $i++) {
            $numeroVirement .= mt_rand(0, 9);
        }

        $client = $this->entityManager->getRepository(Client::class)->findOneBy(['numeroCompte' => $numeroCompte]);

        if (!$client) {
            return $this->json(['error' => 'Le numéro de compte spécifié n\'existe pas.'], Response::HTTP_BAD_REQUEST);
        }

        $virement = new Virement();
        $virement->setNumeroVirement($numeroVirement);
        $virement->setNumeroCompte($numeroCompte);
        $virement->setMontant($montant);
        $virement->setDateVirement($dateVirement);

        $nouveauSolde = $client->getSolde() + $montant;
        $client->setSolde($nouveauSolde);

        $this->entityManager->persist($virement);
        $this->entityManager->flush();

        return $this->json(['message' => 'Virement ajouté avec succès'], Response::HTTP_CREATED);
    }

    #[Route('/afficherVirement', name: 'afficherVirement', methods: ['GET'])]
    public function afficheVirement(): Response
    {
        $virements = $this->entityManager->getRepository(Virement::class)->findAllOrderById();

        $data = [];

        foreach ($virements as $virement) {
            $data[] = [
                'id' => $virement->getId(),
                'numeroVirement' => $virement->getNumeroVirement(),
                'numeroCompte' => $virement->getNumeroCompte(),
                'montant' => $virement->getMontant(),
                'dateVirement' => $virement->getDateVirement()
            ];
        }

        return new JsonResponse($data);
    }


    #[Route('/modifierVirement/{id}', name: 'modifierVirement', methods: ['PUT'])]
    public function modifierVirement(Request $request, int $id): Response
    {
        $data = json_decode($request->getContent(), true);

        $virement = $this->entityManager->getRepository(Virement::class)->find($id);

        if (!$virement) {
            return new JsonResponse(['message' => 'Numero de Compte non trouvé'], Response::HTTP_NOT_FOUND);
        }

        if (!isset($data['numeroCompte'])) {
            return new JsonResponse(['message' => 'Numéro de compte non fourni'], Response::HTTP_BAD_REQUEST);
        }

        $numeroCompte = $data['numeroCompte'];
        $client = $this->entityManager->getRepository(Client::class)->findOneBy(['numeroCompte' => $numeroCompte]);

        if (!$client) {
            return new JsonResponse(['message' => 'Client non trouvé pour le numéro de compte fourni'], Response::HTTP_NOT_FOUND);
        }

        if (isset($data['montant'])) {
            $differenceMontant = $data['montant'] - $virement->getMontant();

            $virement->setMontant($data['montant']);

            $nouveauSolde = $client->getSolde() + $differenceMontant;
            $client->setSolde($nouveauSolde);
        }

        if (isset($data['date'])) {
            $dateVirementString = $request->request->get('date');
            $dateVirement = new \DateTimeImmutable($dateVirementString); // Ou new \DateTime($dateVirementString) si vous utilisez DateTime

            $virement->setDateVirement($dateVirement);
        }

        $this->entityManager->flush();

        $responseData = [
            'id' => $virement->getId(),
            'numeroVirement' => $virement->getNumeroVirement(),
            'numeroCompte' => $virement->getNumeroCompte(),
            'montant' => $virement->getMontant(),
            'dateVirement' => $virement->getDateVirement()
        ];

        return new JsonResponse(['virement' => $responseData, 'message' => 'Virement modifié avec succès'], Response::HTTP_OK);
    }

    #[Route('/supprimerVirement/{id}', name: 'supprimerVirement', methods: ['DELETE'])]
    public function supprimerVirement(Virement $virement, int $id): Response
    {
        $numeroCompte = $virement->getNumeroCompte();

        $client = $this->entityManager->getRepository(Client::class)->findOneBy(['numeroCompte' => $numeroCompte]);

        if (!$client) {
            return new JsonResponse(['message' => 'Client non trouvé pour ce virement'], Response::HTTP_NOT_FOUND);
        }

        // Soustraire le montant du virement du solde du client
        $nouveauSolde = $client->getSolde() - $virement->getMontant();
        $client->setSolde($nouveauSolde);

        $this->entityManager->remove($virement);
        $this->entityManager->flush();

        return $this->json(['message' => 'Virement supprimé avec succès, et le solde du client a été mis à jour'], Response::HTTP_OK);
    }
}
