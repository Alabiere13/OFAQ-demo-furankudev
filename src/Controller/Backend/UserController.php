<?php

namespace App\Controller\Backend;

use App\Entity\User;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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
    public function index(Request $request, UserRepository $userRepo, RoleRepository $roleRepo)
    {
        $adminRole = $roleRepo->findOneByName('Administrateur');
        $moderatorRole = $roleRepo->findOneByName('Modérateur');
        $userRole = $roleRepo->findOneByName('Utilisateur');

        $role = $request->query->get('role', false);

        if ($role) {
            $orderRole = $roleRepo->findOneByName($role);
            $users = $userRepo->findAllOrderedByUsernameByRole($orderRole);
        } else {
            $users = $userRepo->findAllOrderedByUsername();
        }
        
        return $this->render('backend/user/index.html.twig', [
            'page_title' => 'Administration - Liste des utilisateurs',
            'users' => $users
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function show(User $user)
    {
        return $this->render('backend/user/show.html.twig', [
            'page_title' => 'Profil - ' . $user->getUsername(),
            'user' => $user
        ]);
    }

    /**
     * @Route("/{id}/editRole", name="editRole", methods={"PATCH"}, requirements={"id"="\d+"})
     */
    public function editRole(User $user, RoleRepository $roleRepo, EntityManagerInterface $entityManager)
    {
        $moderatorRole = $roleRepo->findOneByName('Modérateur');
        $userRole = $roleRepo->findOneByName('Utilisateur');

        if ($user->getRole() == $userRole) {
            $user->setRole($moderatorRole);
        } elseif ($user->getRole()  == $moderatorRole) {
            $user->setRole($userRole);
        } 

        $entityManager->flush();

        $this->addFlash(
            'info',
            'Les droits de ' . $user->getUsername() . ' ont été mis à jour !'
        );
        
        return $this->redirectToRoute('backend_user_index');
    }
}
