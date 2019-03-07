<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\RoleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/** 
 *  @Route("", name="user_") 
*/
class UserController extends AbstractController
{
    /**
     * @Route("/signin", name="new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder, RoleRepository $roleRepo)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $encodedPassword = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encodedPassword);
            $user->setRole($roleRepo->findOneBy(['name' => 'Utilisateur']));
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('user/signin.html.twig', [
            'page_title' => 'Inscription',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/account", name="show", methods={"GET"})
     */
    public function show()
    {
        dump($this->getUser());
        return $this->render('user/account.html.twig', [
            'page_title' => 'Profil',
        ]);
    }

    /**
     * @Route("/account/edit", name="edit", methods={"GET", "POST"})
     */
    public function edit()
    {
        return $this->render('user/edit.html.twig', [
            'page_title' => 'Mettre à jour le profil',
        ]);
    }
}
