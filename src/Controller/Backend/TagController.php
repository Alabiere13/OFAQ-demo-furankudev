<?php

namespace App\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TagController extends AbstractController
{
    /**
     * @Route("/backend/tag", name="backend_tag")
     */
    public function index()
    {
        return $this->render('backend/tag/index.html.twig', [
            'controller_name' => 'TagController',
        ]);
    }
}
