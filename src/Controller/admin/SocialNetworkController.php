<?php

namespace App\Controller\admin;

use App\Entity\SocialNetwork;
use App\Form\SocialNetworkType;
use App\Repository\SocialNetworkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/social-network')]
class SocialNetworkController extends AbstractController
{
    #[Route('/', name: 'app_admin_social_network_index', methods: ['GET'])]
    public function index(SocialNetworkRepository $socialNetworkRepository): Response
    {
        return $this->render('admin/social_network/index.html.twig', [
            'social_networks' => $socialNetworkRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_social_network_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SocialNetworkRepository $socialNetworkRepository): Response
    {
        $socialNetwork = new SocialNetwork();
        $form = $this->createForm(SocialNetworkType::class, $socialNetwork);

        $form->add('saveAndAdd', SubmitType::class, ['label' => 'Ajouter un autre']);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $socialNetworkRepository->save($socialNetwork, true);

            $nextAction = $form->get('saveAndAdd')->isClicked()
                ? 'app_admin_social_network_new'
                : 'app_admin_social_network_index';

            $this->addFlash('succès', "Le réseau social a bien été enregistré.");

            return $this->redirectToRoute($nextAction);
        }

        return $this->render('admin/social_network/new.html.twig', [
            'social_network' => $socialNetwork,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_social_network_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SocialNetwork $socialNetwork, SocialNetworkRepository $socialNetworkRepository): Response
    {
        $form = $this->createForm(SocialNetworkType::class, $socialNetwork);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $socialNetworkRepository->save($socialNetwork, true);

            $this->addFlash('succès', "Le réseau social a bien été mis à jour.");

            return $this->redirectToRoute('app_admin_social_network_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/social_network/edit.html.twig', [
            'social_network' => $socialNetwork,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_social_network_delete', methods: ['POST'])]
    public function delete(Request $request, SocialNetwork $socialNetwork, SocialNetworkRepository $socialNetworkRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$socialNetwork->getId(), $request->request->get('_token'))) {
            $socialNetworkRepository->remove($socialNetwork, true);

            $this->addFlash('succès', "Le réseau social a bien été supprimé.");
        }

        return $this->redirectToRoute('app_admin_social_network_index', [], Response::HTTP_SEE_OTHER);
    }
}
