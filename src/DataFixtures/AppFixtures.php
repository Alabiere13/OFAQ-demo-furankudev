<?php

namespace App\DataFixtures;

use \DateTime;
use Faker\Factory;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\Question;
use App\Entity\VoteForQuestion;

use Faker\ORM\Doctrine\Populator;
use App\DataFixtures\Faker\TagProvider;
use App\DataFixtures\Faker\UserProvider;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $generator = Factory::create('fr_FR');
        $generator->addProvider(new TagProvider($generator));
        $generator->addProvider(new UserProvider($generator));
        $generator->seed(1234);
        $populator = new Populator($generator, $manager);

        $userRole = new Role();
        $userRole->setName('Utilisateur');
        $userRole->setCode('ROLE_USER');
        $manager->persist($userRole);

        $adminRole = new Role();
        $adminRole->setName('Administrateur');
        $adminRole->setCode('ROLE_ADMIN');
        $manager->persist($adminRole);

        $moderatorRole = new Role();
        $moderatorRole->setName('Modérateur');
        $moderatorRole->setCode('ROLE_MODERATOR');
        $manager->persist($moderatorRole);

        $admin = new User();
        $admin->setUsername('vador');
        $admin->setDescription('Je suis ton père !');
        $admin->setEmail('admin@oclock.io');
        $admin->setImage('https://www.rapid-cadeau.com/15365-large_default/affiche-star-wars-dark-vador-your-empire-needs-you.jpg');
        $admin->setIsActive(true);
        $admin->setCreatedAt(new DateTime);
        $admin->setUpdatedAt(null);
        $admin->setRole($adminRole);
        $encodedPassword = $this->passwordEncoder->encodePassword($admin, $admin->getUsername());
        $admin->setPassword($encodedPassword);
        $manager->persist($admin);

        $moderator = new User();
        $moderator->setUsername('lechuck');
        $moderator->setDescription('Je suis ton frère !');
        $moderator->setEmail('modo@oclock.io');
        $moderator->setImage('https://upload.wikimedia.org/wikipedia/en/thumb/1/18/LeChuck.png/240px-LeChuck.png');
        $moderator->setIsActive(true);
        $moderator->setCreatedAt(new DateTime);
        $moderator->setUpdatedAt(null);
        $moderator->setRole($moderatorRole);
        $encodedPassword = $this->passwordEncoder->encodePassword($moderator, $moderator->getUsername());
        $moderator->setPassword($encodedPassword);
        $manager->persist($moderator);

        $user = new User();
        $user->setUsername('moldu');
        $user->setDescription('Pas la tête !');
        $user->setEmail('pelandron@oclock.io');
        $user->setImage('http://www.ffwtt.net/wiki/images/b/b8/Mog.jpg');
        $user->setIsActive(true);
        $user->setCreatedAt(new DateTime);
        $user->setUpdatedAt(null);
        $user->setRole($userRole);
        $encodedPassword = $this->passwordEncoder->encodePassword($user, $user->getUsername());
        $user->setPassword($encodedPassword);
        $manager->persist($user);

        $populator->addEntity('App\Entity\User', 25, array(
            'username' => function() use ($generator) { return $generator->unique()->randomSWUsername(); },
            'description' => function() use ($generator) { return $generator->realText($maxNbChars = 200); },
            'email' => function() use ($generator) { return $generator->unique()->email(); },
            'image' => function() use ($generator) { return $generator->imageUrl($width = 640, $height = 480); },
            'isActive' => true,
            'createdAt' => function() use ($generator) { return $generator->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = null) ; },
            'updatedAt' => null,
            'role' => $userRole,
          ), array(
            function($user) { 
                $user->fakerConstruct();
                $encodedPassword = $this->passwordEncoder->encodePassword($user, $user->getUsername());
                $user->setPassword($encodedPassword);
            },
        ));

        $populator->addEntity('App\Entity\Tag', 10, array(
            'name' => function() use ($generator) { return $generator->unique()->randomTag(); },
            'description' => function() use ($generator) { return $generator->realText($maxNbChars = 200); },
            'image' => function() use ($generator) { return $generator->imageUrl($width = 640, $height = 480); },
            'isActive' => true,
            'createdAt' => function() use ($generator) { return $generator->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = null) ; },
            'updatedAt' => null,
        ), array(
            function($tag) { 
                $tag->fakerConstruct();
            },
        ));

        $populator->addEntity('App\Entity\Question', 30, array(
            'title' => function() use ($generator) { return $generator->unique()->realText($maxNbChars = 50) . ' ?'; },
            'body' => function() use ($generator) { return $generator->realText($maxNbChars = 500); },
            'viewsCounter' => function() use ($generator) { return $generator->numberBetween($min = 0, $max = 20) ; },
            'isActive' => true,
            'createdAt' => function() use ($generator) { return $generator->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = null) ; },
            'updatedAt' => null,
        ), array(
            function($question) { 
                $question->fakerConstruct();
            },
        ));

        $populator->addEntity('App\Entity\Answer', 80, array(
            'title' => function() use ($generator) { return $generator->unique()->realText($maxNbChars = 50) . ' !'; },
            'body' => function() use ($generator) { return $generator->realText($maxNbChars = 300); },
            // 'isValid' => false,
            'isActive' => true,
            'createdAt' => function() use ($generator) { return $generator->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = null) ; },
            'updatedAt' => null,
        ));

        $populator->addEntity('App\Entity\VoteForQuestion', 30, array(
            'updatedAt' => null,
        ));

        $inserted = $populator->execute();

        $questions = $inserted['App\Entity\Question'];
        $tags = $inserted['App\Entity\Tag'];
        foreach ($questions as $question) {
            shuffle($tags);
            $question->addTag($tags[0]);
            $question->addTag($tags[1]);
            $manager->persist($question);
        }

        $manager->flush();
    }
}
