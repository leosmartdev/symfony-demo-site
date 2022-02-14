<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Security\PostVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\JsonResponse;


class UserPostController extends AbstractController
{
    #[Route('/admin', methods: ['GET', 'POST'], name: 'admin')]
    public function index(Connection $conn): Response
    {
        $queryBuilder = $conn->createQueryBuilder();
        $data = $queryBuilder->select('*')->from('usuarios_usu')->execute()->fetchAll();
        return $this->render('user_post/index.html.twig', ['posts' => $data]);

    }
    // #[Route('/user/post', name: 'user_post')]
    // public function index(UserRepository $posts): Response
    // {
    //     $authorPosts = $posts->findBy(['username' => $this->getUser()]);

    //     return $this->render('user_post/index.html.twig', ['users' => $authorPosts]);
    // }
}
