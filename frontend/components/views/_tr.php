<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div id="opcion-colecciones">¿
    <a href="<?= Url::to(['taller/blanco']) ?>" class="tr-link">TR BED</a>
    <div id="listado-colecciones2">
        <?php foreach($colecciones as $coleccion){ ?>
            <?= Html::a(
                $coleccion->nombre,
                Url::to(['taller/blanco', 'id' => $coleccion->id])
            ) ?>
        <?php } ?>
    </div>
</div>
