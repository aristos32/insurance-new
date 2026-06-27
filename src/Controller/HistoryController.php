<?php

namespace App\Controller;

use App\Enum\HistoryType;
use App\Repository\HistoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/history')]
final class HistoryController extends AbstractController
{
    #[Route('', name: 'app_history_index')]
    public function index(Request $request, HistoryRepository $repository): Response
    {
        return $this->render('history/index.html.twig', [
            'entries' => $repository->search(
                HistoryType::tryFrom((string) $request->query->get('type', '')),
                $request->query->get('q'),
            ),
            'query' => $request->query->get('q'),
        ]);
    }
}
