<?php

namespace App\Controller;

use App\Repository\HardwareRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(HardwareRepository $hardwareRepository): Response
    {
        return $this->render('public/home/index.html.twig', [
            'hardwares' => $hardwareRepository->findAll(),
        ]);
    }
}
