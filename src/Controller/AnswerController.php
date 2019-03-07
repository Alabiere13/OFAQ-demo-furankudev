<?php

namespace App\Controller;

use App\Entity\Answer;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;

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
        return $this->redirectToRoute('question_index');
    }

    /**
     * @Route("/{id}/validate", name="editValidation", methods={"PATCH"}, requirements={"id"="\d+"})
     */
    public function editValidation(Answer $answer, EntityManagerInterface $entityManager)
    {
        if($answer->getIsValid()) {
            $answer->setIsValid(false);
        } else {
            $answer->setIsValid(true);
        }

        $entityManager->flush();
        
        return $this->redirectToRoute('question_show', ['id' => $answer->getQuestion()->getId()]);
    }
}
