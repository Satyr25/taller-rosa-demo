<?php
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\models\Producto;
?>

<div class="address oculto">

    <div id="direcciones-carrito">
        <div id="dir-envio-carrito">
            <div class="clear"></div>
            <span>Shipping Address</span>
            <div id="bloque-envio">
                <form id="form-envio">
                    <input id="nombre_envio" class="campos-direccion" type="text" name="" value="" placeholder="First Name*">
                    <input id="apellido_envio" class="campos-direccion" type="text" name="" value="" placeholder="Last Name*">
                    <input id="email_envio" class="campos-direccion" type="email" name="" value="" placeholder="E-mail*">
                    <input id="telefono_envio" class="campos-direccion" type="tel" name="" value="" placeholder="Phone*" maxlength="10">
                    <input id="calle_envio" class="campos-direccion" type="text" name="" value="" placeholder="Street*">
                    <input id="ext_envio" class="campos-direccion" type="text" name="" value="" placeholder="Exterior Number*">
                    <input id="int_envio" class="campos-direccion" type="text" name="" value="" placeholder="Interior Number">
                    <input id="colonia_envio" class="campos-direccion" type="text" name="" value="" placeholder="Colony*">
                    <input id="municipio_envio" class="campos-direccion" type="text" name="" value="" placeholder="Region*">
                    <input id="estado_envio" class="campos-direccion" type="text" name="" value="" placeholder="State*">
                    <input id="cp_envio" class="campos-direccion" type="text" name="" value="" placeholder="Zip Code*">
                    <input class="campos-direccion" type="checkbox" id="same-info" for="same-info" checked>
                    <label class="cart-same-info" for="same-info">
                        Billing details are the same as the shipping details.
                    </label>
                </form>
            </div>
        </div>

        <div id="dir-fac-carrito" class="oculto">
            <div class="clear"></div>
            <span>Billing Address</span>
            <div id="bloque-facturacion">
                <form id="form-facturacion">
                    <input id="nombre_fact" class="campos-direccion" type="text" name="" value="" placeholder="First Name*">
                    <input id="apellido_fact" class="campos-direccion" type="text" name="" value="" placeholder="Last Name*">
                    <input id="calle_fact" class="campos-direccion" type="text" name="" value="" placeholder="Street*">
                    <input id="ext_fact" class="campos-direccion" type="text" name="" value="" placeholder="Exterior Number*">
                    <input id="int_fact" class="campos-direccion" type="text" name="" value="" placeholder="Interior Number">
                    <input id="colonia_fact" class="campos-direccion" type="text" name="" value="" placeholder="Colony*">
                    <input id="municipio_fact" class="campos-direccion" type="text" name="" value="" placeholder="Region*">
                    <input id="estado_fact" class="campos-direccion" type="text" name="" value="" placeholder="State*">
                    <input id="cp_fact" class="campos-direccion" type="text" name="" value="" placeholder="Zip Code*">
                </form>
            </div>
        </div>

        <a href="#" id="regresar-bag">Back</a>

        <!-- <div id="terms-carrito-address">
            <details id="terms-bloque-address">
                <summary>Summary of the main terms and conditions of sale <br>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                     Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
                     dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.<br>
                     <span id="more-address"><u><b>Ver mas</b></u></span>
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
            <div class="valor-campo">Free</div>
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
        <a href="javascript:;" id="continuar-pago-address" class="btn-taller">
            Continue
        </a>
        <div class="error-carrito address oculto"></div>
        <div class="contenedor-img">
            <?= Html::img('@web/images/eco_green.png', ['class' => 'img-responsive eco-checkout']) ?>
        </div>
        <div id="texto-payment">
            Payment information is transfered according to the highest security standards.
        </div>
    </div>
    <div class="clear"></div>
</div>
