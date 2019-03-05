<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/** 
 *  @Route("", name="user_") 
*/
class UserController extends AbstractController
{
    /**
     * @Route("/signin", name="new", methods={"GET", "POST"})
     */
    public function new()
    {
        return $this->render('user/signin.html.twig', [
            'page_title' => 'Inscription',
        ]);
    }

    /**
     * @Route("/account", name="show", methods={"GET"})
     */
    public function show()
    {
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
