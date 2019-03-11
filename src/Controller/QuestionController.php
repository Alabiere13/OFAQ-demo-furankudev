<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Entity\Answer;
use App\Entity\Question;
use App\Form\AnswerType;
use App\Form\QuestionType;
use App\Entity\VoteForQuestion;
use App\Repository\TagRepository;
use App\Repository\UserRepository;
use App\Repository\AnswerRepository;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\VoteForQuestionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/** 
 *  @Route("", name="question_") 
*/
class QuestionController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(Request $request, QuestionRepository $questionRepo, TagRepository $tagRepo, VoteForQuestionRepository $voteRepo)
    {
        $search = $request->query->get('search');
        $page = $request->query->get('page', 1);

        $isActive = $this->isGranted('ROLE_MODERATOR') ? [true, false] : [true];

        if ($search){
            if ($page != 1) {
                $questions = $questionRepo->findActiveOrderedByMostRecentlyAddedByTitle($search, ($page - 1) * 7 - 1);
            } else {
                $questions = $questionRepo->findActiveOrderedByMostRecentlyAddedByTitle($search);
                $page = 1;
            }
         } else {
            if ($page != 1) {
                $questions = $questionRepo->findActiveOrderedByMostRecentlyAdded($isActive, ($page - 1) * 7 );
            } else {
                $questions = $questionRepo->findActiveOrderedByMostRecentlyAdded($isActive);
                $page = 1;
            }
            
         }
        
        $tags = $tagRepo->findAll();
        
        return $this->render('question/index.html.twig', [
            'page_title' => 'Les questions des utilisateurs',
            'questions' => $questions,
            'tags' => $tags,
            'search' => $search,
            'page' => $page
        ]);
    }

    /**
     * @Route("/question/tag/{id}/index", name="indexByTag", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function indexByTag(Tag $tag = null, TagRepository $tagRepo)
    {
        if (!$tag) {
            throw $this->createNotFoundException("La catégorie indiquée n'existe pas"); 
        }

        $tags = $tagRepo->findAll();
        return $this->render('question/index_by_tag.html.twig', [
            'page_title' => 'Catégorie - ' . $tag->getName(),
            'current_tag' => $tag,
            'tags' => $tags
        ]);
    }

    /**
     * @Route("/question/new", name="new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, UserRepository $userRepo)
    {
        $question = new Question();
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $userRepo->find($this->getUser()->getId());
            $question->setUser($user);
            $entityManager->persist($question);
            $entityManager->flush();

            $this->addFlash(
                'success',
                $user->getUsername() . ', votre question a bien été ajoutée !'
            );

            return $this->redirectToRoute('question_show', ['id' => $question->getId()]);
        }

        return $this->render('question/new.html.twig', [
            'page_title' => 'Ajouter une nouvelle question',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/question/{id}", name="show", methods={"GET", "POST"}, requirements={"id"="\d+"})
     */
    public function show(Question $question = null, Request $request, EntityManagerInterface $entityManager, AnswerRepository $answerRepo, UserRepository $userRepo, VoteForQuestionRepository $voteRepo)
    {
        if (!$question) {
            throw $this->createNotFoundException("La question indiquée n'existe pas"); 
        }
        
        $voteValue = false;

        $votes = $voteRepo->findBy([
            'question' => $question,
            'value' => true
        ]);

        if ($this->getUser()) {
            $user = $userRepo->find($this->getUser()->getId());
            $currentVote = $voteRepo->findOneBy([
                'question' => $question,
                'user' => $user,
                'value' => true
            ]);
            if ($currentVote) {
                $voteValue = true;
            }
        }
        
        $question->setViewsCounter($question->getViewsCounter() + 1);
        $entityManager->flush();

        if($this->isGranted('ROLE_MODERATOR')){
            $answers = $answerRepo->findAllOrderedByValidationByQuestion($question);
        } else {
            $answers = $answerRepo->findActiveOrderedByValidationByQuestion($question);
        }
        

        $answer = new Answer();
        $form = $this->createForm(AnswerType::class, $answer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $answer->setUser($user);
            $answer->setQuestion($question);
            $entityManager->persist($answer);
            $entityManager->flush();

            $this->addFlash(
                'success',
                $user->getUsername() . ', votre réponse a bien été ajoutée !'
            );

            return $this->redirectToRoute('question_show', ['id' => $question->getId()]);
        }

        return $this->render('question/show.html.twig', [
            'page_title' => 'Question - ' . $question->getTitle(),
            'question' => $question,
            'answers' => $answers,
            'votes' => $votes,
            'vote_value' => $voteValue,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/question/{id}/editVote", name="editVote", methods={"PATCH"}, requirements={"id"="\d+"})
     */
    public function editVote(Question $question = null, EntityManagerInterface $entityManager, UserRepository $userRepo, VoteForQuestionRepository $voteRepo)
    {
        if (!$question) {
            throw $this->createNotFoundException("La question indiquée n'existe pas"); 
        }

        if ($this->getUser()) {
            $user = $userRepo->find($this->getUser()->getId());
            $vote = $voteRepo->findOneBy([
                'question' => $question,
                'user' => $user,
            ]);
            if ($vote) {
                $voteValue = $vote->getValue();
                $vote->setValue($voteValue?false:true);
            } else {
                $vote = new VoteForQuestion();
                $vote->setQuestion($question);
                $vote->setUser($user);
                $vote->setValue(true);
                $entityManager->persist($vote);
            }
        }

        $this->addFlash(
                'info',
                'Le vote a bien été enregistré !'
            );

        $entityManager->flush();
        
        return $this->redirectToRoute('question_show', ['id' => $question->getId()]);
    }

    /**
     * @Route("/question/{id}/editStatus", name="editStatus", methods={"PATCH"}, requirements={"id"="\d+"})
     */
    public function editStatus(Question $question = null, Request $request, EntityManagerInterface $entityManager)
    {
        if (!$question) {
            throw $this->createNotFoundException("La question indiquée n'existe pas"); 
        }

        if($question->getIsActive()) {
            $question->setIsActive(false);
        } else {
            $question->setIsActive(true);
        }

        $this->addFlash(
            'info',
            'La modification du statut de la question a bien été enregistrée !'
        );

        $entityManager->flush();

        $referer = $request->headers->get('referer');
        
        return $this->redirect($referer);
    }
}
