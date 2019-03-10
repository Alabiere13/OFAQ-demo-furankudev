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
     * @Route("/{id}/editValidation", name="editValidation", methods={"PATCH"}, requirements={"id"="\d+"})
     */
    public function editValidation(Answer $answer, EntityManagerInterface $entityManager)
    {
        if($answer->getIsValid()) {
            $answer->setIsValid(false);

            $this->addFlash(
                'info',
                'La réponse de ' . $answer->getUser()->getUsername() . ' est dévalidée !'
            );
        } else {
            $answer->setIsValid(true);

            $this->addFlash(
                'info',
                'La réponse de ' . $answer->getUser()->getUsername() . 'a été validée !'
            );
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

        $this->addFlash(
                'info',
                'Le statut de la réponse de ' . $answer->getUser()->getUsername() . 'a été mis à jour !'
            );

        $entityManager->flush();
        
        return $this->redirectToRoute('question_show', ['id' => $answer->getQuestion()->getId()]);
    }
}
