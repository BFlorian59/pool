<?php

namespace App\Controller;

use App\Entity\Questions;
use App\Entity\Resultats;
use App\Entity\Reponses;
use App\Form\ReponsesType;
use App\Form\QuestionsType;
use App\Repository\QuestionsRepository;
use App\Repository\ReponsesRepository;
use App\Repository\ResultatsRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/questions')]
class QuestionsController extends AbstractController
{
    #[Route('/', name: 'questions_index', methods: ['GET'])]
    public function index(QuestionsRepository $questionsRepository, ): Response
    {
        return $this->render('questions/index.html.twig', [
            'questions' => $questionsRepository->findall(),
        ]);
    }

    #[Route('/new', name: 'questions_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $question = new Questions();
        $form = $this->createForm(QuestionsType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $question->setUser($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($question);
            $entityManager->flush();

            return $this->redirectToRoute('questions_index');
        }

        return $this->render('questions/new.html.twig', [
            'question' => $question,
            'form' => $form->createView(),
        ]);
    }

  


    #[Route('/show/{id}', name: 'questions_resultat', methods: ['GET', 'POST'])]
    public function resultat(Request $request, Questions $question, ReponsesRepository $reponses, ResultatsRepository $resultats): Response
    {

        if ($resultats->haveAlreadyAnswered($question->getId(), $request->getClientIp())) {
            $this->addFlash('error', 'vous avez déjà répondu à ce sondage');
            return $this->redirectToRoute('questions_index', ['id' => $questions->getId()]);

        }
        else if($request->getMethod() === 'POST'){
            $results = $request->request->get('resultat');
            $entityManager = $this->getDoctrine()->getManager();
            foreach($results as $result){
                $resultat = new Resultats();
                $resultat->setUserId($this->getUser());
                $resultat->setIp($request->getClientIp());
                $resultat->setReponseId($reponses->find($result));
                $entityManager->persist($resultat);
                $entityManager->flush();
            }
            $this->addFlash('success', 'Réponses ajouté avec succès');
            return $this->redirectToRoute('questions_index');
        }
    }

    #[Route('/results/{id}', name: 'questions_results', methods: ['GET'])]
    public function results( Questions $question, ReponsesRepository $reponsesRepository, ResultatsRepository $resultatsRepository): Response
    {
        $reponses = $reponsesRepository->findBy(['question_id' => $question->getId()]);
        $resultats = [];
        $resultsTotal = 0;

        foreach ($reponses as $key) {
            $resultats[$key->getId()] = count($resultatsRepository->findBy(['reponse_id' => $key->getId()]));
        }

        foreach($resultats as $keyy){
            $resultsTotal += $keyy;
        }
        
        
        return $this->render('questions/results.html.twig', [
            'question' => $question,
            'reponses' => $reponses,
            'resultats' => $resultats,
            'resultsTotal' => $resultsTotal
        ]);
    }


    #[Route('/{id}', name: 'questions_show', methods: ['GET'])]
    public function show(Questions $question): Response
    {
        return $this->render('questions/show.html.twig', [
            'question' => $question,
            
        ]);
    }

    #[Route('/{id}/edit', name: 'questions_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Questions $question): Response
    {
        $form = $this->createForm(QuestionsType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('questions_index');
        }

        return $this->render('questions/edit.html.twig', [
            'question' => $question,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'questions_delete', methods: ['POST'])]
    public function delete(Request $request, Questions $question): Response
    {
        if ($this->isCsrfTokenValid('delete'.$question->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($question);
            $entityManager->flush();
        }

        return $this->redirectToRoute('questions_index');
    }
}
