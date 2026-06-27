<?php

namespace App\Controller;

use App\Entity\Crm\Sale;
use App\Entity\Crm\Vehicle;
use App\Enum\HistoryType;
use App\Enum\InsuranceType;
use App\Enum\SaleStatus;
use App\Form\SaleType;
use App\Repository\SaleRepository;
use App\Service\HistoryService;
use App\Service\TransactionService;
use App\Enum\TransactionDetail;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/contracts')]
final class SaleController extends AbstractController
{
    #[Route('', name: 'app_sale_index')]
    public function index(Request $request, SaleRepository $repository): Response
    {
        $sales = $repository->search(
            $request->query->get('q'),
            InsuranceType::tryFrom((string) $request->query->get('type', '')),
            SaleStatus::tryFrom((string) $request->query->get('status', '')),
        );

        return $this->render('sale/index.html.twig', [
            'sales' => $sales,
            'query' => $request->query->get('q'),
        ]);
    }

    #[Route('/new', name: 'app_sale_new')]
    public function new(
        Request $request,
        EntityManagerInterface $em,
        HistoryService $history,
        TransactionService $transactionService,
    ): Response {
        $sale = (new Sale())->setStatus(SaleStatus::Active);
        $form = $this->createForm(SaleType::class, $sale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($sale);

            if ($sale->getInsuranceType() === InsuranceType::Motor) {
                $vehicle = (new Vehicle())
                    ->setRegNumber('TBD')
                    ->setVehicleType('SALOON')
                    ->setCubicCapacity(0)
                    ->setManufacturedYear((int) date('Y'))
                    ->setVehicleDesign('REGULAR')
                    ->setSale($sale);
                $em->persist($vehicle);
            }

            $transactionService->addTransaction($sale, TransactionDetail::New, 0.0, null);
            $history->log(HistoryType::Contract, 'CREATE', 'saleId', $sale->getSaleId(), 'Contract created');
            $em->flush();

            return $this->redirectToRoute('app_sale_show', ['saleId' => $sale->getSaleId()]);
        }

        return $this->render('sale/form.html.twig', [
            'form' => $form,
            'title' => 'New Contract',
        ]);
    }

    #[Route('/{saleId}', name: 'app_sale_show', methods: ['GET'])]
    public function show(string $saleId, SaleRepository $repository): Response
    {
        $sale = $repository->find($saleId);
        if (!$sale) {
            throw $this->createNotFoundException();
        }

        return $this->render('sale/show.html.twig', ['sale' => $sale]);
    }

    #[Route('/{saleId}/edit', name: 'app_sale_edit')]
    public function edit(string $saleId, Request $request, SaleRepository $repository, EntityManagerInterface $em, HistoryService $history): Response
    {
        $sale = $repository->find($saleId);
        if (!$sale) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(SaleType::class, $sale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $history->log(HistoryType::Contract, 'UPDATE', 'saleId', $sale->getSaleId(), 'Contract updated');
            $em->flush();

            return $this->redirectToRoute('app_sale_show', ['saleId' => $sale->getSaleId()]);
        }

        return $this->render('sale/form.html.twig', [
            'form' => $form,
            'title' => 'Edit Contract',
        ]);
    }
}
