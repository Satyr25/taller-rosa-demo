<?php
namespace app\components;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

use frontend\models\Coleccion;

//use app\models\ContactoForm;

class ColeccionesWidget extends Widget
{

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $colecciones = Coleccion::find()->where(['status' => 1, 'tr' => 0])->all();
        return $this->render('_colecciones',[
            'colecciones' => $colecciones,
        ]);
    }
}
