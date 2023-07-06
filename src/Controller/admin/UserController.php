<?php

namespace App\Controller\admin;

use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/profile')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_admin_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = $userRepository->findOneBy(['id' => $this->getUser()]);

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $oldPassword = $form->get('oldPassword')->getData();
            $newPassword = $form->get('newPassword')->getData();

            if($oldPassword && $newPassword) {
                $user->setPassword($passwordHasher->hashPassword($user, $newPassword));

                $this->addFlash('succès', 'Le mot de passe a bien été changé.');
            }

            $userRepository->save($user, true);

            $this->addFlash('info', 'Vos informations ont bien été mises à jour.');

            return $this->redirectToRoute('app_admin_user_edit', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
}
