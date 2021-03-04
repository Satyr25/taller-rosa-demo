<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

use app\models\Talla;

use dosamigos\fileupload\FileUploadUI;
?>

<div class="wrap">
    <?php $form = ActiveForm::begin([
        'id' => 'formulario-producto',
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>

        <?=
            $form->field($producto, 'categoria')
                ->dropDownList(
                    $categorias,
                    ['prompt'=>'']
                );
        ?>

        <?=
            $form->field($producto, 'coleccion')
                ->dropDownList(
                    $colecciones,
                    ['prompt'=>'']
                );
        ?>

        <?=
            $form->field($producto, 'status')
                ->dropDownList(
                    [0 =>'Inactivo',1 =>'Activo'],
                    ['prompt'=>'']
                );
        ?>

        <div class="clear"></div>

        <?= $form->field($producto, 'precio')->textInput() ?>
        <?= $form->field($producto, 'nombre')->textInput() ?>

        <div class="edita-fotos">
            <?php
                foreach($producto->fotos_upd as $foto)
                {
            ?>
                <div class="foto-guardada">
                    <?= Html::img('@web/images/'.$foto->archivo, ['class'=>'fotos-edita']); ?>

                    <?= Html::a('Quitar', 'javascript:;', ['id'=>$foto->id, 'class'=>'quitar-foto producto']); ?>
                </div>
            <?php
                }
             ?>
        </div>


        <div id="fotos">
            <div>
                <?= $form->field($producto, 'fotos[]')->fileInput(['accept' => '.jpg,.jpeg,.png']) ?>
            </div>
            <a href="javascript:;" class="btn-taller" id="agregar-foto-producto">Agregar foto</a>
        </div>

        <?php echo $form->field($producto, 'predescripcion')->textArea(['rows' => 5]); ?>
        <?php echo $form->field($producto, 'descripcion')->textArea(['rows' => 10]); ?>
        
        <?= $form->field($producto, 'material')->textInput() ?>
        <?php echo $form->field($producto,'colores')->inline(true)->checkboxList($colores); ?>
        <?php echo $form->field($producto, 'tallas')->inline(true)->checkboxList($tallas); ?>
        <div class="clear"></div>
        

        <div class="talla_colores" id="talla_colores" data-producto="<?=Yii::$app->request->get('id')?>">
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

        <div class="clear"></div>
        <div class="form-group acciones">
            <?= Html::submitButton('Guardar', ['class' => 'btn-taller']) ?>
        </div>

   
    <?php ActiveForm::end(); ?>
</div>
