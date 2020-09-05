<?php

namespace App\Controller;

use App\Entity\Carrito;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Producto;
use App\Entity\User;
use App\Entity\DatosFacturacion;
use App\Entity\LineasCarrito;
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

        $logeado = $this->getUser();
        if($logeado){
            $entityManager = $this->getDoctrine()->getManager();
            $usuario_repo = $entityManager->getRepository(User::class)->find($logeado->getId());
            $cart = $usuario_repo->getCarrito();
            if($cart){
                $cartID = $cart->getId();
                $findAllLineas = $entityManager->getRepository(LineasCarrito::class)->findBy(['carrito' => $cartID]); //VALEN AMBAS. lineasCart o FindAllProducts
                // $lineasCart = $cart->getLineasCarritos(); Tambien vale. PERO. Lo tenemos más dificil para saber si está vacío.
            }else{
                $findAllLineas = null;
            }
            
           
            
            if(!empty($findAllLineas)){

                foreach($findAllLineas as $productObj){
                    $carritoSesion[] =array(
                        "id_producto" => $productObj->getId(),
                        "precio" => $productObj->getPrecio(),
                        "unidades" => $productObj->getUnidades(),
                        "producto" => $productObj->getProducto(),
                    );
                }
            }else{
                $carritoSesion = array();
            }
           
        }else{            
            $carritoSesion = $this->session->get('carrito');           
        }
        

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

        $logeado = $this->getUser();

        if($logeado){
            $entityManager = $this->getDoctrine()->getManager();
            $usuario_repo = $entityManager->getRepository(User::class)->find($logeado->getId());
            $cart = $usuario_repo->getCarrito();
            $cartID = $cart->getId();
            $findAllLineas = $entityManager->getRepository(LineasCarrito::class)->findBy(['carrito' => $cartID]); 
            
            if(!empty($findAllLineas)){

                foreach($findAllLineas as $productObj){
                    $carrito[] =array(
                        "id_producto" => $productObj->getProducto()->getId(),
                        "precio" => $productObj->getPrecio(),
                        "unidades" => $productObj->getUnidades(),
                        "producto" => $productObj->getProducto(),
                    );
                }
            }else{
                return $this->redirectToRoute('carrito_index');
            }
           
        }else{                      
            $carrito = $this->session->get('carrito');
        }

        $user = new User();
        $shippingPrice = "6.75";
        $stats = $user->statsCarrito($carrito, $shippingPrice);
        
        
        $defaultData = ['message' => 'Type your message here'];

        if($logeado){
            $usuario_id = $logeado->getId();
            $datosFacturacion_logeado = $this->getDoctrine()->getManager()->getRepository(DatosFacturacion::class)->findOneBy(['usuario' => $usuario_id]);

            //  Si son true, significa que hay datos de facturación existentes, por lo que no tenemos que crear nada
            if($datosFacturacion_logeado){
                $form = $this->createForm(DatosFacturacionSesionType::class, $datosFacturacion_logeado);
            }else{
                $datosFact = new DatosFacturacion();
                $form = $this->createForm(DatosFacturacionSesionType::class, $datosFact);
            }
        }else{
            $form = $this->createForm(DatosFacturacionSesionType::class, $defaultData);
        }
       

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();

            if($logeado){
                if($datosFacturacion_logeado){                
                    //  Update
                    $entityManager->persist($datosFacturacion_logeado); 
                }else{
                    //  Create 
                    $datosFact->setUsuario($logeado);
                    $entityManager->persist($datosFact);
                }           
                $entityManager->flush();
                
                 //  Pedido
                 $pedido = new Pedido();
                 $date = new \DateTime('now');
                 $coste = $stats['total'];
                 $pedido->setUsuario($logeado);
                 $pedido->setCoste($coste);
                 $pedido->setEstado("pendiente");                
                 $pedido->setCreatedAt($date);
                 $pedido->setUpdatedAt($date);
                 $entityManager->persist($pedido);
                 $entityManager->flush();

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

                 // Borrar carrito (borrar productos asociados al carrito y dejarlo vacío)

                    $lineasCarrito_repo = $entityManager->getRepository(LineasCarrito::class)->findBy(['carrito' => $cartID]);
                        foreach($lineasCarrito_repo as $linea){
                            $entityManager->remove($linea);
                        }                
                    $entityManager->flush();

                    //  Update - Subtotal del carrito a 0
                    $query = $entityManager->createQuery(
                        "UPDATE App\Entity\Carrito a SET a.subtotal = 0 WHERE a.id = '$cartID'"
                       );
                    $query->execute();

                 return $this->render('pedido/datosCompra.html.twig',[
                    'carrito' => $carrito,
                    'stats' => $stats,
                ]);

            }else{
            
            $datos = $form->getData();
            $date = new \DateTime('now');

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

    //  AJAX REQUEST que lleva la Quantity del item por POST
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

        $logeado = $this->getUser();

        (int) $quantity = $this->session->get('quantity'); // quantity de los items antes de llegar aqui

        if(empty($quantity)){
            $quantity = 1;
        }

        
        if($logeado){

            $entityManager = $this->getDoctrine()->getManager();

            $cart = $entityManager->getRepository(Carrito::class)->findOneBy(
                ['usuario' => $logeado->getId()], null, 1);
                
            if(!empty($cart)){

                // Comprobar si el producto seleccionado, está ya en el carrito.
                $carrito_id = $cart->getId();
                $linea_carrito_seleccionado = $entityManager->getRepository(LineasCarrito::class)->findOneBy(
                     ['carrito' => $carrito_id, 'producto' => $id]
                );

                $banderaQuery_Prod = false;

               if(empty($linea_carrito_seleccionado)){

                $productoSeleccionado = $entityManager->getRepository(Producto::class)->find($id);
                $linea_carrito = new LineasCarrito();
                $linea_carrito->setCarrito($cart);
                $linea_carrito->setProducto($productoSeleccionado);
                $linea_carrito->setPrecio($productoSeleccionado->getPrecio());
                $linea_carrito->setUnidades($quantity);
                $entityManager->persist($linea_carrito);            
                $entityManager->flush();
                $banderaQuery_Prod = true;
               }else{
                   //   El producto ya estaba en la caja, aumentar unidades
                   $query = $entityManager->createQuery(
                    "UPDATE App\Entity\LineasCarrito a SET a.unidades = a.unidades + '$quantity' WHERE a.producto = '$id' AND a.carrito = '$carrito_id'"
                   );
                   $query->execute();
               }
                // Aumentar el subtotal
                    if(!$banderaQuery_Prod){
                        $productoSeleccionado = $entityManager->getRepository(Producto::class)->find($id);
                    }
                
                    $precio_subtotal = $productoSeleccionado->getPrecio() * $quantity;

                    $query = $entityManager->createQuery(
                        "UPDATE App\Entity\Carrito a SET a.subtotal = a.subtotal + '$precio_subtotal' WHERE a.id = '$carrito_id'"
                    );
                    $query->execute();
              

            }else{        

            $productoSeleccionado = $entityManager->getRepository(Producto::class)->find($id);
            $subtotal = $productoSeleccionado->getPrecio() * $quantity;
            $date = new \DateTime('now');
            $cart = new Carrito();
            $cart->setUsuario($logeado);
            $cart->setSubtotal($subtotal);
            $cart->setCreatedAt($date);
            $cart->setUpdatedAt($date);
            $entityManager->persist($cart);
            $entityManager->flush();

           
            $linea_carrito = new LineasCarrito();
            $linea_carrito->setCarrito($cart);
            $linea_carrito->setProducto($productoSeleccionado);
            $linea_carrito->setPrecio($productoSeleccionado->getPrecio());
            $linea_carrito->setUnidades($quantity);
            $entityManager->persist($linea_carrito);            
            $entityManager->flush();

            }
            

        }else{      

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

        }

        return $this->redirectToRoute('carrito_index');
    }

    public function removeItem($index){ 
        //  En caso de carrito sesion, index = index,
        //  En caso de carrito cuenta, index = idProductoSeleccionado

        $logeado = $this->getUser();

        if($logeado){

            //  Quitar la lineaCarrito del producto seleccionado, cuyo carrito es el del usuario logeado
            $entityManager = $this->getDoctrine()->getManager();

            $cart = $entityManager->getRepository(Carrito::class)->findOneBy(
                ['usuario' => $logeado->getId()], null, 1);
            $carrito_id = $cart->getId();

            $productoSeleccionado = $entityManager->getRepository(Producto::class)->find($index);
            $producto_id = $productoSeleccionado->getId();
            $linea_carrito = $entityManager->getRepository(LineasCarrito::class)->findOneBy(['carrito' => $carrito_id, 'producto' => $producto_id]);
            $precio_producto = $productoSeleccionado->getPrecio();           
            $quantity = $linea_carrito->getUnidades();
            $precio_prod_por_unidades = $precio_producto * $quantity;

            $entityManager->remove($linea_carrito);
            $entityManager->flush();
            
            $query = $entityManager->createQuery(
                "UPDATE App\Entity\Carrito a SET a.subtotal = a.subtotal - $precio_prod_por_unidades WHERE a.id = '$carrito_id'"
               );
            $query->execute();

        }else{
           
            $carrito = $this->session->get('carrito');

                //   Remover producto de la sesión carrito
                unset($carrito[$index]);

            $this->session->set('carrito', $carrito);

        }

        return $this->redirectToRoute('carrito_index');
    }

    public function upItem($index){

        $logeado = $this->getUser();

        if($logeado){

            //  Subir una unidad en la linea del producto seleccionado
            $entityManager = $this->getDoctrine()->getManager();

            $cart = $entityManager->getRepository(Carrito::class)->findOneBy(
                ['usuario' => $logeado->getId()], null, 1);
            $carrito_id = $cart->getId();

            $productoSeleccionado = $entityManager->getRepository(Producto::class)->find($index);
            $precio_producto = $productoSeleccionado->getPrecio();

            //  aumentar unidades
            $query = $entityManager->createQuery(
                "UPDATE App\Entity\LineasCarrito a SET a.unidades = a.unidades + 1 WHERE a.producto = '$index' AND a.carrito = '$carrito_id'"
            );
            //  aumentar el subtotal del carrito
            $querySubtotal = $entityManager->createQuery(
                "UPDATE App\Entity\Carrito a SET a.subtotal = a.subtotal + $precio_producto WHERE a.id = '$carrito_id'"
               );
            $query->execute();
            $querySubtotal->execute();         

        }else{

            $carrito = $this->session->get('carrito');

                $carrito[$index]['unidades']++;

            $this->session->set('carrito', $carrito);
        }

        return $this->redirectToRoute('carrito_index');
        
    }

    public function downItem($index){

        $logeado = $this->getUser();

        if($logeado){

            //  Bajar una unidad en la linea del producto seleccionado
            $entityManager = $this->getDoctrine()->getManager();

            $cart = $entityManager->getRepository(Carrito::class)->findOneBy(
                ['usuario' => $logeado->getId()], null, 1);
            $carrito_id = $cart->getId();

            $productoSeleccionado = $entityManager->getRepository(Producto::class)->find($index);
            $precio_producto = $productoSeleccionado->getPrecio();
            
            //  bajar unidades
            $query = $entityManager->createQuery(
                "UPDATE App\Entity\LineasCarrito a SET a.unidades = a.unidades - 1 WHERE a.producto = '$index' AND a.carrito = '$carrito_id'"
            );
            //  bajar el subtotal del carrito
            $querySubtotal = $entityManager->createQuery(
                "UPDATE App\Entity\Carrito a SET a.subtotal = a.subtotal - $precio_producto WHERE a.id = '$carrito_id'"
               );
            $query->execute();
            $querySubtotal->execute();           

        }else{

            $carrito = $this->session->get('carrito');

                if($carrito[$index]['unidades'] == 1){
                    unset($carrito[$index]);
                }else{
                    $carrito[$index]['unidades']--;
                }
            
            $this->session->set('carrito', $carrito);
        }
       
        return $this->redirectToRoute('carrito_index');
    }


    public function delete_all(){

        $carrito = array();

        $this->session->set('carrito', $carrito);
        
        return $this->redirectToRoute('carrito_index');
    }
       
    
}
