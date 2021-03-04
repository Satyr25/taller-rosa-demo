<?php
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\models\Producto;
?>

<div class="payment oculto">
    <div id="pagos-carrito">
        <div class="clear"></div>
        <span>Payment Method</span>
        <div id="pagos">
            <form id="card-form">
                <span class="card-errors"></span>
                <div class="divisiones-pay">
                    <!-- <input type="radio" id="visa" name="tarjeta" value="visa">
                    <label for="visa">VISA</label>

                    <input type="radio" id="mastercard" name="tarjeta" value="mastercard">
                    <label for="mastercard">MasterCard</label> -->
                    <input type="text" id="numero" class="campos-direccion" size="20" data-conekta="card[number]" placeholder="Card Number" maxlength="16">
                    <input type="text" class="campos-direccion" size="20" data-conekta="card[name]" placeholder="Name in Card">
                    <input type="password" id="codigo" class="campos-direccion" size="20" data-conekta="card[cvc]" placeholder="CVC" maxlength="4">
                </div>

                <div class="divisiones-pay">
                    <p>
                        <label class="label-payment">Expiration Date</label>
                    </p>
                    <select class="campos-direccion-date" id="exp-month" data-conekta="card[exp_month]">
                        <option value="01">01</option>
                        <option value="02">02</option>
                        <option value="03">03</option>
                        <option value="04">04</option>
                        <option value="05">05</option>
                        <option value="06">06</option>
                        <option value="07">07</option>
                        <option value="08">08</option>
                        <option value="09">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                    <select class="campos-direccion-date" id="exp-year" data-conekta="card[exp_year]">
                        <option value="2019">2019</option>
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                        <option value="2027">2027</option>
                        <option value="2028">2028</option>
                    </select>
                    <!-- <input size="2" id="exp-month"  data-conekta="card[exp_month]" type="text" placeholder="MM">
                    <span>/</span>
                    <input size="4" id="exp-year" class="campos-direccion-date" data-conekta="card[exp_year]" type="text" placeholder="Year"> -->
                </div>
            </form>

        </div>
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
        <div class="envio-gratis">
            <span>Free shipping on orders over $350</span>
        </div>
        <button id="continuar-pago-payment" class="btn-taller">Pay now</button>
        <div class="error-carrito payment oculto"></div>
        <div class="contenedor-img">
            <?= Html::img('@web/images/eco_green.png', ['class' => 'img-responsive eco-checkout']) ?>
        </div>
        <div id="texto-payment">
            Payment information is transfered according to the highest security standards.
        </div>
        <div class="spinner"></div>
    </div>
    <div class="clear"></div>
</div>
