<?php

namespace App\Controller;

use App\Repository\ContactRepository;
use App\Repository\LetterCategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(LetterCategoryRepository $letterCategoryRepository): Response
    {
        $letterGroup = $letterCategoryRepository->findAllOrderBy();
        return $this->render('home/index.html.twig', [
            'letterGroup' => $letterGroup,
        ]);
    }

    #[Route('/search/{query}', name: 'search', methods: ['GET'])]
    public function search($query, ContactRepository $contactRepository): Response
    {
        $data = $contactRepository->findContactSearch($query);
        return $this->json($data, 200, [], ['groups' => 'contact:read']);
    }
}
