<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserRoles;
use App\Form\User2Type;
use App\Repository\UserRepository;
use App\Repository\RolesRepository;
use App\Repository\UserRolesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/user/managements'), IsGranted('IS_AUTHENTICATED_FULLY')]
class UserManagementsController extends AbstractController
{
    
    #[Route('/', name: 'user_managements_index', methods: ['GET'])]
    public function index(UserRepository $userRepository, RolesRepository $rolesRepository): Response
    {
        $users = $userRepository->getAllUsers();
        $roles = $rolesRepository->findAll();
        $rolesData = array();
        foreach($roles as $role) {
            $rolesData[$role->getId()] = $role->getNombreRole();
        }
        return $this->render('user_managements/index.html.twig', [
            'users' => $users,
            'roles' => $rolesData,
        ]);
    }

    #[Route('/new', name: 'user_managements_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher, RolesRepository $rolesRepository): Response
    {
        $user = new User();
        $roles = $rolesRepository->findAll();
        $form = $this->createForm(User2Type::class, $user, [
            "roles" => $roles,
            "edit" => false,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $user->setActivoUsu(1);
            $user->setTipoUsu("");
            $user->setBorradoUsu(0);
            $user->setUsuCUsu($this->getUser()->getId());
            $user->setFechaCUsu(new \DateTime());
            $entityManager->persist($user);
            $entityManager->flush();

            $plainpwd = $user->getPassword();
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $plainpwd
            );
            $user->setPassword($hashedPassword);
            $entityManager->flush();
            
            // insert roles
            $roles = $user->getRoles();
            foreach($roles as $roleId) {
                $userRoles = new UserRoles();
                $userRoles->setIdRole($roleId);
                $userRoles->setIdUser($user->getId());
                $entityManager->persist($userRoles);
                $entityManager->flush();
            }

            return $this->redirectToRoute('user_managements_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user_managements/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'user_managements_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user_managements/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'user_managements_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher, RolesRepository $rolesRepository, UserRolesRepository $userRolesRepository): Response
    {
        $roles = $rolesRepository->findAll();
        $form = $this->createForm(User2Type::class, $user, [
            "roles" => $roles,
            "edit" => true,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setUsuMUsu($this->getUser()->getId());
            $user->setFechaMUsu(new \DateTime());
            $entityManager->persist($user);
            $entityManager->flush();

            // remove prev roles
            $prevUserRoles = $userRolesRepository->getUserRoles($user->getId());
            foreach($prevUserRoles as $prevUserRole) {
                $entityManager->remove($prevUserRole);
                $entityManager->flush();
            }
            // add roles
            $roles = $user->getRoles();
            foreach($roles as $roleId) {
                $userRoles = new UserRoles();
                $userRoles->setIdRole($roleId);
                $userRoles->setIdUser($user->getId());
                $entityManager->persist($userRoles);
                $entityManager->flush();
            }

            return $this->redirectToRoute('user_managements_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user_managements/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'user_managements_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_managements_index', [], Response::HTTP_SEE_OTHER);
    }
}
