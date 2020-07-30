<?php

namespace App\Controller;

use App\Entity\Categoria;
use App\Form\CrearCategoriaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\EditarCategoriaType;

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

    public function gestionCategorias(){

        $entityManager = $this->getDoctrine()->getManager();
        $categorias_repo = $entityManager->getRepository(Categoria::class)->findAll();

        return  $this->render('categoria/gestionCategorias.html.twig', [
            'categorias' => $categorias_repo,
        ]);
    }

    public function update(Request $request, $id){

        $entityManager = $this->getDoctrine()->getManager();
        $categoria_repo = $entityManager->getRepository(Categoria::class)->find($id);

        $form = $this->createForm(EditarCategoriaType::class, $categoria_repo);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){

            $entityManager->persist($categoria_repo);
            $entityManager->flush();

            $this->addFlash(
                'notice', 'Se ha actualizado la categoria'
            );

            return $this->redirectToRoute('gestionCategorias');
        }

        return $this->render('categoria/editarCategoria.html.twig', [
            'formCategoria' => $form->createView(),
        ]);
    }

    public function delete($id){

        $entityManager = $this->getDoctrine()->getManager();
        $categoria_repo = $entityManager->getRepository(Categoria::class)->find($id);

        $entityManager->remove($categoria_repo);
        $entityManager->flush();

        $this->addFlash(
            'notice', 'Se ha borrado la categoria'
        );

        return $this->redirectToRoute('gestionCategorias');
    }
}
