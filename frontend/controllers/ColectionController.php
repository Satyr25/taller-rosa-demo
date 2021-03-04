<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Coleccion;
use frontend\models\Producto;
use frontend\models\Talla;
use frontend\models\Color;
use frontend\models\SoldEmail;


/**
 * Site controller
 */
class ColectionController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionView($id)
    {
        return $this->render('view',[
            'coleccion' => Coleccion::findOne($id),
            'productos' => Producto::find()->where('coleccion_id = '.$id.' AND status=1')->all()
        ]);
    }
    
    public function actionSaveSoldEmail(){
        $sold_data = Yii::$app->request->post('SoldEmail');
        $sold_email = new SoldEmail();
        $sold_email->load(Yii::$app->request->post());
        if ($sold_email->validate()) {
            if (!$sold_email->save()){
                return false;
            }
            
            $producto = Producto::find()->where(['id' => $sold_data['producto_id']])->one();
            $coleccion = Coleccion::find()->where(['id' => $producto->coleccion_id])->one();
            $talla = Talla::find()->where(['id' => $sold_data['talla_id']])->one();
            $color = Color::find()->where(['id' => $sold_data['color_id']])->one();
            $email = $sold_data['email'];
            
            Yii::$app->mailer->compose()
            ->setTo($model->email)
            ->setFrom(["equipo@blackrobot.mx"=>"Taller de la Rosa"])
//            ->setFrom(["ventas@tallerdelarosa.com"=>"Taller de la Rosa"])
            ->setSubject("Producto SoldOut")
            ->setHtmlBody(
                $this->renderPartial('_correo_soldout',[
                    'producto' => $producto,
                    'talla' => $talla,
                    'color' => $color,
                    'email' => $email,
                ])
            )
            ->send();
            
        } else {
            return false;
        }
        return true;
    }
    
//    public function actionPruebaMail(){
//        
//        $producto = Producto::find()->where(['id' => Yii::$app->request->get('producto')])->one();
//        $coleccion = Coleccion::find()->where(['id' => $producto->coleccion_id])->one();
//        $talla = Talla::find()->where(['id' => Yii::$app->request->get('talla')])->one();
//        $color = Color::find()->where(['id' => Yii::$app->request->get('color')])->one();
//        $email = Yii::$app->request->get('email');
////var_dump('asda');
//        return $this->renderPartial('_correo_soldout',[
//            'producto' => $producto,
//            'coleccion' => $coleccion,
//            'talla' => $talla,
//            'color' => $color,
//            'email' => $email,
//        ]);
//    }

}
