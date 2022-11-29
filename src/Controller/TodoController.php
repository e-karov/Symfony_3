<?php

namespace App\Controller;

use App\Entity\Todo;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getRepository(Todo::class);
        $todos = $em->findAll();
        return $this->render('todo/index.html.twig', [
            'todos'=>$todos
        ]);
    }

    #[Route('/create', name:'create')]
    public function createPage(): Response
    {
        return $this->render('todo/create.html.twig');
    }


    #[Route('/details/{id}', name:'details')]
    public function detailsPage($id): Response
    {
        return $this->render('todo/details.html.twig', ['id'=> $id]);
    }

    #[Route('/edit/{id}', name:'edit')]
    public function editPage($id): Response
    {
        return $this->render('todo/edit.html.twig', ['id'=> $id]);
    }
}
