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
     * @Route("/{id}/editValidation", name="editValidation", methods={"PATCH"}, requirements={"id"="\d+"})
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

    /**
     * @Route("/{id}/editStatus", name="editStatus", methods={"PATCH"}, requirements={"id"="\d+"})
     */
    public function editStatus(Answer $answer, EntityManagerInterface $entityManager)
    {
        if($answer->getIsActive()) {
            $answer->setIsActive(false);
        } else {
            $answer->setIsActive(true);
        }

        $entityManager->flush();
        
        return $this->redirectToRoute('question_show', ['id' => $answer->getQuestion()->getId()]);
    }
}
