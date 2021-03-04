<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<style>

@import url('https://fonts.googleapis.com/css?family=Avenir:400,700');
@font-face {
    font-family: 'Avenir';
    src: url('http://tr.blackrobot.mx/fonts/avenir/AvenirLTStd-Light.eot');
    src: url('http://tr.blackrobot.mx/fonts/avenir/AvenirLTStd-Light.eot?#iefix') format('embedded-opentype'),
        url('http://tr.blackrobot.mx/fonts/avenir/AvenirLTStd-Light.woff2') format('woff2'),
        url('http://tr.blackrobot.mx/fonts/avenir/AvenirLTStd-Light.woff') format('woff'),
        url('http://tr.blackrobot.mx/fonts/avenir/AvenirLTStd-Light.ttf') format('truetype'),
        url('http://tr.blackrobot.mx/fonts/avenir/AvenirLTStd-Light.svg#AvenirLTStd-Light') format('svg');
    font-weight: normal;
    font-style: normal;
}
</style>

<?php $domain = yii\helpers\Url::base(true);?>
<?php $src = $domain.'/images/' ?>

<table style="width: 600px;font-family:'Avenir';background-color: #e2e2e3;color:#000;">
    <tr>
        <th style="background-color: #e2e2e3; padding: 20px 0;text-align:center;font-family:'Avenir';">
            <a href="http://tr.blackrobot.mx">
                <img src="<?php echo $src?>logo.png" style = "display:inline-block; margin-left:10px; margin-right:10px; height:40px; margin-top:40px" />
            </a>
            <div style="font-family:'Avenir';font-size:19px;margin-top:40px;margin-bottom:20px;letter-spacing: 4px;">
                &#161;GRACIAS POR TU COMPRA!
            </div>
            <div style="margin-top:40px; margin-bottom:25px">
                <b style="letter-spacing: 2px;">TU PEDIDO SE ENVIARÁ A:</b><br>
                <div style="font-size:14px;font-weight:100">
                    <?= $calle." ".$numero.", Colonia ".$colonia?>
                    <br>
                    <?= "CP. ".$cp?>
                    <br>
                    <?=$edo?>
                    <br>
                    <?="Tel: ".$tel ?>
                </div>
            </div>
        </th>
    </tr>
    <?php  $cant=count($products);
            for ($i = 0; $i < $cant; $i++){
            $foto=$producto->fotoCorreo($products[$i][0]);
    ?>
    <tr>
        <td>
            <img src="<?php echo $src?><?php print_r($foto["foto"]) ?>" style="margin-left:150px;width:auto;height:200px;">
        </td>
        <td>
            <table style="width:200px; margin-left:-270px;text-transform:uppercase; ">
                <tr>
                    <td style="height:30px">
                        <b> <?php print_r($foto["nombre"]); ?> </b></td>
                </tr>
                <tr>
                    <td style="font-size:13px;height:20px;">COLOR: <?php echo $products[$i][1] ?></td>
                </tr>
                <tr>
                    <td style="font-size:13px;height:20px;">SIZE: <?php echo $products[$i][2] ?></td>
                </tr>
                <tr>
                    <td style="font-size:13px;height:20px;">PRICE: $<?php echo $products[$i][3] ?></td>
                </tr>
                <tr>
                    <td style="font-size:13px;height:20px;">DESCUENTO: $<?php echo $products[$i][6] ?></td>
                </tr>
            </table>
        </td>
    </tr>
    <?php } ?>

    <tr >
        <td style="text-align:center;">
            <div style="font-size:15px;letter-spacing:2px;margin-top:25px;">
                TALLER DE LA ROSA
            </div>
            <div style="font-size:12px;margin-bottom:25px;">
                MEXICO CITY
            </div>
        </td>
    </tr>
    <tr>
        <td style="padding-top:10px;padding-bottom:25px;background-color:#e2e2e3;text-align:center;">
            <a href="https://www.instagram.com/tallerdelarosa/" style="text-decoration:none;">
                <img src="http://tr.blackrobot.mx/images/redes/instagram.png" style="display:inline-block;margin-left:10px;margin-right:10px;height:20px;" />
            </a>
            <a href="https://www.spotify.com/mx/" style="text-decoration:none;">
                <img src="http://tr.blackrobot.mx/images/redes/spotify.png" style="display:inline-block;margin-left:10px;margin-right:10px;height:20px;" />
            </a>
            <a href="https://www.facebook.com/tallerdelarosamx/" style="text-decoration:none;">
                <img src="http://tr.blackrobot.mx/images/redes/facebook.png" style="display:inline-block;margin-left:10px;margin-right:10px;height:20px;" />
            </a>
            <a href="https://www.youtube.com/" style="text-decoration:none;">
                <img src="http://tr.blackrobot.mx/images/redes/youtube.png" style="display:inline-block;margin-left:10px;margin-right:10px;height:20px;" />
            </a>
        </td>
    </tr>
</table>
