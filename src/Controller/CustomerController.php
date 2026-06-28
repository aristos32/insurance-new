<?php

namespace App\Controller;

use App\Entity\Crm\Customer;
use App\Enum\CustomerType;
use App\Enum\HistoryType;
use App\Form\CustomerTypeForm;
use App\Repository\CustomerRepository;
use App\Service\HistoryService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/customers')]
#[IsGranted('ROLE_EMPLOYEE')]
final class CustomerController extends AbstractController
{
    #[Route('', name: 'app_customer_index')]
    public function index(Request $request, CustomerRepository $repository): Response
    {
        $type = CustomerType::tryFrom((string) $request->query->get('type', ''));
        $customers = $repository->search($request->query->get('q'), $type);

        return $this->render('customer/index.html.twig', [
            'customers' => $customers,
            'query' => $request->query->get('q'),
            'type' => $type,
        ]);
    }

    #[Route('/new', name: 'app_customer_new')]
    public function new(Request $request, EntityManagerInterface $em, HistoryService $history): Response
    {
        $customer = (new Customer())->setType(CustomerType::Customer);
        $form = $this->createForm(CustomerTypeForm::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($customer);
            $history->log(HistoryType::Customer, 'CREATE', 'stateId', $customer->getStateId(), 'Customer created');
            $em->flush();

            return $this->redirectToRoute('app_customer_show', ['stateId' => $customer->getStateId()]);
        }

        return $this->render('customer/form.html.twig', [
            'form' => $form,
            'title' => 'New Customer',
        ]);
    }

    #[Route('/{stateId}', name: 'app_customer_show', methods: ['GET'])]
    public function show(string $stateId, CustomerRepository $repository): Response
    {
        $customer = $repository->find($stateId);
        if (!$customer) {
            throw $this->createNotFoundException();
        }

        return $this->render('customer/show.html.twig', ['customer' => $customer]);
    }

    #[Route('/{stateId}/edit', name: 'app_customer_edit')]
    public function edit(string $stateId, Request $request, CustomerRepository $repository, EntityManagerInterface $em, HistoryService $history): Response
    {
        $customer = $repository->find($stateId);
        if (!$customer) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(CustomerTypeForm::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $history->log(HistoryType::Customer, 'UPDATE', 'stateId', $customer->getStateId(), 'Customer updated');
            $em->flush();

            return $this->redirectToRoute('app_customer_show', ['stateId' => $customer->getStateId()]);
        }

        return $this->render('customer/form.html.twig', [
            'form' => $form,
            'title' => 'Edit Customer',
        ]);
    }

    #[Route('/{stateId}/delete', name: 'app_customer_delete', methods: ['POST'])]
    public function delete(string $stateId, Request $request, CustomerRepository $repository, EntityManagerInterface $em): Response
    {
        $customer = $repository->find($stateId);
        if ($customer && $this->isCsrfTokenValid('delete' . $stateId, $request->request->get('_token'))) {
            $em->remove($customer);
            $em->flush();
        }

        return $this->redirectToRoute('app_customer_index');
    }
}
