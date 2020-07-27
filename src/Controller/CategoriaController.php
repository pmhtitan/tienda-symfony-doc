<?php

namespace App\Controller;

use App\Entity\Categoria;
use App\Form\CrearCategoriaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class CategoriaController extends AbstractController
{
    /**
     * @Route("/categoria", name="categoria")
     */
    public function index()
    {
        return $this->render('categoria/index.html.twig', [
            'controller_name' => 'CategoriaController',
        ]);
    }

    public function crearCategoria(Request $request){
        
        $categoria = new Categoria();

        $form = $this->createForm(CrearCategoriaType::class, $categoria);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $date = new \DateTime('now');
            $categoria->setCreatedAt($date);
            $categoria->setUpdatedAt($date);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categoria);
            $entityManager->flush();

            $this->addFlash(
                'notice', 'Se ha creado la categoria'
            );

            return $this->redirect($this->generateUrl('crearCategoria'));
        }

      return $this->render('categoria/crearCategoria.html.twig', [
         'formCategoria' => $form->createView(),
        ]);
    }
}
