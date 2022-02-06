<?php

namespace App\Controller;

use App\Entity\Meet;
use App\Form\MeetType;
use App\Repository\MeetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/meet')]
class MeetController extends AbstractController
{
    #[Route('/', name: 'calendar')]
    public function index(): Response
    {
        return $this->render('calendar/index.html.twig');
    }

    #[
        Route('/json', name: 'calendar_json', methods: ['GET'])
    ]
    public function sendJsonMeetings(MeetRepository $meetRepository): Response
    {
        $data = $meetRepository->findAll();
        $jsonArr = [];
        foreach ($data as $value) {
            $jsonArr[] = [
                'title' => $value->getContact()->getName(),
                'start' => $value->getMeetingStart(),
                'end' => $value->getMeetingEnd()
            ];
        }

        return $this->json($jsonArr, 200, [], ['groups' => 'meet:read']);
    }

    #[Route('/new', name: 'meet_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $meet = new Meet();
        $form = $this->createForm(MeetType::class, $meet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($meet);
            $entityManager->flush();

            return $this->redirectToRoute('calendar', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('meet/new.html.twig', [
            'meet' => $meet,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'meet_show', methods: ['GET'])]
    public function show(Meet $meet): Response
    {
        return $this->render('meet/show.html.twig', [
            'meet' => $meet,
        ]);
    }

    #[Route('/{id}/edit', name: 'meet_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Meet $meet, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MeetType::class, $meet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('meet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('meet/edit.html.twig', [
            'meet' => $meet,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'meet_delete', methods: ['POST'])]
    public function delete(Request $request, Meet $meet, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $meet->getId(), $request->request->get('_token'))) {
            $entityManager->remove($meet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('meet_index', [], Response::HTTP_SEE_OTHER);
    }
}
