<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use app\models\Press;
//use app\models\PressImg;

/**
 * Site controller
 */
class PressController extends Controller
{

    public function actionIndex()
    {
        $press = Press::find()->orderBy(['created_at' => SORT_DESC])->all();
        return $this->render('index',[
            'press'=>$press
        ]);
    }

}
