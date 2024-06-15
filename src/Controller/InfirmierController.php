<?php

namespace App\Controller;

use App\Entity\Infirmier;
use App\Form\InfirmierType;
use App\Repository\InfirmierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Knp\Component\Pager\PaginatorInterface;


#[Route('/infirmier')]
class InfirmierController extends AbstractController
{
    #[Route('/', name: 'app_infirmier_index', methods: ['GET'])]
    public function index(Request $request,
                          InfirmierRepository $infirmierRepository,
                          PaginatorInterface $paginator
                          ): Response
    {
        // recherche ------------------------------------------------------
        $searchTerm = $request->query->get('search');
        $infirmiers = [];

        if ($searchTerm) {
            $infirmiers = $infirmierRepository->searchByLetter($searchTerm);
        } else {
            $infirmiers = $infirmierRepository->findAll();
        }

        $query = $infirmierRepository->createQueryBuilder('p')
        ->getQuery();

        // pagination ------------------------------------------------------
        $query = $infirmierRepository->createQueryBuilder('p')
        ->getQuery();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            4  // Nombre de infirmiers par page
        );

        return $this->render('infirmier/index.html.twig', [
            'infirmiers' => $infirmiers,
            'searchTerm' => $searchTerm,
            'pagination' => $pagination,
        ]);
    }

    #[Route('/new', name: 'app_infirmier_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $infirmier = new Infirmier();
        $form = $this->createForm(InfirmierType::class, $infirmier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($infirmier);
            $entityManager->flush();
            $this->addFlash('success', 'Nouveau Infirmier créer avec succès!');

            return $this->redirectToRoute('app_infirmier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('infirmier/new.html.twig', [
            'infirmier' => $infirmier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_infirmier_show', methods: ['GET'])]
    public function show(Infirmier $infirmier): Response
    {
        return $this->render('infirmier/show.html.twig', [
            'infirmier' => $infirmier,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_infirmier_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Infirmier $infirmier, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(InfirmierType::class, $infirmier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success_edit', 'Infirmier éditer avec succès!');

            return $this->redirectToRoute('app_infirmier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('infirmier/edit.html.twig', [
            'infirmier' => $infirmier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_infirmier_delete', methods: ['POST'])]
    public function delete(Request $request, Infirmier $infirmier, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$infirmier->getId(), $request->request->get('_token'))) {
            $this->addFlash('success_delete', 'Infirmier supprimer avec succès!');

            $entityManager->remove($infirmier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_infirmier_index', [], Response::HTTP_SEE_OTHER);
    }
}
