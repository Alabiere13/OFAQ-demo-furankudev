<?php

namespace App\EventSubscriber;

use App\Entity\Question;
use Twig\Environment as Twig;
use App\Controller\QuestionController;
use App\Repository\QuestionRepository;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class TopQuestionSubscriber implements EventSubscriberInterface
{
    private $twig;
    private $questionRepository;

    public function __construct(Twig $twig, QuestionRepository $questionRepo)
    {
        $this->twig = $twig;
        $this->questionRepository = $questionRepo;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
  
        $controllerAndMethod = $event->getController();
        
        if (!is_array($controllerAndMethod)) {
            return;
        }
        
        $controllerName = $controllerAndMethod[0];
        $methodName = $controllerAndMethod[1];
        
        if ($controllerName instanceof QuestionController) {
            
            $question = $this->questionRepository->findTopQuestion();
            
            $this->twig->addGlobal('top_question', $question);
        }
    }

    /*
     liste des evenements : https://symfony.com/doc/current/reference/events.html
    */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::CONTROLLER => 'onKernelController',
        );
    }
}