<?php

namespace App\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/** 
 *  @Route("/backend/user", name="backend_user_") 
*/
class UserController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index()
    {
        return $this->render('backend/user/index.html.twig', [
            'page_title' => 'Administration - Liste des utilisateurs',
        ]);
    }
}
