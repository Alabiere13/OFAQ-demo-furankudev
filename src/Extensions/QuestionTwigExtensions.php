<?php
 
namespace App\Extensions;

use App\Entity\Question;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\EntityManagerInterface;

class QuestionTwigExtensions extends \Twig_Extension
{    
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('findQuestionAndVotes', array($this, 'findQuestionAndVotes')),
        );
    }
    
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findQuestionAndVotes($id){
        $questionRepo = $this->entityManager->getRepository(Question::class);
        return $questionRepo->findByVoteForQuestionAndByVoteIsTrue($id);
    }
    
    public function getName()
    {
        return 'Twig Extensions';
    }
}