<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\Form\Type\ChangePasswordType;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RolesRepository;

/**
 * Controller used to manage current user.
 *
 * @author Romain Monteil <monteil.romain@gmail.com>
 */
#[Route('/profile'), IsGranted('IS_AUTHENTICATED_FULLY')]
class UserController extends AbstractController
{

    #[Route('/loginSuceess', methods: ['GET', 'POST'], name: 'login_success')]
    public function loginSuccess(RolesRepository $rolesRepository)
    {

        $cur_rol = $this->getUser()->getRoles();
        
        $adminRole = $rolesRepository->getRoleByName('ROLE_ADMIN');
        $controllerRole = $rolesRepository->getRoleByName('ROLE_CONTROLLER');
        if(in_array($adminRole->getId(), $cur_rol)) {
           return  $this->redirectToRoute('user_managements_index');
        }
        else if(in_array($controllerRole->getId(), $cur_rol)) {
           return  $this->redirectToRoute('contoller_view_index');
        }

        return  $this->redirectToRoute('user_view');
    }

    #[Route('/edit', methods: ['GET', 'POST'], name: 'user_edit')]
    public function edit(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'user.updated_successfully');

            return $this->redirectToRoute('user_edit');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/change-password', methods: ['GET', 'POST'], name: 'user_change_password')]
    public function changePassword(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(ChangePasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($passwordHasher->hashPassword($user, $form->get('newPassword')->getData()));
            $entityManager->flush();

            return $this->redirectToRoute('security_logout');
        }

        return $this->render('user/change_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
