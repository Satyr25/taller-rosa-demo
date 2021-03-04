<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
?>

<h2 class="titulo-seccion">NEWSLETTER</h2>

<div class="clear"></div>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
    'options' => ['class' => 'newsletter-table'],
    'columns' => [
//        ['class' => 'yii\grid\SerialColumn'],

//            'id',
        'nombre',
        'email:email',
        'created_at:date',

//            ['class' => 'yii\grid\ActionColumn'],
    ],
]); ?>


