<?php

namespace App\Controller;

use App\Entity\Todo;
use App\Form\TodoType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Regex;

class TodoController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $todos= $doctrine->getRepository(Todo::class)->findAll();

        return $this->render('todo/index.html.twig', [
            'todos'=>$todos
        ]);
    }

    #[Route('/create', name:'create')]
    public function createPage(Request $request, ManagerRegistry $doctrine): Response
    {
        $todo = new Todo();
        $todo->setCreateDate(new \DateTime('now'));

        $form = $this->createForm(TodoType::class, $todo);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $todo = $form->getData();

            $em = $doctrine->getManager();
            $em->persist($todo);
            $em->flush();

            return $this->redirectToRoute('home');
        }

        return $this->renderForm('todo/create.html.twig', [
            'form' => $form,
        ]);
    }


    #[Route('/details/{id}', name:'details')]
    public function detailsPage($id, ManagerRegistry $doctrine): Response
    {
        $todo = $doctrine->getRepository(Todo::class)->find($id);

        return $this->render('todo/details.html.twig', ['todo'=> $todo]);
    }

    #[Route('/edit/{id}', name:'edit')]
    public function editPage($id, ManagerRegistry $doctrine, Request $request): Response
    {
        $todo = $doctrine->getRepository(Todo::class)->find($id);

        $form = $this->createForm(TodoType::class, $todo);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $todo = $form->getData();

            $em = $doctrine->getManager();
            $em->persist($todo);
            $em->flush();

            return $this->redirectToRoute('home');
        }

        return $this->renderForm('todo/edit.html.twig', ['form'=> $form]);
    }

    #[Route('/delete/{id}', name:'delete')]
    public function delete($id, ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $todo = $doctrine->getRepository(Todo::class)->find($id);
        $em->remove($todo);
        $em->flush();

        return $this->redirectToRoute('home');
    }
}
