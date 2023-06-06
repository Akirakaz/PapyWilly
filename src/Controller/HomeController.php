<?php

namespace App\Controller;

use App\Repository\HardwareRepository;
use App\Repository\SettingsRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @throws NonUniqueResultException
     */
    #[Route('/', name: 'app_home')]
    public function index(HardwareRepository $hardwareRepository, SettingsRepository $settingsRepository): Response
    {
        return $this->render('public/home/index.html.twig', [
            'hardwares' => $hardwareRepository->findAll(),
            'settings' => $settingsRepository->getSettings(),
        ]);
    }
}
