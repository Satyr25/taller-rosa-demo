<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<div id="ver-producto">
    <h2 class="nombre-producto">
        <?= $producto->nombre ?> <span>$<?= number_format($producto->precio, 2) ?></span>
    </h2>
    <div class="boton-ver-prod">
        <?= Html::a('Regresar', [Url::to('productos/index')], ['class' => 'btn-taller accion-principal']) ?>
    </div>
    <div id="datos-producto">
        <div class="campo-producto" id="coleccion-producto">
            <span class="campo">Colección:</span>
            <span class="valor-campo"><?= $producto->coleccion ?></span>
        </div>
        <div class="campo-producto" id="categoria-producto">
            <span class="campo">Categoría:</span>
            <span class="valor-campo"><?= $producto->categoria ?></span>
        </div>
        <div class="campo-producto" id="categoria-producto">
            <span class="campo">Status:</span>
            <span class="valor-campo">
                <?php if($producto->status){
                    echo "Activo";
                }
                else{
                    echo "Inactivo";
                }
                ?>
            </span>
        </div>
        <div class="wrapper"></div>
        <div class="campo-producto" id="tallas-producto">
            <span class="campo">Tallas:</span>
            <span class="valor-campo">
                <?php foreach($tallas as $i => $talla){ ?>
                    <?= $talla->talla ?>
                    <?= $i+1 < count($tallas) ? ', ' : '' ?>
                <?php } ?>
            </span>
        </div>
        <div class="campo-producto" id="colores-producto">
            <span class="campo">Colores:</span>
            <span class="valor-campo">
                <?php foreach($colores as $i => $color){ ?>
                    <?= $color->color ?>
                    <?= $i+1 < count($colores) ? ', ' : '' ?>
                <?php } ?>
            </span>
        </div>
        <div class="campo-producto" id="categoria-producto">
            <span class="campo">Material:</span>
            <span class="valor-campo"><?= $producto->material ?></span>
        </div>
        <div id="fotos-producto">
            <?php foreach($fotos as $foto){ ?>
                <?= Html::img('@web/images/'.$foto->foto) ?>
            <?php } ?>
        </div>
        <div class="campo-producto" id="descripcion-producto">
            <span class="campo">Predescripcion:</span>
            <span class="valor-campo"><?= $producto->predescripcion ?></span>
        </div>
        <div class="campo-producto" id="descripcion-producto">
            <span class="campo">Descripcion:</span>
            <span class="valor-campo"><?= $producto->descripcion ?></span>
        </div>
    </div>
</div>
