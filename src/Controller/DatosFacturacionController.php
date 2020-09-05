<?php

namespace App\Controller;

use App\Entity\DatosFacturacion;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Form\DatosFacturacionType;

class DatosFacturacionController extends AbstractController
{

    public function index()
    {

    }
    public function gestionDatos(Request $request, UserInterface $userInterface){

       $usuario_id = $this->getUser()->getId();
        
        $entityManager = $this->getDoctrine()->getManager();
        $datos_facturacion = $entityManager->getRepository(DatosFacturacion::class)->findOneBy(['usuario' => $usuario_id]);

        if(!$datos_facturacion){
            $datos_facturacion = new DatosFacturacion(); 
            $datos_facturacion->setEmail($this->getUser()->getEmail());        
        }

        //  Manejamos el form, creando aparte src/Form/DatosFacturacionType.php
        $form = $this->createForm(DatosFacturacionType::class, $datos_facturacion);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $datos_facturacion->setUsuario($this->getUser());

            $entityManager->persist($datos_facturacion);
            $entityManager->flush();

            $this->addFlash(
                'notice', 'Se han actualizado los datos de facturacion'
            );
            
            return $this->redirect($this->generateUrl('datosFacturacion'));
        }

       return $this->render('datos_facturacion/index.html.twig', [
            'formDatosFactu' => $form->createView(),
        ]);
    }
}
