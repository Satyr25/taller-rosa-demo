<?php

use app\models\Talla;
use app\models\Color;
?>


<div class="talla_colores" id="talla_colores" data-producto="<?=$id?>">
    <?php foreach($talla_colores as $i_talla => $talla_color){ ?> 

        <div class="sold-input field-productoform-sold-<?=$i_talla?>">
            <label class="control-label">Sold Out <?=(Talla::find()->where(['id' => $i_talla])->one())->talla?></label>
            <div>
                <input type="hidden" name="ProductoForm[sold][<?=$i_talla?>]" value="">
                <div id="productoform-sold-<?=$i_talla?>">
                    <?php foreach($talla_color as $i_color => $color){ ?> 
                        <label class="checkbox-inline">
                            <?php if($producto->talla_colores){ ?> 
                                <?php foreach($producto->talla_colores as $activo){ ?>
                                    <?php if (($activo->talla_id == $i_talla) && ($activo->color_id == $i_color)){ ?>
                                        <?= var_dump($i_color) ?>
                                        <?= var_dump($activo->color_id) ?>
                                        <input type="checkbox" name="ProductoForm[sold][<?=$i_talla?>][]" value="<?=$i_color?>" checked>
                                    <?php } else { ?> 
                                        <input type="checkbox" name="ProductoForm[sold][<?=$i_talla?>][]" value="<?=$i_color?>">
                                    <?php } ?>
                                <?php } ?>
                            <?php } else { ?> 
                                <input type="checkbox" name="ProductoForm[sold][<?=$i_talla?>][]" value="<?=$i_color?>">
                            <?php } ?>
                        <?=$color?>
                        </label>
                    <?php } ?>
                </div>
                <p class="help-block"></p>
            </div>
        </div> 
    <?php } ?>
</div> 




