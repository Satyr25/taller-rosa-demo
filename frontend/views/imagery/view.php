<?php
use yii\helpers\Html;
?>
<div id="imagery">
    <div class="wrapper">
        <h2>IMAGERY</h2>
        <div id="imagenes">
            <?php foreach($fotos as $foto){
                    echo Html::img('@web/images/'.$foto->foto);
            }
            ?>
        </div>
        <div class="texto-imagery">
            <?php if($id == '13'){ ?>
                Jessica De la Rosa - Executive Producer, Creative Director<br>
                Rafa De la Lastra - Producer, Director of Photography<br>
                Juan Flesca - Creative Director<br>
                Models: Natalia Plascencia & Sarahi Carrillo<br>
                Special Thanks to Álvaro Castillo
            <?php }else if($id == '15'){ ?>
                Jessica De La Rosa - Executive Producer, Creative Director.<br>
                Gabriel Vico - Director of Photography.<br>
                Special Guest: Jordi Barnard<br>
                Thanks to Rafa Rivero and Christian Barnard.<br>
            <?php } ?>
        </div>
        <div class="texto-imagery">
            Instagram: <a href="https://www.instagram.com/tallerdelarosa/" target="_blank">@Tallerdelarosa</a><br>
            Copyright © <?= $id == '13' ? '2018' : '2019' ?>, Taller De La Rosa
        </div>
    </div>
</div>
