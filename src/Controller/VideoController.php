<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VideoController extends AbstractController
{
    #[Route('/videos', name: 'app_videos')]
    public function index(): Response
    {
        return $this->render('public/video/index.html.twig');
    }
}