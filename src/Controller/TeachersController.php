<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Maestros;
use App\Entity\UserRoles;
use App\Form\WorkshopType;
use App\Repository\UserRepository;
use App\Repository\RolesRepository;
use App\Repository\MaestrosRepository;
use App\Repository\UserRolesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/teachers'), IsGranted('IS_AUTHENTICATED_FULLY')]
class TeachersController extends AbstractController
{
    
    #[Route('/', name: 'teacher_list', methods: ['GET'])]
    public function index(UserRepository $userRepository, RolesRepository $rolesRepository): Response
    {
        return $this->render('teachers/index.html.twig', []);
    }

    #[Route('/detail-list', name: 'teacher_list_details', methods: ['GET'])]
    public function detaillist(MaestrosRepository $maestrosRepository): Response
    {
        $datas = $maestrosRepository->findAll();
        return $this->render('teachers/detaillist.html.twig', [
            'datas' => $datas,
        ]);
    }

    #[Route('/add', name: 'teachers_detail_new', methods: ['GET', 'POST'])]
    public function add(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher, MaestrosRepository $maestrosRepository): Response
    {
        $maestros = new Maestros();
        $form = $this->createForm(WorkshopType::class, $maestros, [
            "edit" => false,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $maestros->setDeleted(false);
            $entityManager->persist($maestros);
            $entityManager->flush();

            return $this->redirectToRoute('teacher_list_details', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('teachers/new.html.twig', [
            'maestros' => $maestros,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'teachers_detail_show', methods: ['GET'])]
    public function show(Maestros $maestros): Response
    {
        return $this->render('teachers/show.html.twig', [
            'maestros' => $maestros,
        ]);
    }

    #[Route('/{id}/edit', name: 'teachers_detail_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Maestros $maestros, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher, RolesRepository $rolesRepository, UserRolesRepository $userRolesRepository): Response
    {
        $form = $this->createForm(WorkshopType::class, $maestros, [
            "edit" => true,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($maestros);
            $entityManager->flush();

            return $this->redirectToRoute('teacher_list_details', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('teachers/edit.html.twig', [
            'maestros' => $maestros,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'teachers_detail_delete', methods: ['POST'])]
    public function delete(Request $request, Maestros $maestros, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$maestros->getId(), $request->request->get('_token')) || $this->isCsrfTokenValid('delete-workshop', $request->request->get('_token'))) {
            $maestros->setDeleted(true);
            $maestros->setDeletedAt(new \DateTime());
            $entityManager->persist($maestros);
            $entityManager->flush();
        }

        return $this->redirectToRoute('teacher_list_details', [], Response::HTTP_SEE_OTHER);
    }

}
