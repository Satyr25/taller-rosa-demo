<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;

/**
 * Site controller
 */
class ContactController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }

}
