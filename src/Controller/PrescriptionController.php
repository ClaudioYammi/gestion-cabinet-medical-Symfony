<?php

namespace App\Controller;

use App\Entity\Prescription;
use App\Form\PrescriptionType;
use App\Repository\PrescriptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Knp\Component\Pager\PaginatorInterface;

#[Route('/prescription')]
class PrescriptionController extends AbstractController
{
    #[Route('/', name: 'app_prescription_index', methods: ['GET'])]
    public function index(Request $request,
                          PrescriptionRepository $prescriptionRepository,
                          PaginatorInterface $paginator
                          ): Response
    {
         // recherche ------------------------------------------------------
         $searchTerm = $request->query->get('search');
         $prescriptions = [];
 
         if ($searchTerm) {
             $prescriptions = $prescriptionRepository->searchByLetter($searchTerm);
         } else {
             $prescriptions = $prescriptionRepository->findAll();
         }
 
         $query = $prescriptionRepository->createQueryBuilder('p')
         ->getQuery();
 
         // pagination ------------------------------------------------------
         $query = $prescriptionRepository->createQueryBuilder('p')
         ->getQuery();
 
         $pagination = $paginator->paginate(
             $query,
             $request->query->getInt('page', 1),
             4  // Nombre de prescriptions par page
         );

        return $this->render('prescription/index.html.twig', [
            'prescriptions' => $prescriptions,
            'searchTerm' => $searchTerm,
            'pagination' => $pagination,
        ]);
    }

    #[Route('/new', name: 'app_prescription_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $prescription = new Prescription();
        $form = $this->createForm(PrescriptionType::class, $prescription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($prescription);
            $entityManager->flush();
            $this->addFlash('success', 'Nouveau Prescription créer avec succès!');


            return $this->redirectToRoute('app_prescription_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('prescription/new.html.twig', [
            'prescription' => $prescription,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_prescription_show', methods: ['GET'])]
    public function show(Prescription $prescription): Response
    {
        return $this->render('prescription/show.html.twig', [
            'prescription' => $prescription,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_prescription_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Prescription $prescription, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PrescriptionType::class, $prescription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success_edit', 'Prescription éditer avec succès!');


            return $this->redirectToRoute('app_prescription_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('prescription/edit.html.twig', [
            'prescription' => $prescription,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_prescription_delete', methods: ['POST'])]
    public function delete(Request $request, Prescription $prescription, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$prescription->getId(), $request->request->get('_token'))) {
            $entityManager->remove($prescription);
            $entityManager->flush();
            $this->addFlash('success_delete', 'Prescription supprimer avec succès!');

        }

        return $this->redirectToRoute('app_prescription_index', [], Response::HTTP_SEE_OTHER);
    }
}
