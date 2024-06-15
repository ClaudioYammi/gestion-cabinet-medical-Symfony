<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Form\PatientType;
use App\Repository\PatientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Knp\Component\Pager\PaginatorInterface;




#[Route('/patient')]
class PatientController extends AbstractController
{
    #[Route('/', name: 'app_patient_index', methods: ['GET'])]
    public function index(Request $request, 
                          PatientRepository $patientRepository, 
                          PaginatorInterface $paginator
                          ): Response
    {
        // recherche ------------------------------------------------------
        $searchTerm = $request->query->get('search');
        $patients = [];

        if ($searchTerm) {
            $patients = $patientRepository->searchByLetter($searchTerm);
        } else {
            $patients = $patientRepository->findAll();
        }

        $query = $patientRepository->createQueryBuilder('p')
        ->getQuery();

        // pagination ------------------------------------------------------
        $query = $patientRepository->createQueryBuilder('p')
        ->getQuery();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            4  // Nombre de patients par page
        );

        
            return $this->render('patient/index.html.twig', [
                'patients' => $patients,
                'searchTerm' => $searchTerm,
                'pagination' => $pagination,
            ]);
        }


    #[Route('/new', name: 'app_patient_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $patient = new Patient();
        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($patient);
            $entityManager->flush();
            // flashmessage -------------------------------------------------------------------------
            $this->addFlash('success', 'Nouveau patient créer avec succès!');
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $newFilename = uniqid().'.'.$imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('uploads_directory'),
                        $newFilename
                    );
                } catch (\Exception $e) {
                    // Gérer les erreurs de téléchargement d'image
                }

                $patient->setImage($newFilename);
            }

            $entityManager->persist($patient);
            $entityManager->flush();
                return $this->redirectToRoute('app_patient_index', [], Response::HTTP_SEE_OTHER);
            }

        return $this->render('patient/new.html.twig', [
            'patient' => $patient,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_patient_show', methods: ['GET'])]
    public function show(Patient $patient): Response
    {
        return $this->render('patient/show.html.twig', [
            'patient' => $patient,

        ]);
    }

    #[Route('/{id}/edit', name: 'app_patient_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Patient $patient, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success_edit', 'Patient éditer avec succès!');

            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $newFilename = uniqid().'.'.$imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('uploads_directory'),
                        $newFilename
                    );
                } catch (\Exception $e) {
                    // Gérer les erreurs de téléchargement d'image
                }

                $patient->setImage($newFilename);
            }

            $entityManager->flush();
        
            return $this->redirectToRoute('app_patient_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('patient/edit.html.twig', [
            'patient' => $patient,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_patient_delete', methods: ['POST'])]
    public function delete(Request $request, Patient $patient, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$patient->getId(), $request->request->get('_token'))) {
            $this->addFlash('success_delete', 'Patient supprimer avec succès!');
            
            $entityManager->remove($patient);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_patient_index', [], Response::HTTP_SEE_OTHER);
    }

    
}
