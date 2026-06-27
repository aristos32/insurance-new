<?php

namespace App\Controller;

use App\Entity\Crm\StaffProfile;
use App\Form\StaffProfileType;
use App\Repository\StaffProfileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/staff')]
final class StaffController extends AbstractController
{
    #[Route('', name: 'app_staff_index')]
    public function index(Request $request, StaffProfileRepository $repository): Response
    {
        return $this->render('staff/index.html.twig', [
            'staff' => $repository->search($request->query->get('q')),
            'query' => $request->query->get('q'),
        ]);
    }

    #[Route('/new', name: 'app_staff_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $profile = new StaffProfile();
        $form = $this->createForm(StaffProfileType::class, $profile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($profile);
            $em->flush();

            return $this->redirectToRoute('app_staff_index');
        }

        return $this->render('staff/form.html.twig', [
            'form' => $form,
            'title' => 'New Staff Member',
        ]);
    }

    #[Route('/{username}/edit', name: 'app_staff_edit')]
    public function edit(string $username, Request $request, StaffProfileRepository $repository, EntityManagerInterface $em): Response
    {
        $profile = $repository->find($username);
        if (!$profile) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(StaffProfileType::class, $profile, ['edit_mode' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('app_staff_index');
        }

        return $this->render('staff/form.html.twig', [
            'form' => $form,
            'title' => 'Edit Staff Member',
        ]);
    }
}
