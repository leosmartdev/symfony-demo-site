<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserRoles;
use App\Form\User3Type;
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


use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/contoller/view'), IsGranted('IS_AUTHENTICATED_FULLY')]
class ContollerViewController extends AbstractController
{
    #[Route('/', name: 'contoller_view_index', methods: ['GET'])]
    public function index(UserRepository $userRepository, Connection $conn, RolesRepository $rolesRepository): Response
    {
        $cur_rol = $this->getUser()->getCountry();
        $users = $userRepository->getAllUsers(["country" => $cur_rol]);
        $roles = $rolesRepository->findAll();
        $rolesData = array();
        foreach($roles as $role) {
            $rolesData[$role->getId()] = $role->getNombreRole();
        }
        return $this->render('contoller_view/index.html.twig', [
            'users' => $users,
            'roles' => $rolesData,
        ]);
    }

    #[Route('/new', name: 'contoller_view_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher, RolesRepository $rolesRepository): Response
    {
        $user = new User();
        $roles = $rolesRepository->findAll();
        $form = $this->createForm(User3Type::class, $user, [
            "roles" => $roles,
            "edit" => false,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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

            return $this->redirectToRoute('contoller_view_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contoller_view/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'contoller_view_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('contoller_view/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'contoller_view_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher, RolesRepository $rolesRepository, UserRolesRepository $userRolesRepository): Response
    {
        $roles = $rolesRepository->findAll();
        $form = $this->createForm(User3Type::class, $user, [
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

            return $this->redirectToRoute('contoller_view_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contoller_view/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'contoller_view_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('contoller_view_index', [], Response::HTTP_SEE_OTHER);
    }
}
