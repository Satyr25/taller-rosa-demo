<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<div id="ver-producto">
    <h2 class="nombre-producto">
        <?= $nombre->nombre ?>
    </h2>
    <?= Html::a('Regresar', [Url::to('productos/index')], ['class' => 'btn-taller accion-principal']) ?>
        <div id="fotos-producto">
            <?php foreach($imagenes as $imagen){ ?>
                <?= Html::img('@web/images/'.$imagen->foto) ?>
            <?php } ?>
        </div>
</div>
