<?php

namespace App\Controller;

use App\Repository\ProgrammeRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(ProgrammeRepository $programmeRepository)
    {
        $programmes = $programmeRepository->findAll();

        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'programmes' => $programmes,
        ]);
    }

    /**
     * @Route("/membre/{nom}", name="membre")
     */
    public function membre(UserRepository $userRepository)
    {
        $membres = $userRepository->findAll();

        return $this->render('accueil/membre.html.twig', [
            'controller_name' => 'AccueilController',
            'membres' => $membres,
        ]);
    }
}
