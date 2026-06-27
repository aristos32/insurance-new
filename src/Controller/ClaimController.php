<?php

namespace App\Controller;

use App\Entity\Crm\Claim;
use App\Form\ClaimType;
use App\Repository\ClaimRepository;
use App\Repository\OwnerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/claims')]
final class ClaimController extends AbstractController
{
    #[Route('', name: 'app_claim_index')]
    public function index(ClaimRepository $repository): Response
    {
        return $this->render('claim/index.html.twig', [
            'claims' => $repository->findBy([], ['claimDate' => 'DESC']),
        ]);
    }

    #[Route('/new/{stateId}', name: 'app_claim_new')]
    public function new(string $stateId, Request $request, OwnerRepository $ownerRepository, EntityManagerInterface $em): Response
    {
        $owner = $ownerRepository->find($stateId);
        if (!$owner) {
            throw $this->createNotFoundException();
        }

        $claim = (new Claim())->setOwner($owner)->setClaimDate(new \DateTime());
        $form = $this->createForm(ClaimType::class, $claim);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($claim);
            $em->flush();

            return $this->redirectToRoute('app_owner_show', ['stateId' => $stateId]);
        }

        return $this->render('claim/form.html.twig', [
            'form' => $form,
            'owner' => $owner,
        ]);
    }
}
