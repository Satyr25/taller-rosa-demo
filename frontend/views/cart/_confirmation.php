<?php
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\models\Producto;
?>

<div class="confirmation oculto">
    <div id="confirmation-carrito">
        <div class="clear"></div>
        <p id="confirmation-title">Your order is confirmed</p>
        <p id="confirmation-p">We'll send you a mail with the purchase details and estimated date for shipping.</p>
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
        <div class="campo-totales div-descuento">
            <div class="nombre-campo">Discount</div>
            <div class="valor-campo" id="discount-compra">
                $<span class="discount-span">0.00</span>
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
        <!-- <div class="envio-gratis">
            <span>Free shipping on orders over $350</span>
        </div> -->
        <a href="<?= Url::to(['colection/view', 'id' => 1]) ?>" id="regresar-home-carrito" class="btn-taller">Go back to shopping</a>
    </div>
    <div class="clear"></div>
</div>
