<?php

namespace App\Controller;

use App\Entity\Tag;
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
    public function index()
    {
        return $this->render('question/index.html.twig', [
            'page_title' => 'Les questions des utilisateurs',
        ]);
    }

    /**
     * @Route("/question/tag/{id}", name="indexByTag", methods={"GET"})
     */
    public function indexByTag(Tag $tag)
    {
        return $this->render('question/index.html.twig', [
            'page_title' => 'Catégorie - ' . $tag->getName(),
        ]);
    }

    /**
     * @Route("/question/new", name="new", methods={"GET", "POST"})
     */
    public function new()
    {
        return $this->render('question/index.html.twig', [
            'page_title' => 'Ajouter une nouvelle question',
        ]);
    }

    /**
     * @Route("/question/{id}", name="show", methods={"GET"})
     */
    public function show(Question $question)
    {
        return $this->render('question/index.html.twig', [
            'page_title' => 'Question - ' . $question->getTitle(),
        ]);
    }

    /**
     * @Route("/question/{id}", name="editStatus", methods={"PUT"})
     */
    public function editStatus(Question $question)
    {
        return $this->render('question/index.html.twig', [
            'page_title' => 'Question - ' . $question->getTitle(),
        ]);
    }
}
