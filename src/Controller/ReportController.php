<?php

namespace App\Controller;

use App\Repository\SaleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/reports')]
final class ReportController extends AbstractController
{
    #[Route('', name: 'app_report_index')]
    public function index(): Response
    {
        return $this->render('report/index.html.twig');
    }

    #[Route('/expiring', name: 'app_report_expiring')]
    public function expiring(Request $request, SaleRepository $repository): Response
    {
        $days = (int) $request->query->get('days', 30);
        $from = new \DateTime();
        $to = (new \DateTime())->modify('+' . $days . ' days');

        return $this->render('report/expiring.html.twig', [
            'sales' => $repository->findExpiringBetween($from, $to),
            'days' => $days,
        ]);
    }

    #[Route('/balances', name: 'app_report_balances')]
    public function balances(SaleRepository $repository): Response
    {
        return $this->render('report/balances.html.twig', [
            'sales' => $repository->findWithBalance(),
        ]);
    }
}
