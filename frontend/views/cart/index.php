<?php
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\models\Producto;
?>

<div id="cart">
    <input type="hidden" id="publicKey" value="<?= $publicKey ?>">
    <input type="hidden" name="standard_price" value="115.37">
    <input type="hidden" id="check-descuento" value="0">
    <div class="wrapper">
        <h2 class="titulo-coleccion">
            SHOPPING BAG
        </h2>
        <div id="opciones-carrito">
            <?= Html::a(
                '1. <span>SHOPPING </span>BAG',
                null,
                ['href' => 'javascript:;', 'data-bloque' => 'shopping-cart', 'class' => 'seleccionado','id' => 'opcion-bag']
            ) ?>
            <?= Html::a(
                '2. ADDRESS',
                null,
                ['href' => 'javascript:;', 'data-bloque' => 'address','id' => 'opcion-address']
            ) ?>
            <?= Html::a(
                '3. PAYMENT',
                null,
                ['href' => 'javascript:;', 'data-bloque' => 'payment', 'id' => 'opcion-payment']
            ) ?>
            <?= Html::a(
                '4. CONFIRMATION<span> DETAILS</span>',
                null,
                ['href' => 'javascript:;', 'data-bloque' => 'confirmation', 'id' => 'opcion-confirmation']
            ) ?>
        </div>
        <div id="shopping-cart" class="bloque-carrito">
            <div id="productos-carrito">
                <div class="cantidad-productos">
                    You have <span id="cantidad-bolsa"><?= count($productos) ?></span> item<?= count($productos) != 1 ? 's' : '' ?>
                    in you Shoping Bag
                </div>
                <?php $producto_foto = new producto(); ?>
                <?php $subtotal = 0; ?>
                <?php foreach($productos as $producto){ ?>
                    <?php $foto = $producto_foto->fotoUnica($producto->producto); ?>
                    <div class="producto" id="producto-<?= $producto->producto_carrito ?>">
                        <div class="imagen-producto">
                            <?php //echo Html::img('@web/images/'.$foto->foto); ?>
                            <a href="<?= Url::to(['producto/view-carro', 'id' => $producto->producto]) ?>" class="popup-with-zoom-anim-ajax" style="background-image:url('<?=  Yii::$app->request->BaseUrl.'/images/'.$foto->foto ?>')"></a>
                        </div>
                        <div class="datos-producto">
                            <div class="nombre-producto"><?= $producto->nombre ?></div>
                            <div class="color">
                                <span>Color: </span><?= $producto->color ?>
                            </div>
                            <div class="talla">
                                <span>Talla: </span><?= $producto->talla ?>
                            </div>
                            <div class="cantidad">
                                <div class="cantidades">
                                    <span>Quantity</span>
                                    <div class="control-cantidad">
                                        <div class="control">
                                            <a href="javascript:;" id="mas-<?= $producto->producto_carrito ?>" class="mas">
                                                +
                                            </a>
                                        </div>
                                        <div id="cantidad-<?= $producto->producto_carrito ?>">
                                            <?= $producto->cantidad ?>
                                        </div>
                                        <div class="control">
                                            <a href="javascript:;" id="menos-<?= $producto->producto_carrito ?>" class="menos">
                                                -
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="eliminar">
                                    <a href="javascript:;" id="eliminar-<?= $producto->producto_carrito ?>">
                                        Remove
                                    </a>
                                </div>
                                <div class="clear"></div>
                            </div>
                            <div id="costo-<?= $producto->producto_carrito ?>" class="costo">
                                $<span><?= number_format($producto->cantidad*$producto->precio, 2) ?></span>
                            </div>
                            <div class="campos-producto">
                                <input type="hidden" class="id" name="id" id="<?= $producto->producto_carrito ?>" value="<?= $producto->producto ?>" />
                                <input type="hidden" class="id-carrito" name="id" id="<?= $producto->producto_carrito ?>" value="<?= $producto->producto_carrito ?>" />
                                <input type="hidden" class="precio" name="precio" id="precio-<?= $producto->producto_carrito ?>" value="<?= $producto->precio ?>" />
                                <input type="hidden" class="cantidad" name="cantidad" id="cantidad-<?= $producto->producto_carrito ?>" value="<?= $producto->cantidad ?>" />
                                <input type="hidden" class="talla" name="talla" id="talla-<?= $producto->producto_carrito ?>" value="<?= $producto->talla ?>" />
                                <input type="hidden" class="color" name="color" id="color-<?= $producto->producto_carrito ?>" value="<?= $producto->color ?>" />
                            </div>


                            <?php $subtotal += ($producto->cantidad*$producto->precio) ?>
                        </div>
                        <div class="clear"></div>
                    </div>
                <?php } ?>

                <div id="envio-carrito">
                    <div class="clear"></div>
                    <span>Shipping Method</span>
                    <div id="envios">
                        <div class="tipo-envio">
                            <div class="desc-envio">
                                <input type="radio" id="standard" name="envio" value="standard" checked>
                                <label for="standard">Standard</label>
                                <!-- <span>Lorem ipsum dolor sit amet, consectetu</span> -->
                            </div>
                            <div class="costo-envio">
                                <span>$115.37</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="envio-carrito">
                    <div class="clear"></div>
                    <span>Payment Method</span>
                    <div id="envios">
                        <div class="tipo-envio">
                            <div class="desc-envio">
                                <input type="radio" id="credit" name="pago" value="credit" checked>
                                <label for="credit">Credit Card</label>
                                <span>VISA, MasterCard</span>
                            </div>
                            <div class="costo-envio">
                                <span>Free</span>
                            </div>
                        </div>
                        <div class="tipo-envio">
                            <div class="desc-envio">
                                <input type="radio" id="paypal" name="pago" value="paypal">
                                <label for="paypal">Paypal</label>
                                <span>Paypal</span>
                            </div>
                            <div class="costo-envio">
                                <span>Free</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <div id="terms-carrito-bag">
                    <details id="terms-bloque-bag">
                        <summary>Summary of the main terms and conditions of sale <br>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                             Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
                             dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.<br>
                             <span id="more-bag"><u><b>Ver mas</b></u></span>
                        </summary>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    </details>
                </div> -->

            </div>


            <div class="totales-carrito">
                <div class="campo-totales">
                    <div class="nombre-campo">Subtotal</div>
                    <div class="valor-campo" id="subtotal-compra">
                        $<span><?= $subtotal ?></span>
                    </div>
                </div>
                <div class="campo-totales">
                    <div class="nombre-campo">
                        Shipping Method
                        <span id="shipping-method">Standard</span>
                    </div>
                    <div class="valor-campo">
                        $<span class="shipping-price-sp"></span>
                    </div>
                </div>
                <div class="campo-totales">
                    <div class="nombre-campo">
                        Payment Method
                        <span id="payment-method">Credit card</span>
                    </div>
                </div>
                <div class="campo-totales" id="total-pagar">
                    <div class="nombre-campo">
                        Total
                    </div>
                    <div class="valor-campo" id="total-compra">
                        $<span class="total-compra-sp"></span>
                    </div>
                </div>
                <div class="envio-gratis">
                    <span>Free shipping on orders over $350</span>
                </div>
                <a href="javascript:;" id="continuar-pago-bag" class="btn-taller">
                    Continue
                </a>
                <div class="error-carrito bag oculto"></div>
                <div class="contenedor-img">
                    <?= Html::img('@web/images/eco_green.png', ['class' => 'img-responsive eco-checkout']) ?>
                </div>
                <div class="spinner"></div>
                <div id="texto-payment">
                    Payment information is transfered according to the highest security standards.
                </div>
                <a href="<?= Url::to(['colection/view', 'id' => 1]) ?>" id="seguir-comprando" class="btn-taller">
                    Continue Shopping
                </a>
            </div>
            <div class="clear"></div>
        </div>
        <?=$this->render('_address', ['subtotal'=>$subtotal])?>
        <?=$this->render('_payment', ['subtotal'=>$subtotal])?>
        <?=$this->render('_confirmation', ['subtotal'=>$subtotal])?>
        <input type="hidden" name="subtotal" value="<?= $subtotal ?>">
    </div>
</div>
