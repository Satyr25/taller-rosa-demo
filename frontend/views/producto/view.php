<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Carousel;
use yii\bootstrap\ActiveForm;
?>
<div id="colections">
    <div class="wrapper">
        <?php /*
        <h2 class="titulo-coleccion">
            COLLECTIONS - <span><?= $producto->coleccion ?></span>
        </h2>
        */?>
        <?= Carousel::widget([
            'items' => $fotos
        ]); ?>
        <div id="datos-producto">
            <div class="nombre-producto">
                <?= $producto->nombre ?>
            </div>
            <div class="precio-producto">
                $<?= number_format($producto->precio, 2) ?>
            </div>
            <div class="predescripcion-producto">
                <?= nl2br($producto->predescripcion) ?>
            </div>
            <div class="botones-cambio-guia">
                <span id="ver-descripcion" class="ver-descripcion selected">Description</span>
                <span id="ver-guia" class="ver-guia">Size guide</span>
            </div>
            <div class="descripcion-producto" id="descripcion-producto">
                <?= nl2br($producto->descripcion) ?>
            </div>
            <div class="guia-tallas" id="guia-tallas">
                <?php if($producto->blanco != '1'){ ?> 
                    <?= Html::img('@web/images/guia_tallas.jpg', ['class' => 'img-responsive img-guia', 'id' => 'img-guia']) ?>
                <?php } else { ?>
                    <?= Html::img('@web/images/guia_blancos.jpg', ['class' => 'img-responsive img-guia', 'id' => 'img-guia']) ?>
                <?php } ?>
            </div>
            <div id="agregar-carrito">
                <?php $form = ActiveForm::begin([
                    'id' => 'formulario-carrito',
                    'action' => ''
                ]); ?>
                    <?=
                        $form->field($carrito, 'color_id')
                            ->dropDownList(
                                $colores,
                                ['prompt'=>'Color']
                            )->label(false);
                    ?>
                    <?=
                        $form->field($carrito, 'talla_id')
                            ->dropDownList(
                                $tallas,
                                ['prompt'=>'Size']
                            )->label(false);
                    ?>
                    <?= $form->field($carrito, 'producto_id')->hiddenInput()->label(false); ?>
                    <?= $form->field($carrito, 'cantidad')->hiddenInput()->label(false); ?>
                    <div class="error-producto oculto"></div>
                    <div class="clear"></div>
                    <?= Html::submitButton('ADD TO SHOPPING BAG', ['class' => 'btn-taller', 'id' => 'boton-agregar-item']) ?>
                    <div class="botones-agregar-carrito oculto">
                        <!-- <a href="javascript:;" class="btn-taller agregado" id="cerrar-color">Continue Shopping</a> -->
                        <a href="javascript:;" class="btn-taller agregado" id="cerrar-color">Continue Shopping</a>
                        <?= Html::a(
                            'Go to Shopping bag',
                            ['cart/'],
                            ['class'=>'btn-taller agregado', 'id' => 'ir-carro']
                        );?>
                    </div>
                    <div class="spinner"></div>
                    <div id="respuesta-carrito"></div>
                <?php ActiveForm::end(); ?>
                    <div class="sold-mail">
                        <p class="sold-text">Item are Sold Out</p>
                        <p class="sold-text-2">We will send you an email when it is back.</p>
                        
                        <?php $form_email = ActiveForm::begin([
                            'action' => 'save-sold-email', 
                            'id' => 'sold-email',
                        ]); ?>
                            <?= $form_email->field($sold_email, 'talla_id')->hiddenInput()->label(false); ?>
                            <?= $form_email->field($sold_email, 'color_id')->hiddenInput()->label(false); ?>
                            <?= $form_email->field($sold_email, 'producto_id')->hiddenInput()->label(false); ?>
                            <?= $form_email->field($sold_email, 'email')->input('email',['placeholder' => 'Email'])->label(false); ?>
                        <?php ActiveForm::end(); ?>
                        <div class="error-sold">Por favor ingrese su Email</div>
                        <div class="success-sold">Le Informaremos cuando este disponible</div>
                        <?= Html::submitButton('LET ME KNOW', ['class' => 'let-me-know']) ?>
                    </div>
            </div>
        </div>
        <div class="clear"></div>
        <?php /*
        <div id="view-more">
            <a href="javascript:;">
                VIEW MORE
            </a>
        </div>
        <div id="mas-productos">
            <div class="grid-productos">
                <?php $i = 1 ?>
                <?php foreach($productos as $producto){ ?>
                    <?php $foto = $producto->fotoUnica($producto->id); ?>
                    <div class="pr<?= $i ?>">
                        <a href="<?= Url::to(['producto/view', 'id' => $producto->id]) ?>" class="producto" style="background-image:url('<?=  Yii::$app->request->BaseUrl.'/images/'.$foto->foto ?>')">
                        </a>
                    </div>
                    <?php $i++ ?>
                    <?php if($i > 8){ ?>
                        <?php $i = 1 ?>
                        </div>
                        <div class="grid-productos">
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
        */?>
    </div>
</div>
