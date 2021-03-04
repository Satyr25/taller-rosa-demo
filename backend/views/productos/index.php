<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
?>

<h2 class="titulo-seccion">COLLECTIONS</h2>

<?= Html::a('Agregar producto', [Url::to('productos/agregar')], ['class' => 'btn-taller accion-principal']) ?>
<?= Html::a('Agregar coleccion', [Url::to('productos/agregar-coleccion')], ['class' => 'btn-taller accion-principal']) ?>

<div class="clear"></div>

<?=
GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'nombre',
        'categoria',
        'coleccion',
        [
            'label' => 'Precio',
            'value' => function ($model) {
                return '$'.number_format($model->precio, 2);
            }
        ],
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
            'template' => '{view} {update} {delete}',
            'buttons' => [
                'view' => function ($url,$model) {
                    return Html::a(
                        '',
                        $url,
                        ['class'=>'boton-ver']
                    );
                },
                'update' => function ($url,$model) {
                    return Html::a(
                        '',
                        $url,
                        ['class'=>'boton-editar']);
                },
                'delete' => function ($url,$model) {
                    return Html::a(
                        '',
                        $url,
                        ['class'=>'boton-borrar']);
                },
	        ],
        ],
    ],
]);
?>
