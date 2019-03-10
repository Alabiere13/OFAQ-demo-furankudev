<?php

namespace App\Controller\Backend;

use App\Repository\UserRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/** 
 *  @Route("/backend/user", name="backend_user_") 
*/
class UserController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(UserRepository $userRepo)
    {
        $users = $userRepo->findAll();

        return $this->render('backend/user/index.html.twig', [
            'page_title' => 'Administration - Liste des utilisateurs',
            'users' => $users
        ]);
    }
}
