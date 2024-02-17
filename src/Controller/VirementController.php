<?php

namespace App\Controller;

use App\Entity\Virement;
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

    #[Route('/ajouterVirement')]

    #[Route('/afficherVirement', name: 'afficherVirement', methods: ['GET'])]
    public function afficheVirement(): Response
    {
        $virements = $this->entityManager->getRepository(Virement::class)->findAll();

        $data = [];

        foreach($virements as $virement) {
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
