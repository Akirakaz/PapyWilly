<?php

namespace App\Controller;

use App\Enums\CacheExpirationEnums;
use App\Repository\BannerRepository;
use App\Repository\HardwareRepository;
use App\Repository\SettingsRepository;
use App\Service\CacheSystem;
use Doctrine\ORM\NonUniqueResultException;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @throws NonUniqueResultException
     * @throws InvalidArgumentException
     */
    #[Route('/', name: 'app_home')]
    public function index(
        CacheSystem $cacheSystem,
        HardwareRepository $hardwareRepository,
        SettingsRepository $settingsRepository,
        BannerRepository $bannerRepository
    ): Response
    {
        if (!$cacheSystem->isHit('hardware')) {
            $cacheSystem->setCache('hardware', $hardwareRepository->findAll(), CacheExpirationEnums::HOURS_1);
        }

        if (!$cacheSystem->isHit('settings')) {
            $cacheSystem->setCache('settings', $settingsRepository->getSettings(), CacheExpirationEnums::HOURS_1);
        }

        if (!$cacheSystem->isHit('banners')) {
            $cacheSystem->setCache('banners', $bannerRepository->findAll(), CacheExpirationEnums::HOURS_1);
        }

        return $this->render('public/home/index.html.twig', [
            'hardwares' => $cacheSystem->getCache('hardware'),
            'settings'  => $cacheSystem->getCache('settings'),
            'banners'   => $cacheSystem->getCache('banners'),
        ]);
    }
}
