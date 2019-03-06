<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Entity\Question;
use App\Repository\TagRepository;
use App\Repository\QuestionRepository;
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
    public function index(QuestionRepository $questionRepo, TagRepository $tagRepo)
    {
        $questions = $questionRepo->findAllActiveOrderedByMostRecentlyAdded();
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
    public function indexByTag(Tag $tag)
    {
        return $this->render('question/index_by_tag.html.twig', [
            'page_title' => 'Catégorie - ' . $tag->getName(),
        ]);
    }

    /**
     * @Route("/question/new", name="new", methods={"GET", "POST"})
     */
    public function new()
    {
        return $this->render('question/new.html.twig', [
            'page_title' => 'Ajouter une nouvelle question',
        ]);
    }

    /**
     * @Route("/question/{id}", name="show", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function show(Question $question)
    {
        return $this->render('question/show.html.twig', [
            'page_title' => 'Question - ' . $question->getTitle(),
        ]);
    }

    /**
     * @Route("/question/{id}/edit", name="editStatus", methods={"PUT"}, requirements={"id"="\d+"})
     */
    public function editStatus(Question $question)
    {
        return RedirectToRoute('question_index');
    }
}
