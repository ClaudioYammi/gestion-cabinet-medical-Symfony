<?php

namespace App\Controller;

use App\Repository\ChambreRepository;
use App\Repository\ConsultationRepository;
use App\Repository\InfirmierRepository;
use App\Repository\MedecinRepository;
use App\Repository\PatientRepository;
use App\Repository\PlanningRepository;
use App\Repository\PrescriptionRepository;
use App\Repository\ServiceRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
        public function index( chambreRepository $chambreRepository,
        ConsultationRepository $consultationRepository,
        InfirmierRepository $infirmierRepository,
        MedecinRepository $medecinRepository,
        PatientRepository $patientRepository,
        PlanningRepository $planningRepository,
        PrescriptionRepository $prescriptionRepository,
        ServiceRepository $serviceRepository,
        UserRepository $userRepository
        ): Response
    {
        $chambreCount = $chambreRepository->count([]);
        $consultationCount = $consultationRepository->count([]);
        $infirmierCount = $infirmierRepository->count([]);
        $medecinCount = $medecinRepository->count([]);
        $patientCount = $patientRepository->count([]);
        $planningCount =  $planningRepository->count([]);
        $prescriptionCount =  $prescriptionRepository->count([]);
        $serviceCount = $serviceRepository->count([]);
        $userCount = $userRepository->count([]);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',

            'chambreCount' => $chambreCount,
            'consultationCount' => $consultationCount,
            'infirmierCount' => $infirmierCount,
            'medecinCount' => $medecinCount,
            'patientCount' => $patientCount,
            'planningCount' => $planningCount,
            'prescriptionCount' => $prescriptionCount,
            'serviceCount' => $serviceCount,
            'userCount' => $userCount,
        ]);
    }
}
