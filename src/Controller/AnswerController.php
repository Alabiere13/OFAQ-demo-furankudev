<?php

namespace App\Controller;

use App\Entity\Answer;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/** 
 *  @Route("/answer", name="answer_") 
*/
class AnswerController extends AbstractController
{
    /**
     * @Route("/new", name="new", methods={"GET", "POST"})
     */
    public function new()
    {
        return $this->render('answer/new.html.twig', [
            'page_title' => 'Ajouter une nouvelle question',
        ]);
    }

    /**
     * @Route("/{id}/edit", name="editStatus", methods={"PUT"}, requirements={"id"="\d+"})
     */
    public function editStatus(Answer $answer)
    {
        return RedirectToRoute('question_index');
    }
}
