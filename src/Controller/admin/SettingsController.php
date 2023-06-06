<?php

namespace App\Controller\admin;

use App\Entity\Settings;
use App\Form\SettingsType;
use App\Repository\SettingsRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/settings')]
class SettingsController extends AbstractController
{
    /**
     * @throws NonUniqueResultException
     */
    #[Route('/', name: 'app_admin_settings_index', methods: ['GET'])]
    public function index(SettingsRepository $settingsRepository): Response
    {
        return $this->render('admin/settings/index.html.twig', [
            'settings' => $settingsRepository->getSettings(),
        ]);
    }

    /**
     * @throws NonUniqueResultException
     */
    #[Route('/edit', name: 'app_admin_settings_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SettingsRepository $settingsRepository): Response
    {
        $settings = $settingsRepository->getSettings();

        $form = $this->createForm(SettingsType::class, $settings);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $settingsRepository->save($settings, true);

            return $this->redirectToRoute('app_admin_settings_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/settings/edit.html.twig', [
            'form' => $form,
        ]);
    }
}
