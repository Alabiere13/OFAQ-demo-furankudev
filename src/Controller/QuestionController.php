<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Entity\Answer;
use App\Entity\Question;
use App\Form\AnswerType;
use App\Form\QuestionType;
use App\Repository\TagRepository;
use App\Repository\UserRepository;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\VoteForQuestionRepository;

/** 
 *  @Route("", name="question_") 
*/
class QuestionController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(QuestionRepository $questionRepo, TagRepository $tagRepo)
    {
        $questions = $questionRepo->findActiveOrderedByMostRecentlyAdded();
        $tags = $tagRepo->findAll();
        return $this->render('question/index.html.twig', [
            'page_title' => 'Les questions des utilisateurs',
            'questions' => $questions,
            'tags' => $tags
        ]);
    }

    /**
     * @Route("/question/tag/{id}/index", name="indexByTag", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function indexByTag(Tag $tag, TagRepository $tagRepo)
    {
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
    public function show(Question $question, Request $request, EntityManagerInterface $entityManager, UserRepository $userRepo, VoteForQuestionRepository $voteRepo)
    {
        $voteValue = false;

        if ($this->getUser()) {
            $user = $userRepo->find($this->getUser()->getId());
            $vote = $voteRepo->findOneBy([
                'question' => $question,
                'user' => $user,
            ]);
            if ($vote) {
                $voteValue = $vote->getValue();
            }
        }
        
        $question->setViewsCounter($question->getViewsCounter() + 1);
        $entityManager->flush();

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
            'vote_value' => $voteValue,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/question/{id}/editVote", name="editVote", methods={"PATCH"}, requirements={"id"="\d+"})
     */
    public function editVote(Question $question)
    {
        return $this->redirectToRoute('question_index');
    }

    /**
     * @Route("/question/{id}/editStatus", name="editStatus", methods={"PATCH"}, requirements={"id"="\d+"})
     */
    public function editStatus(Question $question)
    {
        return $this->redirectToRoute('question_index');
    }
}
