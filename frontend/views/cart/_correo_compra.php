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

<table style="width: 600px;font-family:'Avenir';background-color: #e2e2e3;color:#000;">
    <tr>
        <th style="background-color: #e2e2e3; padding: 20px 0;text-align:center;font-family:'Avenir';">
            <a href="http://tr.blackrobot.mx">
                <img src="http://tr.blackrobot.mx/images/logo.png" style = "display:inline-block; margin-left:10px; margin-right:10px; height:40px; margin-top:40px" />
			</a>
            <div style="font-family:'Avenir';font-size:23px;margin-top:40px;margin-bottom:90px;letter-spacing: 4px;">
                SE REALIZ&#211; UNA COMPRA EN L&#205;NEA
            </div>
            <div style="font-family:'Avenir';margin-top:40px; margin-bottom:70px;text-transform:uppercase;">
                <b style="font-family:'Avenir';letter-spacing: 4px;">DATOS DE LA VENTA</b><br>
                <div style="font-family:'Avenir';font-size:14px;font-weight:100;margin-top:10px">
                    ID de venta: <?php echo rand(100,2000); ?>
                </div>
            </div>
            <div style="font-family:'Avenir';margin-top:40px; margin-bottom:70px;text-transform:uppercase;">
                <b style="font-family:'Avenir';letter-spacing: 4px;">DATOS DEl PEDIDO</b><br>
                <?php  $cant=count($products);
                        for ($i = 0; $i < $cant; $i++){
                        $foto=$producto->fotoCorreo($products[$i][0]);
                ?>
                <div style="font-family:'Avenir';font-size:14px;font-weight:100;margin-top:17px">
                    cantidad: <?php echo $products[$i][5]?>
                </div>
                <div style="font-family:'Avenir';font-size:14px;font-weight:100;margin-top:8px">
                    producto: <?php print_r($foto["nombre"]); ?>
                </div>
                <div style="font-family:'Avenir';font-size:14px;font-weight:100;margin-top:8px">
                    total: $<?php echo "".$products[$i][5]*$products[$i][4].".00 MXN"; ?>
                </div>
                <div style="font-family:'Avenir';font-size:14px;font-weight:100;margin-top:8px">
                    descuento: $<?php echo "".$products[$i][6].".00 MXN"; ?>
                </div>
            <?php } ?>
            </div>

            <div style="font-family:'Avenir';margin-top:40px; margin-bottom:70px;text-transform:uppercase;">
                <b style="font-family:'Avenir';letter-spacing: 4px;">DATOS DEl cliente</b><br>
                <div style="font-family:'Avenir';font-size:14px;font-weight:100;margin-top:10px">
                    nombre: <?php echo $nom; ?>
                </div>
                <div style="font-family:'Avenir';font-size:14px;font-weight:100;margin-top:5px;text-transform:none;">
                    CORREO:<?php echo " ".$correo." "; ?>
                </div>
                <div style="font-family:'Avenir';font-size:14px;font-weight:100;margin-top:5px">
                    domicilio: <?php echo $calle." ".$numero.", Col. ".$colonia.", ".$mun." CP. ".$cp."."; ?>
                </div>
                <div style="font-family:'Avenir';font-size:14px;font-weight:100;margin-top:5px">
                    CIUDAD: <?php echo $edo; ?>
                </div>
                <div style="font-family:'Avenir';font-size:14px;font-weight:100;margin-top:5px">
                    TEL&#201;FONO: <?php echo $tel; ?>
                </div>

            </div>
        </th>
    </tr>


        <tr>
            <td style="text-align:center;">
                <div style="font-family:'Avenir';font-size:15px;letter-spacing:2px;margin-top:25px;">
                    TALLER DE LA ROSA
                </div>
                <div style="font-family:'Avenir';font-size:12px;margin-bottom:25px;">
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
