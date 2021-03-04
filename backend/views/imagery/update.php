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

    <div class="edita-fotos">
        <?php
            foreach($imagery->fotos_upd as $foto)
            {
        ?>
            <div class="foto-guardada">
                <?= Html::img('@web/images/'.$foto->foto, ['class'=>'fotos-edita']); ?>

                <?= Html::a('Quitar', 'javascript:;', ['id'=>$foto->id, 'class'=>'quitar-foto imagery']); ?>
            </div>
        <?php
            }
         ?>
    </div>


    <div id="fotos">
        <div>
            <?= $form->field($imagery, 'fotos[]')->fileInput(['accept' => '.jpg,.jpeg,.png']) ?>
        </div>
        <a href="javascript:;" class="btn-taller" id="agregar-foto-imagery">Agregar foto</a>
    </div>

    <div class="clear"></div>


    <div class="form-group acciones">
        <?= Html::submitButton('Guardar', ['class' => 'btn-taller']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
