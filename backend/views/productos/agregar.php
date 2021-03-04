<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

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

        <div class="clear"></div>

        <?= $form->field($producto, 'precio')->textInput() ?>
        <?= $form->field($producto, 'nombre')->textInput() ?>
        <div id="fotos">
            <div>
                <?= $form->field($producto, 'fotos[]')->fileInput(['accept' => '.jpg,.jpeg,.png']) ?>
            </div>
            <a href="javascript:;" class="btn-taller" id="agregar-foto-producto">Agregar foto</a>
        </div>

        <?= $form->field($producto, 'predescripcion')->textArea(['rows' => 5]) ?>
        <?= $form->field($producto, 'descripcion')->textArea(['rows' => 10]) ?>
        <?= $form->field($producto, 'material')->textInput() ?>

        <?= $form->field($producto, 'colores[]')->inline(true)->checkboxList($colores) ?>
        <?= $form->field($producto, 'tallas[]')->inline(true)->checkboxList($tallas) ?>

        <div class="clear"></div>


        <div class="form-group acciones">
            <?= Html::submitButton('Guardar', ['class' => 'btn-primary btn-taller']) ?>
        </div>

    <?php ActiveForm::end(); ?>
</div>
