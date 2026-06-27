<?php

namespace App\Controller;

use App\Form\TransactionType;
use App\Repository\SaleRepository;
use App\Service\TransactionService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/transactions')]
final class TransactionController extends AbstractController
{
    #[Route('/contract/{saleId}', name: 'app_transaction_index')]
    public function index(string $saleId, SaleRepository $saleRepository): Response
    {
        $sale = $saleRepository->find($saleId);
        if (!$sale) {
            throw $this->createNotFoundException();
        }

        return $this->render('transaction/index.html.twig', ['sale' => $sale]);
    }

    #[Route('/new/{saleId}', name: 'app_transaction_new')]
    public function new(
        string $saleId,
        Request $request,
        SaleRepository $saleRepository,
        TransactionService $transactionService,
        EntityManagerInterface $em,
    ): Response {
        $sale = $saleRepository->find($saleId);
        if (!$sale) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(TransactionType::class, ['sale' => $sale]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $transactionService->addTransaction(
                $data['sale'],
                $data['details'],
                $data['debit'] ? (float) $data['debit'] : null,
                $data['credit'] ? (float) $data['credit'] : null,
                $data['receiptNo'],
            );
            $em->flush();

            return $this->redirectToRoute('app_transaction_index', ['saleId' => $saleId]);
        }

        return $this->render('transaction/form.html.twig', [
            'form' => $form,
            'sale' => $sale,
        ]);
    }
}
