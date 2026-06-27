<?php

namespace App\Controller;

use App\Entity\Crm\Owner;
use App\Enum\HistoryType;
use App\Enum\OwnerType;
use App\Form\OwnerTypeForm;
use App\Repository\OwnerRepository;
use App\Service\HistoryService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/clients')]
final class OwnerController extends AbstractController
{
    #[Route('', name: 'app_owner_index')]
    public function index(Request $request, OwnerRepository $repository): Response
    {
        $type = OwnerType::tryFrom((string) $request->query->get('type', ''));
        $owners = $repository->search($request->query->get('q'), $type);

        return $this->render('owner/index.html.twig', [
            'owners' => $owners,
            'query' => $request->query->get('q'),
            'type' => $type,
        ]);
    }

    #[Route('/new', name: 'app_owner_new')]
    public function new(Request $request, EntityManagerInterface $em, HistoryService $history): Response
    {
        $owner = (new Owner())->setType(OwnerType::Account);
        $form = $this->createForm(OwnerTypeForm::class, $owner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($owner);
            $history->log(HistoryType::Client, 'CREATE', 'stateId', $owner->getStateId(), 'Client created');
            $em->flush();

            return $this->redirectToRoute('app_owner_show', ['stateId' => $owner->getStateId()]);
        }

        return $this->render('owner/form.html.twig', [
            'form' => $form,
            'title' => 'New Client',
        ]);
    }

    #[Route('/{stateId}', name: 'app_owner_show', methods: ['GET'])]
    public function show(string $stateId, OwnerRepository $repository): Response
    {
        $owner = $repository->find($stateId);
        if (!$owner) {
            throw $this->createNotFoundException();
        }

        return $this->render('owner/show.html.twig', ['owner' => $owner]);
    }

    #[Route('/{stateId}/edit', name: 'app_owner_edit')]
    public function edit(string $stateId, Request $request, OwnerRepository $repository, EntityManagerInterface $em, HistoryService $history): Response
    {
        $owner = $repository->find($stateId);
        if (!$owner) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(OwnerTypeForm::class, $owner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $history->log(HistoryType::Client, 'UPDATE', 'stateId', $owner->getStateId(), 'Client updated');
            $em->flush();

            return $this->redirectToRoute('app_owner_show', ['stateId' => $owner->getStateId()]);
        }

        return $this->render('owner/form.html.twig', [
            'form' => $form,
            'title' => 'Edit Client',
        ]);
    }

    #[Route('/{stateId}/delete', name: 'app_owner_delete', methods: ['POST'])]
    public function delete(string $stateId, Request $request, OwnerRepository $repository, EntityManagerInterface $em): Response
    {
        $owner = $repository->find($stateId);
        if ($owner && $this->isCsrfTokenValid('delete' . $stateId, $request->request->get('_token'))) {
            $em->remove($owner);
            $em->flush();
        }

        return $this->redirectToRoute('app_owner_index');
    }
}
