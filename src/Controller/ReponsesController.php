<?php

namespace App\Controller;

use App\Entity\Reponses;
use App\Entity\Questions;
use App\Form\ReponsesType;
use App\Repository\ReponsesRepository;
use App\Repository\QuestionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reponses')]
class ReponsesController extends AbstractController
{
    #[Route('/{id}', name: 'reponses_index', methods: ['GET'])]
    public function index( Questions $question): Response
    {
        return $this->render('reponses/index.html.twig', [
            'reponses'=> $question->getReponses(),
            'question' =>  $question
        ]);
    }

    #[Route('/new/{id}', name: 'reponses_new', methods: ['GET', 'POST'])]
    public function new(Request $request, Questions $question): Response
    {
        $reponse = new Reponses();
        $form = $this->createForm(ReponsesType::class, $reponse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reponse->setQuestionId($question);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reponse);
            $entityManager->flush();
         
            return $this->redirectToRoute('reponses_index', ['id'=>$question->getId()]);
        }

        return $this->render('reponses/new.html.twig', [
            'reponse' => $reponse,
            'question' =>  $question,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'reponses_show', methods: ['GET'])]
    public function show(Reponses $reponse): Response
    {
        return $this->render('reponses/show.html.twig', [
            'reponse' => $reponse,
        ]);
    }

    #[Route('/{id}/edit', name: 'reponses_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reponses $reponse, Questions $question): Response
    {
        $form = $this->createForm(ReponsesType::class, $reponse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reponse->setQuestionId($question);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reponses_index', ['id' => $question->getId()]);
        }

        return $this->render('reponses/edit.html.twig', [
            'reponse' => $reponse,
            'question' => $question,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'reponses_delete', methods: ['POST'])]
    public function delete(Request $request, Reponses $reponse): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reponse->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reponse);
            $entityManager->flush();
        }

        return $this->redirectToRoute('reponses_index');
    }
}
