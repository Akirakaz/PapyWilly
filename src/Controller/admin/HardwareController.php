<?php

namespace App\Controller\admin;

use App\Entity\Hardware;
use App\Form\HardwareType;
use App\Repository\HardwareRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/hardware')]
class HardwareController extends AbstractController
{
    #[Route('/', name: 'app_admin_hardware_index', methods: ['GET'])]
    public function index(HardwareRepository $hardwareRepository): Response
    {
        return $this->render('admin/hardware/index.html.twig', [
            'hardwares' => $hardwareRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_hardware_new', methods: ['GET', 'POST'])]
    public function new(Request $request, HardwareRepository $hardwareRepository): Response
    {
        $hardware = new Hardware();
        $form = $this->createForm(HardwareType::class, $hardware);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hardwareRepository->save($hardware, true);

            $this->addFlash('succès', "Le matériel a bien été enregistré.");

            return $this->redirectToRoute('app_admin_hardware_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/hardware/new.html.twig', [
            'hardware' => $hardware,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_hardware_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Hardware $hardware, HardwareRepository $hardwareRepository): Response
    {
        $form = $this->createForm(HardwareType::class, $hardware);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hardwareRepository->save($hardware, true);

            $this->addFlash('succès', "Le matériel a bien été mis à jour.");

            return $this->redirectToRoute('app_admin_hardware_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/hardware/edit.html.twig', [
            'hardware' => $hardware,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_hardware_delete', methods: ['POST'])]
    public function delete(Request $request, Hardware $hardware, HardwareRepository $hardwareRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hardware->getId(), $request->request->get('_token'))) {
            $hardwareRepository->remove($hardware, true);

            $this->addFlash('succès', "Le matériel a bien été supprimé.");
        }

        return $this->redirectToRoute('app_admin_hardware_index', [], Response::HTTP_SEE_OTHER);
    }
}
