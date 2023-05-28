<?php

namespace App\Controller\admin;

use App\Entity\Settings;
use App\Form\SettingsType;
use App\Repository\SettingsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/settings')]
class SettingsController extends AbstractController
{
    #[Route('/', name: 'app_admin_settings_index', methods: ['GET'])]
    public function index(SettingsRepository $settingsRepository): Response
    {
        return $this->render('admin/settings/index.html.twig', [
            'settings' => $settingsRepository->findAll()[0],
        ]);
    }

    #[Route('/new', name: 'app_admin_settings_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SettingsRepository $settingsRepository): Response
    {
        $setting = new Settings();
        $form = $this->createForm(SettingsType::class, $setting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $settingsRepository->save($setting, true);

            return $this->redirectToRoute('app_admin_settings_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/settings/new.html.twig', [
            'setting' => $setting,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_settings_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Settings $setting, SettingsRepository $settingsRepository): Response
    {
        $form = $this->createForm(SettingsType::class, $setting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $settingsRepository->save($setting, true);

            return $this->redirectToRoute('app_admin_settings_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/settings/edit.html.twig', [
            'setting' => $setting,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_settings_delete', methods: ['POST'])]
    public function delete(Request $request, Settings $setting, SettingsRepository $settingsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$setting->getId(), $request->request->get('_token'))) {
            $settingsRepository->remove($setting, true);
        }

        return $this->redirectToRoute('app_admin_settings_index', [], Response::HTTP_SEE_OTHER);
    }
}
