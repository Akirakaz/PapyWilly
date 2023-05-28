<?php

namespace App\Controller;

use App\Repository\SettingsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StreamController extends AbstractController
{
    #[Route('/stream', name: 'app_stream')]
    public function index(SettingsRepository $settingsRepository): Response
    {
        return $this->render('public/stream/index.html.twig', [
            'settings' => $settingsRepository->findAll()[0],
        ]);
    }
}
