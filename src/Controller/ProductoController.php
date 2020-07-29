<?php

namespace App\Controller;

use App\Entity\Producto;
use App\Form\CrearProductoType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ProductoController extends AbstractController
{

    public function index()
    {

        //  Cargamos 9 productos(max) en cards en la home de productos.

        $productos_repo = $this->getDoctrine()->getRepository(Producto::class)->findBy([], ['id' => 'DESC'],9);

        return $this->render('producto/index.html.twig', [
           'productos' => $productos_repo,
        ]);
    }

    public function crearProducto(Request $request, SluggerInterface $slugger){

        //  Rellenamos el objeto producto con los datos que pasamos por el form
        $producto = new Producto();
        $form = $this->createForm(CrearProductoType::class, $producto);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            //  File Upload management **

             /** @var UploadedFile $imagenFile */
             $imagenFile = $form->get('imagen')->getData();

             // this condition is needed because the 'brochure' field is not required
             // so the PDF file must be processed only when a file is uploaded
             if ($imagenFile) {
                 $originalFilename = pathinfo($imagenFile->getClientOriginalName(), PATHINFO_FILENAME);
                 // this is needed to safely include the file name as part of the URL
                 $safeFilename = $slugger->slug($originalFilename);
                 $newFilename = $safeFilename.'-'.uniqid().'.'.$imagenFile->guessExtension();
 
                 // Move the file to the directory where brochures are stored
                 try {
                     $imagenFile->move(
                         $this->getParameter('imagenesProd_directory'),
                         $newFilename
                     );
                 } catch (FileException $e) {
                     // ... handle exception if something happens during file upload
                 }
 
                 // updates the 'imagenFilename' property to store the IMAGE file name
                 // instead of its contents
                 $producto->setImagen($newFilename);
            }

            $date = new \Datetime('now');
            $producto->setCreatedAt($date);
            $producto->setUpdatedAt($date);

            $entityManager =  $this->getDoctrine()->getManager();
            $entityManager->persist($producto);
            $entityManager->flush();

            $this->addFlash(
                'notice', 'Se ha creado el producto'
            );

            return $this->redirect($this->generateUrl('crearProducto'));                
        }
        

        return $this->render('producto/crearProducto.html.twig', [
            'formProducto' => $form->createView(),
        ]);
    }

    public function mostrarProductos(){

        $producto_repo = $this->getDoctrine()->getRepository(Producto::class)->findAll();

        return $this->render('producto/mostrarProductos.html.twig', [
            'productos' => $producto_repo
        ]);
    }

    public function mostrarProducto($id){

        //  2 Productos random por DQL SYMFONY, 2 times
            // Con SQL de toda la vida
            $connection = $this->getDoctrine()->getConnection();
            $sql1 = "SELECT * FROM producto ORDER BY RAND() LIMIT 2";
            $sql2 = "SELECT * FROM producto ORDER BY RAND() LIMIT 2";
            $stmt1 = $connection->prepare($sql1);
            $stmt2 = $connection->prepare($sql2);
            $stmt1->execute();
            $stmt2->execute();
            $querySQL1 = $stmt1->fetchAll();
            $querySQL2 = $stmt2->fetchAll();
          

        $producto_repo = $this->getDoctrine()->getRepository(Producto::class)->find($id);

        if(!$producto_repo){
            $message = "El producto no existe o no se encuentra disponible.";
        }else{
            $message = null;
        }

        return $this->render('producto/mostrarProducto.html.twig', [
            'message' => $message,
            'producto' => $producto_repo,
            'paqueteRandom1' => $querySQL1,
            'paqueteRandom2' => $querySQL2,
        ]);
    }
}