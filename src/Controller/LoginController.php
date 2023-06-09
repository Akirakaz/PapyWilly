<?php

namespace App\Controller;

use App\Form\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_admin_dashboard');
        }

        $form = $this->createForm(LoginType::class);

        $lastUsername = $authenticationUtils->getLastUsername();

        $form->get('username')->setData($lastUsername);

        return $this->render('public/login/index.html.twig', [
            'form' => $form->createView(),
            'error' => $authenticationUtils->getLastAuthenticationError(),
        ]);
    }

    #[Route('/connexion/success', name: 'app_login_success')]
    public function login_success(): RedirectResponse
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        $this->addFlash('succès', "Vous êtes connecté");

        return $this->redirectToRoute('app_admin_dashboard');
    }


    /**
     * @throws \Exception
     */
    #[Route('/logout', name: 'app_logout', methods: ['GET'])]
    public function logout()
    {
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }

    #[Route('/logout/success', name: 'app_logout_success', methods: ['GET'])]
    public function logout_success(): RedirectResponse
    {
        $this->addFlash('succès', 'Vous êtes déconnecté(e).');

        return $this->redirectToRoute('app_home');
    }
}
