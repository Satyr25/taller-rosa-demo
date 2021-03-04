<?php
namespace app\components;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\models\Newsletter;

//use app\models\ContactoForm;

class NewsletterWidget extends Widget
{

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $newsletter_form = new Newsletter();
        return $this->render('_newsletter', [
            'newsletter_form' => $newsletter_form,
        ]);
        /*
        $model = new ContactoForm();
        if ($model->load($_POST) && $model->validate()) {
            if ($model->sendEmail('christian@blackrobot.mx')) {
                Yii::$app->session->setFlash('success', 'Gracias por contactarnos. En breve nos comunicaremos contigo.');
            } else {
                Yii::$app->session->setFlash('error', 'Error al enviar correo.');
            }

            Yii::$app->getResponse()->redirect(Yii::$app->urlManager->createUrl('home'));
            return;
        } else {
            return $this->render('_contacto', [
                'contacto' => $model,
            ]);
        }
        */
    }
}
