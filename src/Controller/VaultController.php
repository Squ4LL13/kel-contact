<?php

namespace App\Controller;

use App\Entity\Vault;
use App\Form\VaultType;
use App\Repository\VaultRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[
    Route('/vault'),
    IsGranted('ROLE_USER')
]
class VaultController extends AbstractController
{
    #[Route('/', name: 'vault_index', methods: ['GET'])]
    public function index(VaultRepository $vaultRepository): Response
    {
        return $this->render('vault/index.html.twig', [
            'vaults' => $vaultRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'vault_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $vault = new Vault();
        $form = $this->createForm(VaultType::class, $vault);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($vault);
            $entityManager->flush();

            return $this->redirectToRoute('vault_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vault/new.html.twig', [
            'vault' => $vault,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'vault_show', methods: ['GET'])]
    public function show(Vault $vault): Response
    {
        return $this->render('vault/show.html.twig', [
            'vault' => $vault,
        ]);
    }

    #[Route('/{id}/edit', name: 'vault_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Vault $vault, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VaultType::class, $vault);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vault->setUpdatedAt(new \DateTime());
            $entityManager->flush();

            return $this->redirectToRoute('vault_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vault/edit.html.twig', [
            'vault' => $vault,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'vault_delete', methods: ['POST'])]
    public function delete(Request $request, Vault $vault, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $vault->getId(), $request->request->get('_token'))) {
            $entityManager->remove($vault);
            $entityManager->flush();
        }

        return $this->redirectToRoute('vault_index', [], Response::HTTP_SEE_OTHER);
    }
}
