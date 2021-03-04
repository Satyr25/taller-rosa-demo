<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div id="opcion-colecciones">
    <a href="javascript:;">
        Imagery
        <div id="listado-colecciones">
<!--
            <?php foreach($imagerys as $imagery){ ?>
                <?php if($imagery->id == '15'){ ?>
                    <?= Html::a(
                        'Sal A Valle x Taller De La Rosa - Gabriel Vico',
                        Url::to(['imagery/view','id' => $imagery->id]
                         )
                    ) ?>
                <?php }else{ ?>
-->
                    <?= Html::a(
                        $imagery->nombre,
                        Url::to(['imagery/view','id' => $imagery->id]
                         )
                    ) ?>
<!--
                <?php } ?>
            <?php } ?>
-->
        </div>
    </a>
</div>
