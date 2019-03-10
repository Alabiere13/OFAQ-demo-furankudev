<?php

namespace App\Controller\Backend;

use App\Entity\Tag;
use App\Repository\TagRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/** 
 *  @Route("/backend/tag", name="backend_tag_") 
*/
class TagController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(Request $request, TagRepository $tagRepo)
    {
        $order = $request->query->get('order');

        if ($order != 'id' || $order != 'isActive') {
            $order = 'name';
        }

        $tags = $tagRepo->findAllOrderedByVariable('t.' . $order);

        return $this->render('backend/tag/index.html.twig', [
            'page_title' => 'Administration - Liste des catégories',
            'tags' => $tags
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Tag $tag)
    {
        return $this->render('backend/tag/show.html.twig', [
            'page_title' => 'Profil - ' . $tag->getName(),
            'tag' => $tag
        ]);
    }
}
