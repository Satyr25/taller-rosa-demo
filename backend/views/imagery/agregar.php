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

    <?= $form->field($imagery, 'coleccion')->textInput(['placeholder'=>'SERIE 01']) ?>

        <?php
            // echo $form->field($imagery, 'coleccion')
            //     ->dropDownList(
            //         $colecciones,
            //         ['prompt'=>'']
            //     );
        ?>

        <div id="fotos">
            <div>
                <?= $form->field($imagery, 'fotos[]')->fileInput(['accept' => '.jpg,.jpeg,.png']) ?>
            </div>
            <a href="javascript:;" class="btn-taller" id="agregar-foto-imagery">Agregar foto</a>
        </div>

        <div class="clear"></div>


        <div class="form-group acciones">
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary btn-taller']) ?>
        </div>

    <?php ActiveForm::end(); ?>
</div>
