<?php

namespace App\Controller;

use App\Entity\AuditVirement;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuditVirementController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/afficherAuditVirements', name: 'afficherAuditVirements', methods:['GET'])]
    public function afficherClients(): JsonResponse
    {
        $auditVirements = $this->entityManager->getRepository(AuditVirement::class)->findAll();

        $data = [];

        foreach ($auditVirements as $auditVirement) {
            $data[] = [
                'id' => $auditVirement->getId(),
                'typeAction' => $auditVirement->getTypeAction(),
                'dateOperation' => $auditVirement->getDateOperation(),
                'numeroVirement' => $auditVirement->getNumeroVirement(),
                'numeroCompte' => $auditVirement->getNumeroCompte(),
                'nomClient' => $auditVirement->getNomClient(),
                'dateVirement' => $auditVirement->getDateVirement(),
                'ancienMontant' => $auditVirement->getMontantAncien(),
                'nouveauMontant' => $auditVirement->getMontantNouveau(),
                'utilisateur' => $auditVirement->getUtilisateur()
            ];
        }
        return new JsonResponse($data);
    }
    
}
