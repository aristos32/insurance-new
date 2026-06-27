<?php

namespace App\Controller;

use App\Entity\Crm\Note;
use App\Form\NoteFormType;
use App\Repository\NoteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/notes')]
final class NoteController extends AbstractController
{
    #[Route('', name: 'app_note_index')]
    public function index(Request $request, NoteRepository $repository): Response
    {
        return $this->render('note/index.html.twig', [
            'notes' => $repository->findBy([], ['entryDate' => 'DESC'], 100),
            'query' => $request->query->get('q'),
        ]);
    }

    #[Route('/new', name: 'app_note_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $note = (new Note())->setEntryDate(new \DateTime());
        $form = $this->createForm(NoteFormType::class, $note);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($note);
            $em->flush();

            return $this->redirectToRoute('app_note_index');
        }

        return $this->render('note/form.html.twig', ['form' => $form]);
    }
}
