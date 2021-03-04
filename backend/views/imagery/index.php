<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
?>

<h2 class="titulo-seccion">IMAGERY</h2>

<?= Html::a('Agregar', [Url::to('imagery/agregar')], ['class' => 'btn-taller accion-principal']); ?>

<div class="clear"></div>

<?=
    GridView::widget([
        'dataProvider' => $dataProvider,
            'columns' => [
            'nombre',
            [
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
