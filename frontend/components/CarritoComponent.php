<?php

namespace app\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Cookie;
use yii\db\Query;

use frontend\models\Carrito;
use frontend\models\ProductoCarrito;
use frontend\models\Color;
use frontend\models\Talla;
use frontend\models\Cliente;
use frontend\models\Pedido;
use frontend\models\ProductoPedido;
use frontend\models\DatosPago;
use frontend\models\Newsletter;

use \Conekta\Conekta;

class CarritoComponent extends Component
{

    private $transaction;

    private function cookieId(){
        $cookie_id = Yii::$app->getRequest()->getCookies()->getValue('taller_de_la_rosa_id');
        if(!$cookie_id){
            $cookie_id = uniqid(rand(10,99));
            $cookie = new Cookie([
                'name' => 'taller_de_la_rosa_id',
                'value' => $cookie_id,
                'expire' => time() + 86400 * 365,
            ]);
            Yii::$app->getResponse()->getCookies()->add($cookie);
        }
        return $cookie_id;
    }

    public function botonCarrito(){
        $cookie_id = $this->cookieId();
        $cantidad = Carrito::find()
        ->select(['COUNT(producto_carrito.cantidad) AS cantidad'])
        ->join('INNER JOIN', 'producto_carrito', 'producto_carrito.carrito_id = carrito.id')
        ->where('carrito.cookie_id = "'.$cookie_id.'"')
        ->one();
        $cantidad_carrito = $cantidad->cantidad > 0 ? $cantidad->cantidad : '';
        return Html::a(
            Html::img('@web/images/bolsa.png').'<span>'.$cantidad_carrito.'</span>',
            ['cart/'],
            ['id' => 'bolsa']
        );
    }

    public function agregar($producto_id, $talla_id, $color_id, $cantidad){
        $cookie_id = $this->cookieId();
        $carrito = new Carrito();
        $carrito = $carrito->idCarrito($cookie_id);
        if(!$carrito){
            return [
                'exito' => 0,
                'mensaje' => 'Error al agregar producto a bolsa.'
            ];
        }

        $producto = ProductoCarrito::find()
        ->where(
            'carrito_id='.$carrito.
            ' AND producto_id='.$producto_id.
            ' AND talla_id='.$talla_id.
            ' AND color_id='.$color_id
            )
            ->one();
            if($producto){
                $producto->cantidad += $cantidad;
                if(!$producto->save()){
                    return [
                        'exito' => 0,
                        'mensaje' => 'Error al actualizar producto en bolsa.'
                    ];
                }
            }else{
                $producto = new ProductoCarrito();
                $producto->carrito_id = $carrito;
                $producto->producto_id = $producto_id;
                $producto->talla_id = $talla_id;
                $producto->color_id = $color_id;
                $producto->cantidad = $cantidad;
                if(!$producto->save()){
                    return [
                        'exito' => 0,
                        'mensaje' => 'Error al agregar producto a bolsa.'
                    ];
                }
            }
            return [
                'exito' => 1,
                'mensaje' => 'El producto se agregó a la bolsa.'
            ];
        }

        public function obtieneProductos(){
            $cookie_id = $this->cookieId();
            $productos = ProductoCarrito::find()
            ->select([
                'producto_carrito.id AS producto_carrito',
                'producto.id AS producto', 'producto.nombre AS nombre', 'talla.talla AS talla',
                'color.color AS color', 'producto_carrito.cantidad AS cantidad', 'precio.precio AS precio'
            ])
            ->from('carrito')
            ->join('INNER JOIN', 'producto_carrito', 'producto_carrito.carrito_id = carrito.id')
            ->join('INNER JOIN', 'producto', 'producto.id = producto_carrito.producto_id')
            ->join('INNER JOIN', 'precio', 'precio.id = producto.precio_id')
            ->join('INNER JOIN', 'talla', 'talla.id = producto_carrito.talla_id')
            ->join('INNER JOIN', 'color', 'color.id = producto_carrito.color_id')
            ->where('carrito.cookie_id = "'.$cookie_id.'"')
            ->all();
            return $productos;
        }

        public function actualizar($params)
        {
            if(empty($params)){
                return [
                    'exito' => 0,
                    'mensaje' => 'Error actualizando el carrito'
                ];
            }

            $connection = \Yii::$app->db;
            $this->transaction = $connection->beginTransaction();

            $cookie_id = $this->cookieId();

            $carrito = Carrito::find()
            ->where('cookie_id="'.$cookie_id.'"')
            ->one();

            $productos_carro = ProductoCarrito::find()->where('carrito_id='.$carrito->id)->all();
            foreach ($productos_carro as $producto_carro) {
                if(! $producto_carro->delete()){
                    $this->transaction->rollback();
                    return [
                        'exito' => 0,
                        'mensaje' => 'Error actualizando el carrito'
                    ];
                }
            }

            foreach ($params as $value) {
                $producto = new ProductoCarrito();
                $producto->carrito_id = $carrito->id;
                $producto->producto_id = $value['id'];
                $talla = Talla::find()
                ->where('talla="'.$value['talla'].'"')
                ->one();
                $producto->talla_id = $talla->id;
                $color = Color::find()
                ->where('color="'.$value['color'].'"')
                ->one();
                $producto->color_id = $color->id;
                $producto->cantidad = $value['cantidad'];
                if(!$producto->save()){
                    $this->transaction->rollback();
                    return [
                        'exito' => 0,
                        'mensaje' => 'Error actualizando el carrito'
                    ];
                }
            }
            $this->transaction->commit();
            return [
                'exito' => 1,
                'mensaje' => 'El carrito se ha actualizado.'
            ];
        }

        public function finalizar($params){
            if(empty($params)){
                return [
                    'exito' => 0,
                    'mensaje' => 'Error finalizando compra, parametros'
                ];
            }

            $connection = \Yii::$app->db;
            $this->transaction = $connection->beginTransaction();
            
            $correo_newsletter = Newsletter::find()->where(['email' => $params[0]['correo_envio']])->count();
            $correo_clientes = Cliente::find()->where(['correo' => $params[0]['correo_envio']])->count();
            
            if( $correo_newsletter > 0 && $correo_clientes < 1){
                $descuento = true;
            }

            $cliente = new Cliente();
            $cliente->nombre = $params[0]['nombre_envio'];
            $cliente->apellidos = $params[0]['apellidos_envio'];
            $cliente->correo = $params[0]['correo_envio'];
            $cliente->telefono = $params[0]['telefono_envio'];
            $cliente->calle = $params[0]['calle_envio'];
            $cliente->colonia = $params[0]['colonia_envio'];
            $cliente->cp = $params[0]['cp_envio'];
            $cliente->estado = $params[0]['estado_envio'];
            $cliente->municipio = $params[0]['municipio_envio'];
            $cliente->num_ext = $params[0]['numero_exterior_envio'];
            $cliente->num_int = $params[0]['numero_interior_envio'];
            $tipo_envio = $params[0]['tipo_envio'];
            switch($tipo_envio){
                case 'standard':
                $precio_envio = 115.37;
                break;
            }
            if(! $cliente->save()){
                $this->transaction->rollback();
                return [
                    'exito' => 0,
                    'mensaje' => 'Error finalizando compra, cliente'
                ];
            }

            $pedido = new Pedido();
            $pedido->cliente_id = $cliente->id;
            $validaGuardaPedido = $pedido->save();

            if(!$validaGuardaPedido){
                $this->transaction->rollback();
                return [
                    'exito' => 0,
                    'mensaje' => 'Error finalizando compra, pedido'
                ];
            }

            $cookie_id = $this->cookieId();

            $carrito = Carrito::find()
            ->where('cookie_id="'.$cookie_id.'"')
            ->one();

            $productosCarrito = ProductoCarrito::find()
            ->select(['producto_carrito.*', 'producto.nombre AS nombre' ,'precio.precio AS precio'])
            ->from('producto_carrito')
            ->join('INNER JOIN', 'producto', 'producto.id = producto_carrito.producto_id')
            ->join('INNER JOIN', 'precio', 'precio.id = producto.precio_id')
            ->where('producto_carrito.carrito_id='.$carrito->id)
            ->all();

            $items = array();

            $total = 0;
            
            foreach ($productosCarrito as $productoCarrito) {
                
                $productop = new ProductoPedido();
                $productop->pedido_id = $pedido->id;
                $productop->producto_id = $productoCarrito->producto_id;
                $productop->talla_id = $productoCarrito->talla_id;
                $productop->color_id = $productoCarrito->color_id;
                $productop->cantidad = $productoCarrito->cantidad;
                $productop->total = $productoCarrito->cantidad * $productoCarrito->precio;
                $total += $productop->total;
                $validaGuardaProductoP = $productop->save();

                $item = array();
                $item['name'] = $productoCarrito->nombre;
                if ($descuento) {
                    $item['unit_price'] = intval($productoCarrito->precio*0.9)*100; 
                } else {
                    $item['unit_price'] = intval($productoCarrito->precio)*100; 
                }
                $item['quantity'] = $productoCarrito->cantidad;
                $items[]=$item;

                if(!$validaGuardaProductoP){
                    $this->transaction->rollback();
                    return [
                        'exito' => 0,
                        'mensaje' => 'Error finalizando compra, productos pedido',
                    ];
                }
            }
            if ($descuento){
                $valor_descuento = ($total*0.1)*100;
            }
            
            $ini = parse_ini_file("private.ini");
            \Conekta\Conekta::setApiKey($ini['privateKey']);
            \Conekta\Conekta::setApiVersion("2.0.0");

            try{
                $order = \Conekta\Order::create(
                    array(
                    'currency' => 'MXN',
                    'customer_info' => array(
                        'name'=> $cliente->nombre.' '.$cliente->apellidos,
                        'email'=> $cliente->correo,
                        'phone' => '+521'.$cliente->telefono
                    ),
                    'line_items' => $items,
                    'charges' => array(
                        array(
                            'payment_method' => array(
                                'type' => 'card',
                                "token_id" => $params[2]['id']
                            )
                        )
                    ),
//                    'discount_line' => array(
//                        array(
//                            'amount' => $valor_descuento,
//                        )
//                    ),
                    'shipping_lines' => array(
                        array(
                            'amount' => $precio_envio * 100,
                            'carrier' => 'FEDEX'
                        )
                    ),
                    'shipping_contact' => array(
                        'receiver' =>  $cliente->nombre.' '.$cliente->apellidos,
                        'address' => array(
                            'street1' => $cliente->calle,
                            'city' => $cliente->municipio,
                            'state' => $cliente->estado,
                            'country' => 'MX',
                            'postal_code' => $cliente->cp
                        )
                    )
                ));
            } catch (\Conekta\ProcessingError $error){
                return [
                    'exito' => 0,
                    'mensaje' => '1: '.$error->getMessage(),
                ];
            } catch (\Conekta\ParameterValidationError $error){
                return [
                    'exito' => 0,
                    'mensaje' => '2: '.$error->getMessage(),
                ];
            } catch (\Conekta\Handler $error){
                return [
                    'exito' => 0,
                    'mensaje' => '3: '.$error->getMessage(),
                ];
            }

            $datosPago = new DatosPago();
            $datosPago->orden_id = $order->id;
            $datosPago->monto = $order->amount/100;
            $datosPago->codigo_auth = $order->charges[0]->payment_method->auth_code;
            $datosPago->numeros_tarjeta = $order->charges[0]->payment_method->last4;
            $datosPago->marca = $order->charges[0]->payment_method->brand;
            $datosPago->tipo = $order->charges[0]->payment_method->type;
            $datosPago->descuento = $valor_descuento/100;

            $validaDatosPago = $datosPago->save();
            if(!$validaDatosPago){
                $this->transaction->rollback();
                return [
                    'exito' => 0,
                    'mensaje' => 'Error finalizando compra, datos del pago'
                ];
            }

            $pedido->datos_pago_id = $datosPago->id;
            $validaGuardaPedido = $pedido->save();

            if(!$validaGuardaPedido){
                $this->transaction->rollback();
                return [
                    'exito' => 0,
                    'mensaje' => 'Error actualizando el carrito, pedido'
                ];
            }

            $productos_carro_borrar = ProductoCarrito::find()->where('carrito_id='.$carrito->id)->all();
            foreach ($productos_carro_borrar as $producto_carro) {
                if(! $producto_carro->delete()){
                    $this->transaction->rollback();
                    return [
                        'exito' => 0,
                        'mensaje' => 'Error actualizando el carrito'
                    ];
                }
            }
            
            $this->transaction->commit();

            return [
                'exito' => 1,
                'mensaje' => 'La compra ha finalizado de foma exitosa',
                'pedido' => $pedido->id
            ];

        }
    }
