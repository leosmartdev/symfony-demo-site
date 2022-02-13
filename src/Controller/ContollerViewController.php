<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\User3Type;
use App\Repository\UserRepository;
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
    public function index(UserRepository $userRepository, Connection $conn): Response
    {
        // $cur_rol = $this->getUser()->getCountry();
        // return $this->render('contoller_view/index.html.twig', [
        //     'users' => $userRepository->findAll(),
        // ]);

        $cur_rol = $this->getUser()->getCountry();
        $queryBuilder = $conn->createQueryBuilder();
        $data = $queryBuilder->select('*')->from('symfony_demo_user')->where("country = '$cur_rol'")->execute()->fetchAll();
        return $this->render('contoller_view/index.html.twig', ['users' => $data]);
    }

    #[Route('/new', name: 'contoller_view_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(User3Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            $plainpwd = $user->getPassword();
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $plainpwd
            );
            $user->setPassword($hashedPassword);
            $entityManager->flush();

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
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $form = $this->createForm(User3Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            $plainpwd = $user->getPassword();
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $plainpwd
            );
            $user->setPassword($hashedPassword);
            $entityManager->flush();

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
