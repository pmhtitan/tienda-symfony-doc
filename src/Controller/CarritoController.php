<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Producto;
use App\Entity\User;
use App\Entity\DatosFacturacion;
use App\Entity\Pedido;
use App\Entity\LineasPedidos;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Form\DatosFacturacionSesionType;

class CarritoController extends AbstractController
{

    public function __construct(SessionInterface $session)
    {
    
       /*  if(session_status() == PHP_SESSION_NONE) {
            session_start();
        } */
        
        $this->session = $session;
    
    }

        /*

            >--Guide Sessions--<        https://symfony.com/doc/current/session.html

            // stores an attribute in the session for later reuse
            $this->session->set('attribute-name', 'attribute-value');

            // gets an attribute by name
            $foo = $this->session->get('foo');

            // the second argument is the value returned when the attribute doesn't exist
            $filters = $this->session->get('filters', []); 

            >--  \   --<
        */


    /**
     * @Route("/carrito", name="carrito")
     */
    public function index()
    {

        $user = new User();

        $carritoSesion = $this->session->get('carrito');

        $shippingPrice = "6.75";

        $stats = $user->statsCarrito($carritoSesion, $shippingPrice);
        $stats['shippingPrice'] = number_format($shippingPrice, 2, ',', ' ');
        $stats['subtotal'] = number_format($stats['subtotal'], 2, ',', ' ');
        $stats['total'] = number_format($stats['total'], 2, ',', ' ');          

        if($carritoSesion && count($carritoSesion) >= 1){
            $carrito = $carritoSesion;
        }else{
            $carrito = array();
        }

        /* if(isset($_SESSION['carrito']) && count($_SESSION['carrito']) >= 1){
            $carrito = $_SESSION['carrito'];
        }else{
            $carrito = array();
        } */

        return $this->render('carrito/carrito2.html.twig', [
            'carrito' => $carrito,
            'stats' => $stats,
        ]);
    }

    public function checkout_session(Request $request){

        $carrito = $this->session->get('carrito');

        $user = new User();
        $carritoSesion = $this->session->get('carrito');
        $shippingPrice = "6.75";
        $stats = $user->statsCarrito($carritoSesion, $shippingPrice);
        
        
        $defaultData = ['message' => 'Type your message here'];
        $form = $this->createForm(DatosFacturacionSesionType::class, $defaultData);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $datos = $form->getData();
            $date = new \DateTime('now');
            $entityManager = $this->getDoctrine()->getManager();

            $user->setName($datos['nombre']);
            $user->setCreatedAt($date);
            $user->setUpdatedAt($date);
            $user->setSessionUser(TRUE);
            $entityManager->persist($user);
            $entityManager->flush();
            
            // add database DatosFacturacion
            $datosFacturacion = new DatosFacturacion();          

            $datosFacturacion->setUsuario($user);
            $datosFacturacion->setNombre($datos['nombre']);
            $datosFacturacion->setEmail($datos['email']);
            $datosFacturacion->setTelefono($datos['telefono']);
            $datosFacturacion->setProvincia($datos['provincia']);
            $datosFacturacion->setLocalidad($datos['localidad']);
            $datosFacturacion->setDireccion($datos['direccion']);
            $datosFacturacion->setCodigoPostal($datos['codigo_postal']);

            
            $entityManager->persist($datosFacturacion);
            $entityManager->flush();

            //  Seteamos el email en sesion para asi poder mostrar los datos de facturacion en otras pestañas,
            //      buscando por email en DatosFacturacion.
            $this->session->set('email', $datos['email']);

            // -> Aquí le llevariamos a la plataforma de pago (payment gateway), y tras confirmar pago y/o tarjeta, redirigimos a mostrar la compra efectuada.

            //  Guardamos el pedido completo, y las lineas de pedido correspondientes a los productos asociados a la compra

                //  Pedido
                $pedido = new Pedido();
                $coste = $stats['total'];
                $pedido->setUsuario($user);
                $pedido->setCoste($coste);
                $pedido->setEstado("pendiente");                
                $pedido->setCreatedAt($date);
                $pedido->setUpdatedAt($date);
                $entityManager->persist($pedido);
                $entityManager->flush();

                //  necesito recoger el id del ultimo pedido efectuado (este), para las lineas de pedido.
                //  +Problema => si queremos realmente que cuando un usuario se cree una cuenta nueva, y se le asignen pedidos pasados, tendríamos que rediseñar la tabla de pedidos, y en vez de apuntar a usuario_id, que apunte a datosFacturacion, y separar la logica de por cuenta y sesion?

                $idPedido = $pedido->getId();
                
                $objetoPedido = $entityManager->getRepository(Pedido::class)->find($idPedido);

                //  Lineas Pedidos
                foreach($carrito as $producto){
                    $objetoProducto = $entityManager->getRepository(Producto::class)->find($producto['id_producto']);
                    $lineaPedido = new LineasPedidos();
                    $lineaPedido->setPedido($objetoPedido);
                    $lineaPedido->setProducto($objetoProducto);
                    $lineaPedido->setUnidades($producto['unidades']);
                    $lineaPedido->setCreatedAt($date);
                    $lineaPedido->setUpdatedAt($date);                    
                    $entityManager->persist($lineaPedido);
                    $entityManager->flush();
                }

                $carritoVacio = array();

                $this->session->set('carrito', $carritoVacio);
                
                return $this->render('pedido/datosCompra.html.twig',[
                    'carrito' => $carrito,
                    'stats' => $stats,
                ]);            
            
        }

        $stats['shippingPrice'] = number_format($shippingPrice, 2, ',', ' ');
        $stats['subtotal'] = number_format($stats['subtotal'], 2, ',', ' ');
        $stats['total'] = number_format($stats['total'], 2, ',', ' ');
        

        return $this->render('datos_facturacion/checkoutFacturacion.html.twig', [
            'carrito' => $carrito,
            'stats' => $stats,
            'formDatosFactu_sesion' => $form->createView(),
        ]);

    }

    public function checkout(){

        $carrito = $this->session->get('carrito');
        $user = new User();
        $shoppingPrice = "6.75";
        $stats = $user->statsCarrito($carrito, $shoppingPrice);


    }

    /**
     * @Route("/status", name="status")
     */    
    public function status(){

        $carrito = $this->session->get('carrito');

       echo "<pre>";
       print_r($carrito);
       echo "</pre>";
       die();
    }

    
   public function guardar_quantity_session(Request $request){

    if (!$request->isXmlHttpRequest()) {
        return new JsonResponse(array(
            'status' => 'Error',
            'message' => 'Ha ocurrido un error al almacenar las unidades del shopping cart'),
        400);
    }
        $quantity = $request->request->get('quantity'); 
       
        $this->session->set('quantity',$quantity);
    
    return new JsonResponse( array(
        'status' => 'Fine',
        'message' => 'Todo correcto'),    
    );
   }

    public function addItem($id){

        
        (int) $quantity = $this->session->get('quantity');  

        $carrito = $this->session->get('carrito');

        if($carrito){
            $counter = 0;
            foreach($carrito as $indice => $elemento){
                if($elemento['id_producto'] == $id){
                    for($i = 1; $i <= $quantity; $i++){
                        $carrito[$indice]['unidades']++;
                    }                    
                    $counter++;
                }
            }
        }

        /* if(isset($_SESSION['carrito'])){
            $counter = 0;
            foreach($_SESSION['carrito'] as $indice => $elemento){
                if($elemento['id_producto'] == $id){
                    $_SESSION['carrito'][$indice]['unidades']++;
                    $counter++;
                }
            }
        } */

        if(!isset($counter) || $counter == 0){

             //  Conseguir producto
             $entityManager = $this->getDoctrine()->getManager();
             $productoSeleccionado = $entityManager->getRepository(Producto::class)->find($id);

             $carrito = $this->session->get('carrito');
             if(empty($quantity)){
                 $quantity = 1;
             }
             if($productoSeleccionado){
                $carrito[] =array(
                    "id_producto" => $productoSeleccionado->getId(),
                    "precio" => $productoSeleccionado->getPrecio(),
                    "unidades" => $quantity,
                    "producto" => $productoSeleccionado
                );
             }
        }

        $this->session->set('carrito', $carrito);

        return $this->redirectToRoute('carrito_index');
    }

    public function removeItem($index){ 
           
        $carrito = $this->session->get('carrito');

            //   Remover producto de la sesión carrito
            unset($carrito[$index]);

        $this->session->set('carrito', $carrito);

        return $this->redirectToRoute('carrito_index');
    }

    public function upItem($index){

        $carrito = $this->session->get('carrito');

          $carrito[$index]['unidades']++;

        $this->session->set('carrito', $carrito);

        return $this->redirectToRoute('carrito_index');
    }

    public function downItem($index){

        $carrito = $this->session->get('carrito');

            if($carrito[$index]['unidades'] == 1){
                unset($carrito[$index]);
            }else{
                $carrito[$index]['unidades']--;
            }
        
        $this->session->set('carrito', $carrito);
       
        return $this->redirectToRoute('carrito_index');
    }


    public function delete_all(){

        $carrito = array();

        $this->session->set('carrito', $carrito);
        
        return $this->redirectToRoute('carrito_index');
    }
       
    
}
