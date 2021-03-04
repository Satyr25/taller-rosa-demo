<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

use dosamigos\fileupload\FileUploadUI;
?>

<div class="wrap">
    <?php $form = ActiveForm::begin([
        'id' => 'formulario-producto',
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>
        <div class="clear"></div>

        <?= $form->field($coleccion, 'coleccion')->textInput() ?>

        <div class="clear"></div>

        <div class="form-group acciones">
            <?= Html::submitButton('Guardar', ['class' => 'btn-taller']) ?>
        </div>

    <?php ActiveForm::end(); ?>
</div>


<section>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                
            </div>
        </div>
    </div>
</section>

<?=
GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'nombre',
        [
            'label' => 'Status',
            'value' => function ($model) {
                if($model->status == 0){
                    return "Inactivo";
                }else {
                    return "Activo";
                }
            }
        ],
        [
            'header' => 'Accion',
            'class' => 'yii\grid\ActionColumn',
            'template' => '{delete}',
            'buttons' => [
                'delete' => function ($url, $model) {
                    return Html::a('', ['productos/delete-coleccion', 'id' => $model->id], ['class'=>'boton-borrar']);
                },
	        ],
        ],
    ],
]);
?>