<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Html;
use \yii\web\Cookie;
use frontend\models\Coleccion;
use frontend\models\Producto;
use frontend\models\Carrito;
use frontend\models\Sold;
use frontend\models\SoldEmail;
use frontend\models\ProductoCarrito;
use frontend\models\carrito\AgregarForm;
use app\components\CarritoComponent;

/**
 * Site controller
 */
class ProductoController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionView($id)
    {
        $producto = new Producto();
        $fotos = array();
        foreach($producto->fotos($id) as $foto){
            $fotos[] = [
                'content' => Html::img('@web'.'/images/'.$foto->foto)
            ];
        }
        $producto = $producto->datos($id);
        $carrito = new AgregarForm();
        $carrito->producto_id = $id;
        $carrito->cantidad = 1;
        $sold_email = new SoldEmail();
        return $this->renderAjax('view',[
            'producto' => $producto,
            'fotos' => $fotos,
            'colores' => $producto->colores($producto->id, true),
            'tallas' => $producto->tallas($producto->id, true),
            'productos' => Producto::find()
                            ->where('coleccion_id = '.$producto->coleccion_id.' AND id != '.$producto->id)
                            ->all(),
            'carrito' => $carrito,
            'sold_email' => $sold_email,
        ]);
    }

    public function actionViewCarro($id)
    {
        $producto = new Producto();
        $fotos = array();
        foreach($producto->fotos($id) as $foto){
            $fotos[] = [
                'content' => Html::img('@web'.'/images/'.$foto->foto)
            ];
        }
        $producto = $producto->datos($id);
        $carrito = new AgregarForm();
        $carrito->producto_id = $id;
        $carrito->cantidad = 1;
        return $this->renderAjax('viewCarro',[
            'producto' => $producto,
            'fotos' => $fotos,
            'colores' => $producto->colores($producto->id, true),
            'tallas' => $producto->tallas($producto->id, true),
            'productos' => Producto::find()
                            ->where('coleccion_id = '.$producto->coleccion_id.' AND id != '.$producto->id)
                            ->all(),
            'carrito' => $carrito
        ]);
    }

    public function actionAgregarCarrito(){
        if(!Yii::$app->request->isAjax){
            return Yii::$app->getResponse()->redirect(Yii::$app->homeUrl);
        }
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return Yii::$app->Carrito->agregar(
            Yii::$app->request->post('producto'),
            Yii::$app->request->post('talla'),
            Yii::$app->request->post('color'),
            Yii::$app->request->post('cantidad')
        );
    }

    public function actionActualizarCarrito(){
        if(!Yii::$app->request->isAjax){
            return Yii::$app->getResponse()->redirect(Yii::$app->homeUrl);
        }
        // var_dump(Yii::$app->request->getBodyParams());exit;
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return Yii::$app->Carrito->actualizar(
            Yii::$app->request->getBodyParams()
        );
    }

    public function actionCheckSold(){
        $sold_out = Sold::find()->where(['producto_id' => Yii::$app->request->post('producto'), 'talla_id' => Yii::$app->request->post('talla'), 'color_id' => Yii::$app->request->post('color')])->one();
        $respuesta = array();
        if ($sold_out){
            $respuesta['agotado'] = 1;
        } else {
            $respuesta['agotado'] = 0;
        }
        return json_encode($respuesta);
    }
    
}
