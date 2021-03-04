<?php

    use yii\helpers\Html;
    use yii\helpers\Url;

?>

<div id="press">
    <div class="wrapper">
        <h2>PRESS</h2>
        <?php foreach($press as $articulo){?>
        <div class="row press-post">
            <div class="col-xs-12 titulo"><?= $articulo->titulo?></div>
            <div class="col-xs-12 fecha"><?= nl2br(nl2br($articulo->texto)) ?></div>
        </div>
        <br>
        <div class="row row-press">
            
            <?php foreach ($articulo->pressVideos as $video){ ?> 
                <div class="col-sm-12 img-press">
                    <iframe class='frame-video-press' src="https://www.youtube.com/embed/<?=$video->video?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            <?php } ?>
            
        </div>
        <br>
        <div class="row row-press">
            
            <?php foreach ($articulo->pressImgs as $imagen){ ?> 
                <div class="col-sm-4 img-press">
                    <?= Html::img('@web/images/'.$imagen->imagen.'', ['class' => 'img-responsive popup-press', 'data-mfp-src' => Url::to('@web/images/'.$imagen->imagen.'')]) ?>
                </div>
            <?php } ?>
            
        </div>
        <br>
        <div class="row">
            <div class="col-xs-12 texto">
                <p class="texto-press">
                    <?= $articulo->creditos ?>
                </p>
            </div>
        </div>
        <?php } ?>
        <br>
        <br>
    </div>
</div>