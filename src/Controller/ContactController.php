<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Flasher\Toastr\Prime\ToastrFactory;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\LetterCategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Flasher\SweetAlert\Prime\SweetAlertFactory;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[
    Route('/contact'),
    IsGranted('ROLE_USER')
]
class ContactController extends AbstractController
{
    #[Route('/new', name: 'contact_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, LetterCategoryRepository $letterCategoryRepository, ToastrFactory $flasher): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactFirstletter = substr($form->get('name')->getData(), 0, 1);
            if ($letterCategoryRepository->findOneBy(['letter' => $contactFirstletter])) {
                $letterCategory = $letterCategoryRepository->findOneBy(['letter' => $contactFirstletter]);
            } else {
                $letterCategory = $letterCategoryRepository->findOneBy(['letter' => '#']);
            }
            $contact->setLetterCategory($letterCategory);
            $entityManager->persist($contact);
            $entityManager->flush();

            $flasher->addSuccess('Le contact a bien été créé !');

            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contact/new.html.twig', [
            'contact' => $contact,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'contact_show', methods: ['GET'])]
    public function show(Contact $contact): Response
    {
        return $this->render('contact/show.html.twig', [
            'contact' => $contact,
        ]);
    }

    #[Route('/{id}/edit', name: 'contact_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Contact $contact, EntityManagerInterface $entityManager, LetterCategoryRepository $letterCategoryRepository): Response
    {
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactFirstletter = substr($form->get('name')->getData(), 0, 1);
            if ($letterCategoryRepository->findOneBy(['letter' => $contactFirstletter])) {
                $letterCategory = $letterCategoryRepository->findOneBy(['letter' => $contactFirstletter]);
            } else {
                $letterCategory = $letterCategoryRepository->findOneBy(['letter' => '#']);
            }
            $contact->setLetterCategory($letterCategory);
            $contact->setUpdatedAt(new \DateTime('now'));
            $entityManager->flush();

            return $this->redirectToRoute('contact_show', ['id' => $contact->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contact/edit.html.twig', [
            'contact' => $contact,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'contact_delete', methods: ['POST'])]
    public function delete(Request $request, Contact $contact, EntityManagerInterface $entityManager, SweetAlertFactory $flasher): Response
    {
        if ($this->isCsrfTokenValid('delete' . $contact->getId(), $request->request->get('_token'))) {
            $entityManager->remove($contact);
            $entityManager->flush();
        }
        $builder = $flasher->type('confirm');
        $builder->titleText('Supprimer un contact')
                ->question('Êtes-vous sûr de vouloir supprimer ce contact ?')
                ->icon('error')
                ->showCancelButton(true, 'Non, annuler')
                ->showConfirmButton(true, 'Oui, le supprimer');
        
        // $builder->flash();
        
        return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
    }
}
