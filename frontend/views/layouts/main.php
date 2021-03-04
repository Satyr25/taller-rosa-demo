<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use app\components\NewsletterWidget;
use app\components\ColeccionesWidget;
use app\components\TrWidget;
use app\components\ImageryWidget;
use app\components\TallerWidget;
use app\components\CarritoComponent;

$this->title = 'Taller de la Rosa';
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, height=device-height">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="shortcut icon" href="<?= Yii::$app->request->BaseUrl ?>/favicon.png" type="image/png" />
</head>
<body class="<?= Yii::$app->controller->id ?>">

<?php   
    if (Yii::$app->controller->id == 'taller' && $this->context->action->id == 'blanco'){ 
        $wrap_class = 'wrap-gris';
    } 
?>

<?php $this->beginBody() ?>


<div class="wrap <?= $wrap_class ?>">
    <header id="main-header">
        <div class="wrapper">
            <?php
            echo Html::a(
                '',
                null,
                ['class' => 'desplegar-menu', 'href' => 'javascript:;', 'id' => 'menu-superior']
            );
            ?>
            <div id="menu" class="menu">
                <?= Html::a(
                    'Home',
                    ['/']
                ) ?>
                <?= Html::a(
                    TallerWidget::widget([]),
                    null,
                    ['href' => 'javascript:;', 'style' => 'display:none;']
                ) ?>
                <?= Html::a(
                    ImageryWidget::widget([]),
                    null,
                    ['href' => 'javascript:;', 'style' => 'display:none;']
                ) ?>
                <?= Html::a(
                    ColeccionesWidget::widget([]),
                    null,
                    ['href' => 'javascript:;', 'style' => 'display:none;']
                ) ?>
                <?= Html::a(
                    TrWidget::widget([]),
                    null,
                    ['href' => 'javascript:;', 'style' => 'display:none;']
                ) ?>
                <?= Html::a(
                    'Stockists',
                    ['stockists/']
                ) ?>
                <?= Html::a(
                    'Sustainability',
                    ['site/sustainability'],
                    ['href' => 'javascript:;']
                ) ?>
                <?= Html::a(
                    'Information',
                    ['information/'],
                    ['class' => 'mobile']
                ) ?>
                <?= Html::a(
                    'Contributors',
                    ['contributors/'],
                    ['class' => 'mobile']
                ) ?>
                <?= Html::a(
                    'Contact',
                    ['contact/'],
                    ['class' => 'mobile']
                ) ?>
                <?= Html::a(
                    'Press',
                    ['press/'],
                    ['class' => 'mobile']
                ) ?>
                <?= Html::a(
                    'Mailinglist',
                    null,
                    ['id' => 'newsletter-mobile', 'href' => '#newsletter-popup', 'class' => 'popup-with-zoom-anim']
                ) ?>
                <div id="redes-mobile">
                    <?= Html::a(
                        Html::img('@web/images/redes/instagram.png'),
                        'https://www.instagram.com/tallerdelarosa/',
                        ['target' => '_blank']
                    ) ?>
                    <?= Html::a(
                        Html::img('@web/images/redes/facebook.png'),
                        'https://www.facebook.com/tallerdelarosamx/',
                        ['target' => '_blank']
                    ) ?>
                    <?= Html::a(
                        Html::img('@web/images/redes/youtube.png'),
                        'https://www.youtube.com/channel/UCekrS9JNUZzLGbbH_vuWlIA',
                        ['target' => '_blank']
                    ) ?>
                    <?= Html::a(
                        Html::img('@web/images/redes/spotify.png'),
                        'https://open.spotify.com/user/x4b6dkl3lqx0zzthcuoqdbxzu?si=b4s6NGndRfOpHp9-d0ci0g',
                        ['target' => '_blank']
                    ) ?>
                </div>
            </div>
            <?= Yii::$app->Carrito->botonCarrito(); ?>
        </div>
    </header>
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="wrapper">
        <!-- <?php
        echo Html::a(
             '',
            null,
            ['class' => 'desplegar-menu', 'href' => 'javascript:;', 'id'=>'menu-inferior']
        );
        ?> -->
        <div id="menu-footer" class="menu visible">
            <?= Html::a(
                'Information',
                ['information/'],
                ['href' => 'javascript:;']
            ) ?>
            <?= Html::a(
                'Contributors',
                ['contributors/'],
                ['href' => 'javascript:;']
            ) ?>
            <?= Html::a(
                'Contact',
                ['contact/'],
                ['href' => 'javascript:;']
            ) ?>
            <?= Html::a(
                'Press',
                ['press/'],
                ['href' => 'javascript:;']
            ) ?>
            <?= Html::a(
                'Mailinglist',
                null,
                ['id' => 'newsletter', 'href' => '#newsletter-popup', 'class' => 'popup-with-zoom-anim']
            ) ?>
        </div>
        <a href="<?= Yii::$app->homeUrl ?>" id="logo">
            <?= Html::img('@web/images/logo.png', ['id' => 'logo_negro']) ?>
            <?= Html::img('@web/images/logo_blanco.png', ['id' => 'logo_blanco']) ?>
        </a>
        <div id="redes">
            <?= Html::img('@web/images/eco_white.png', ['class' => 'img-responsive img-eco red-white']) ?>
            <?= Html::img('@web/images/eco_green.png', ['class' => 'img-responsive img-eco red-black']) ?>
            
            <?= Html::a(
                Html::img('@web/images/redes/instagram.png',['class'=>'red-black']).
                Html::img('@web/images/redes/instagram_blanco.png',['class'=>'red-white']),
                'https://www.instagram.com/tallerdelarosa/',
                ['target' => '_blank']
            ) ?>
            <?= Html::a(
                Html::img('@web/images/redes/facebook.png',['class'=>'red-black']).
                Html::img('@web/images/redes/facebook_blanco.png',['class'=>'red-white']),
                'https://www.facebook.com/tallerdelarosamx/',
                ['target' => '_blank']
            ) ?>
            <?= Html::a(
                Html::img('@web/images/redes/youtube.png',['class'=>'red-black']).
                Html::img('@web/images/redes/youtube_blanco.png',['class'=>'red-white']),
                'https://www.youtube.com/channel/UCekrS9JNUZzLGbbH_vuWlIA',
                ['target' => '_blank']
            ) ?>
            <?= Html::a(
                Html::img('@web/images/redes/spotify.png',['class'=>'red-black']).
                Html::img('@web/images/redes/spotify_blanco.png',['class'=>'red-white']),
                'https://open.spotify.com/user/x4b6dkl3lqx0zzthcuoqdbxzu?si=b4s6NGndRfOpHp9-d0ci0g',
                ['target' => '_blank']
            ) ?>
        </div>
    </div>
    <?= NewsletterWidget::widget([]) ?>
</footer>
<?php
if (class_exists('yii\debug\Module')) {
    $this->off(\yii\web\View::EVENT_END_BODY, [\yii\debug\Module::getInstance(), 'renderToolbar']);
}
?>
<?php $this->endBody() ?>
<input type="hidden" id="base_path" value="<?= Yii::$app->request->BaseUrl ?>" />
</body>
</html>
<?php $this->endPage() ?>
