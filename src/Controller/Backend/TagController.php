<?php

namespace App\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/** 
 *  @Route("/backend/tag", name="backend_tag_") 
*/
class TagController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index()
    {
        return $this->render('backend/tag/index.html.twig', [
            'page_title' => 'Administration - Liste des catégories',
        ]);
    }
}
