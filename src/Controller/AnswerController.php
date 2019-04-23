<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\VoteForAnswer;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\VoteForAnswerRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/** 
 *  @Route("/answer", name="answer_") 
*/
class AnswerController extends AbstractController
{
    /**
     * @Route("/{id}/editValidation", name="editValidation", methods={"PATCH"}, requirements={"id"="\d+"})
     */
    public function editValidation(Answer $answer = null, EntityManagerInterface $entityManager)
    {
        if (!$answer) {
            throw $this->createNotFoundException("La réponse indiquée n'existe pas"); 
        }

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
     * @Route("/{id}/toggleVote", name="toggleVote", methods={"PATCH"}, requirements={"id"="\d+"})
     */
    public function editVote(Answer $answer = null, Request $request, EntityManagerInterface $entityManager, UserRepository $userRepo, VoteForAnswerRepository $voteForAnswerRepo)
    {
        if (!$answer) {
            throw $this->createNotFoundException("La réponse indiquée n'existe pas"); 
        }

        if ($this->getUser()) {
            $user = $userRepo->find($this->getUser()->getId());
            $vote = $voteForAnswerRepo->findOneBy([
                'answer' => $answer,
                'user' => $user,
            ]);
            if ($vote) {
                $entityManager->remove($vote);

                $this->addFlash(
                    'danger',
                    'Votre vote a bien été retiré !'
                );

            } else {
                $vote = new VoteForAnswer();
                $vote->setAnswer($answer);
                $vote->setUser($user);
                $entityManager->persist($vote);

                $this->addFlash(
                    'success',
                    'Votre vote a bien été ajouté !'
                );
            }
        }

        $entityManager->flush();
        
        $referer = $request->headers->get('referer');
        
        return $this->redirect($referer);
    }

    /**
     * @Route("/{id}/editStatus", name="editStatus", methods={"PATCH"}, requirements={"id"="\d+"})
     */
    public function editStatus(Answer $answer = null, EntityManagerInterface $entityManager)
    {
        if (!$answer) {
            throw $this->createNotFoundException("La réponse indiquée n'existe pas"); 
        }

        if($answer->getIsActive()) {
            $answer->setIsActive(false);
        } else {
            $answer->setIsActive(true);
        }

        $this->addFlash(
                'info',
                'Le statut de la réponse de ' . $answer->getUser()->getUsername() . ' a été mis à jour !'
            );

        $entityManager->flush();
        
        return $this->redirectToRoute('question_show', ['id' => $answer->getQuestion()->getId()]);
    }
}
