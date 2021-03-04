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
            <div class="descripcion-producto">
                <?= $producto->descripcion ?>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>
