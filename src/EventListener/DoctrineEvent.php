<?php

namespace App\EventListener;

use DateTime;
use App\Entity\Tag;
use App\Entity\User;
use App\Entity\Answer;
use App\Utils\Slugger;
use App\Entity\Question;
use Doctrine\ORM\Events;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class DoctrineEvent implements EventSubscriber
{
    private $slugger;
    
    public function __construct(Slugger $slugger)
    {
        $this->slugger = $slugger;
    }

    public function getSubscribedEvents()
    {
        return array(
            Events::preUpdate,
            Events::prePersist,
        );
    }

    public function preUpdate(LifecycleEventArgs $args) 
    {
        $this->questionSluggify($args);
        $this->setUpdatedAt($args);
    }

    public function prePersist(LifecycleEventArgs $args) 
    {
        $this->questionSluggify($args);
    }

    public function questionSluggify(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        $entityManager = $args->getObjectManager();

        if (!$entity instanceof Question) {
            return;
        }
        
        $entity->setSlug($this->slugger->sluggify($entity->getTitle()));
    }

    public function setUpdatedAt(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        $entityManager = $args->getObjectManager();

        if ($entity instanceof Question || $entity instanceof Tag || $entity instanceof Answer || $entity instanceof User) {
            $entity->setUpdatedAt(new DateTime);
        }
        
    }

}