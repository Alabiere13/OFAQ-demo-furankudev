<?php

namespace App\Controller\Backend;

use App\Entity\Tag;
use App\Form\TagType;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
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

        if ($order == 'id' || $order == 'isActive' || $order == 'name') {
            $tags = $tagRepo->findAllOrderedByVariable('t.' . $order);
        } else {
            $tags = $tagRepo->findAllOrderedByMostRecentlyAdded();
        }
        
        return $this->render('backend/tag/index.html.twig', [
            'page_title' => 'Administration - Liste des catégories',
            'tags' => $tags
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function show(Tag $tag = null)
    {
        if (!$tag) {
            throw $this->createNotFoundException("La catégorie indiquée n'existe pas"); 
        }

        return $this->render('backend/tag/show.html.twig', [
            'page_title' => 'Profil - ' . $tag->getName(),
            'tag' => $tag
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager)
    {
        $tag = new Tag();
        $form = $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tag);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'La catégorie ' . $tag->getName() . ' a bien été ajoutée !'
            );

            return $this->redirectToRoute('backend_tag_index');
        }

        return $this->render('backend/tag/new.html.twig', [
            'page_title' => 'Inscription',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET", "POST"}, requirements={"id"="\d+"})
     */
    public function edit(Tag $tag = null, Request $request, EntityManagerInterface $entityManager)
    {
        if (!$tag) {
            throw $this->createNotFoundException("La catégorie indiquée n'existe pas"); 
        }

        $form = $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash(
                'info',
                'La catégorie ' . $tag->getName() . ' a bien été mise à jour !'
            );

            return $this->redirectToRoute('backend_tag_index');
        }

        return $this->render('backend/tag/edit.html.twig', [
            'page_title' => 'Inscription',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/editStatus", name="editStatus", methods={"PATCH"}, requirements={"id"="\d+"})
     */
    public function editStatus(Tag $tag = null, EntityManagerInterface $entityManager)
    {
        if (!$tag) {
            throw $this->createNotFoundException("La catégorie indiquée n'existe pas"); 
        }

        if($tag->getIsActive()) {
            $tag->setIsActive(false);
        } else {
            $tag->setIsActive(true);
        }

        $this->addFlash(
                'info',
                'Le statut de la  catégorie ' . $tag->getName() . ' est mis à jour !'
            );

        $entityManager->flush();
        
        return $this->redirectToRoute('backend_tag_index');
    }

        /**
     * @Route("/{id}/delete", name="delete", methods={"DELETE"}, requirements={"id"="\d+"})
     */
    public function delete(Tag $tag = null, EntityManagerInterface $entityManager)
    {
        if (!$tag) {
            throw $this->createNotFoundException("La catégorie indiquée n'existe pas"); 
        }

        $entityManager->remove($tag);
        $entityManager->flush();

        $this->addFlash(
            'danger',
            'La catégorie ' . $tag->getName() . ' a été supprimée !'
        );
        
        return $this->redirectToRoute('backend_tag_index');
    }
}
