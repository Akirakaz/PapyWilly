<?php

namespace App\Controller;

use App\Entity\Banner;
use App\Form\BannerType;
use App\Repository\BannerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/banner')]
class BannerController extends AbstractController
{
    #[Route('/', name: 'app_admin_banner_index', methods: ['GET'])]
    public function index(BannerRepository $bannerRepository): Response
    {
        return $this->render('admin/banner/index.html.twig', [
            'banners' => $bannerRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_banner_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BannerRepository $bannerRepository): Response
    {
        $banner = new Banner();
        $form = $this->createForm(BannerType::class, $banner);
        $form->add('saveAndAdd', SubmitType::class, ['label' => 'Ajouter une autre']);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bannerRepository->save($banner, true);

            $nextAction = $form->get('saveAndAdd')->isClicked()
                ? 'app_admin_banner_new'
                : 'app_admin_banner_index';

            return $this->redirectToRoute($nextAction);
        }

        return $this->render('admin/banner/new.html.twig', [
            'banner' => $banner,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_banner_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Banner $banner, BannerRepository $bannerRepository): Response
    {
        $form = $this->createForm(BannerType::class, $banner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bannerRepository->save($banner, true);

            return $this->redirectToRoute('app_admin_banner_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/banner/edit.html.twig', [
            'banner' => $banner,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_banner_delete', methods: ['POST'])]
    public function delete(Request $request, Banner $banner, BannerRepository $bannerRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$banner->getId(), $request->request->get('_token'))) {
            $bannerRepository->remove($banner, true);
        }

        return $this->redirectToRoute('app_admin_banner_index', [], Response::HTTP_SEE_OTHER);
    }
}
