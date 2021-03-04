<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;

use frontend\models\ImageryImg;

/**
 * Site controller
 */
class ImageryController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionView($id)
    {
        return $this->render('view',[
            'fotos' => ImageryImg::find()->where('imagery_img.imagery_id='.$id)->all(),
            'id' => $id
        ]);
    }

}
