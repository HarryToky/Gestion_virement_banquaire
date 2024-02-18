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

class VirementController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/ajouterVirement', name: 'ajouterVirement', methods: ['POST'])]
    public function ajouterVierement(Request $request): Response
    {
        $numeroVirement = $request->request->get('numeroVirement');
        $numeroCompte = $request->request->get('numeroCompte');
        $montant = $request->request->get('montant');
        $dateViremnt = new \DateTime($request->request->get('dateVirement'));

        $client = $this->entityManager->getRepository(Client::class)->findOneBy(['numeroCompte' => $numeroCompte]);

        if (!$client) {
            return $this->json(['error' => 'Le numéro de compte spécifié n\'existe pas.'], Response::HTTP_BAD_REQUEST);
        }

        $virement = new Virement();
        $virement->setNumeroVirement($numeroVirement);
        $virement->setNumeroCompte($numeroCompte);
        $virement->setMontant($montant);
        $virement->setDateVirement($dateViremnt);

        $nouveauSolde = $client->getSolde() + $montant;
        $client->setSolde($nouveauSolde);

        $this->entityManager->persist($virement);
        $this->entityManager->flush();
        
        return $this->json(['message' => 'Virement ajouté avec succès'], Response::HTTP_CREATED);
    }


    #[Route('/afficherVirement', name: 'afficherVirement', methods: ['GET'])]
    public function afficheVirement(): Response
    {
        $virements = $this->entityManager->getRepository(Virement::class)->findAll();

        $data = [];

        foreach ($virements as $virement) {
            $data = [
                'id' => $virement->getId(),
                'numeroVirement' => $virement->getNumeroVirement(),
                'numeroCompte' => $virement->getNumeroCompte(),
                'montant' => $virement->getMontant(),
                'dateVirement' => $virement->getDateVirement()
            ];
        }

        return new JsonResponse($data);
    }
}
