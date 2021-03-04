<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\helpers\Json;

use backend\models\forms\ProductoForm;
use backend\models\forms\ColeccionForm;
use app\models\Categoria;
use app\models\Coleccion;
use app\models\Color;
use app\models\Talla;
use app\models\Sold;
use app\models\Producto;
use app\models\TallaProducto;
use app\models\ColorProducto;
use app\models\search\ProductoSearch;
use app\models\search\ColeccionSearch;

/**
 * Site controller
 */
class ProductosController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'blancos', 'agregar', 'agregartr', 'view', 'agregar-coleccion', 'agregar-colecciontr', 'update', 'delete', 'delete-coleccion', 'activar-coleccion', 'sold', 'change-talla', 'change-color'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                    'change-talla' => ['post'],
                    'change-color' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }


    public function actionIndex()
    {
        $searchModel = new ProductoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionBlancos()
    {
        $searchModel = new ProductoSearch();
        $dataProvider = $searchModel->searchtr(Yii::$app->request->queryParams);

        return $this->render('tr', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAgregar(){
        $producto = new ProductoForm();
        if ($producto->load(Yii::$app->request->post())) {
            if ($producto->guardar()) {
                Yii::$app->session->setFlash('success', "Producto creado correctamente");
                return $this->redirect(['productos/']);

            }else{
                Yii::$app->session->setFlash('error', "Ocurrió un error al guardar el producto.");
                return $this->refresh();
            }
        }
        $tallas = Talla::find()->where(['categoria.nombre' => 'Blancos'])->innerJoin('categoria', 'talla.categoria_id != categoria.id')->all();
        return $this->render('agregar',[
            'producto' => $producto,
            'categorias' => ArrayHelper::map(Categoria::find()->all(), 'id', 'nombre'),
            'colecciones' => ArrayHelper::map(Coleccion::find()->where(['status' => 1, 'tr' => 0])->all(), 'id', 'nombre'),
            'colores' => ArrayHelper::map(Color::find()->all(), 'id', 'color'),
            'tallas' => ArrayHelper::map($tallas, 'id', 'talla'),
        ]);
    }
    public function actionAgregartr(){
        $producto = new ProductoForm();
        if ($producto->load(Yii::$app->request->post())) {
            if ($producto->guardar()) {
                Yii::$app->session->setFlash('success', "Producto creado correctamente");
                return $this->redirect(['productos/blancos']);

            }else{
                Yii::$app->session->setFlash('error', "Ocurrió un error al guardar el producto.");
                return $this->refresh();
            }
        }
        $tallas = Talla::find()->where(['categoria.nombre' => 'Blancos'])->innerJoin('categoria', 'talla.categoria_id = categoria.id')->all();
        return $this->render('agregar',[
            'producto' => $producto,
            'categorias' => ArrayHelper::map(Categoria::find()->all(), 'id', 'nombre'),
            'colecciones' => ArrayHelper::map(Coleccion::find()->where(['status' => 1, 'tr' => 1])->all(), 'id', 'nombre'),
            'colores' => ArrayHelper::map(Color::find()->all(), 'id', 'color'),
            'tallas' => ArrayHelper::map($tallas, 'id', 'talla'),
        ]);
    }

    public function actionAgregarColeccion(){
        
        $searchModel = new ColeccionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    
        $coleccion = new ColeccionForm();
        if ($coleccion->load(Yii::$app->request->post())) {
            if ($coleccion->guardar()) {
                Yii::$app->session->setFlash('success', "Colección creada correctamente");
                return $this->refresh();

            }else{
                Yii::$app->session->setFlash('error', "Ocurrió un error al guardar el producto.");
                return $this->refresh();
            }
        }

        return $this->render('agregarColeccion',[
            'coleccion' => $coleccion,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionDeleteColeccion($id){
        $coleccion = Coleccion::find()->where('coleccion.id='.$id)->one();
        $coleccion->status = 0;
        if (!$coleccion->update()){
            Yii::$app->session->setFlash('Error', 'No se pudó eliminar la colección');
        }

        Yii::$app->session->setFlash('Success', 'Se eliminó la colección correctamente');
        return $this->redirect(['productos/agregar-coleccion']);
    }
    
    public function actionActivarColeccion($id){
        $coleccion = Coleccion::find()->where('coleccion.id='.$id)->one();
        $coleccion->status = 1;
        if (!$coleccion->update()){
            Yii::$app->session->setFlash('Error', 'No se pudó activar la colección');
        }

        Yii::$app->session->setFlash('Success', 'Se activó la colección correctamente');
        return $this->redirect(['productos/agregar-coleccion']);
    }
    
    public function actionAgregarColecciontr(){
        
        $searchModel = new ColeccionSearch();
        $dataProvider = $searchModel->searchtr(Yii::$app->request->queryParams);
    
        $coleccion = new ColeccionForm();
        if ($coleccion->load(Yii::$app->request->post())) {
            if ($coleccion->guardartr()) {
                Yii::$app->session->setFlash('success', "Colección creada correctamente");
                return $this->refresh();

            }else{
                Yii::$app->session->setFlash('error', "Ocurrió un error al guardar el producto.");
                return $this->refresh();
            }
        }

        return $this->render('agregarColeccion',[
            'coleccion' => $coleccion,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    

    public function actionView($id){
        $producto = new Producto();
        return $this->render('view',[
            'producto' => $producto->datos($id),
            'tallas' => $producto->tallas($id),
            'colores' => $producto->colores($id),
            'fotos' => $producto->fotos($id)
        ]);
    }

    public function actionUpdate($id)
    {
        $producto = new ProductoForm();
        if ($producto->load(Yii::$app->request->post())) {
            
            if(isset(Yii::$app->request->post()['ProductoForm']['fotos_elim']))
            {
                $producto->fotos_elim = Yii::$app->request->post()['ProductoForm']['fotos_elim'];
            }

            if ($producto->actualizar($id)) {
                Yii::$app->session->setFlash('success', "Producto creado correctamente");
                return $this->redirect(['productos/']);

            }else{
                Yii::$app->session->setFlash('error', "Ocurrió un error al guardar el producto.");
                return $this->refresh();
            }
        }

       $producto->cargarDatos($id);
      
       if($producto->categoria_nombre == 'Blancos'){
           $tallas = Talla::find()->where(['categoria.nombre' => 'Blancos'])->innerJoin('categoria', 'talla.categoria_id = categoria.id')->all();
       } else {
           $tallas = Talla::find()->where(['categoria.nombre' => 'Blancos'])->innerJoin('categoria', 'talla.categoria_id != categoria.id')->all();
       }
       $talla_colores = $this->actionSold($id);
        
       return $this->render('update', [
           'producto' => $producto,
           'categorias' => ArrayHelper::map(Categoria::find()->all(), 'id', 'nombre'),
           'colecciones' => ArrayHelper::map(Coleccion::find()->all(), 'id', 'nombre'),
           'colores' => ArrayHelper::map(Color::find()->all(), 'id', 'color'),
           'tallas' => ArrayHelper::map($tallas, 'id', 'talla'),
           'talla_colores' => $talla_colores,
       ]);
    }
    
    public function actionSold($id){
        $tallas = TallaProducto::find()->where(['producto_id' => $id])->all();
        $colores = Color::find()->where(['color_producto.producto_id' => $id])->innerJoin('color_producto', 'color_producto.color_id = color.id')->all();
        $talla_colores = array();
        
        foreach ($tallas as $talla){
            $talla_colores[$talla->talla->id] = (ArrayHelper::map($colores, 'id', 'color'));
        }
        return $talla_colores;
    }

    public function actionDelete($id){
        $producto = Producto::find()->where('producto.id='.$id)->one();
        $producto->status = 0;
        $producto->update();

        return $this->redirect(['index']);
    }

    public function actionChangeTalla(){
       $producto = new ProductoForm();
       $producto->cargarDatos(Yii::$app->request->post('id'));
      
       if($producto->categoria_nombre == 'Blancos'){
           $tallas = Talla::find()->where(['categoria.nombre' => 'Blancos'])->innerJoin('categoria', 'talla.categoria_id = categoria.id')->all();
       } else {
           $tallas = Talla::find()->where(['categoria.nombre' => 'Blancos'])->innerJoin('categoria', 'talla.categoria_id != categoria.id')->all();
       }
        if(Yii::$app->request->post('check') == 'true'){
            $talla_producto = new TallaProducto();
            $talla_producto->producto_id = Yii::$app->request->post('id');
            $talla_producto->talla_id = Yii::$app->request->post('talla');
            if(!$talla_producto->save()){
                var_dump($talla_producto->getErrors());exit;
                return false;
            }
        } else {
            $talla_producto = TallaProducto::find()->where(['producto_id' => Yii::$app->request->post('id'), 'talla_id' => Yii::$app->request->post('talla')])->all();
            foreach($talla_producto as $color){
                if(!$color->delete()){
                    var_dump($color->getErrors());exit;
                    return false;
                }
            }
        }
        $talla_colores = $this->actionSold(Yii::$app->request->post('id'));
        
        return $this->renderAjax('_talla_colores', [
            'producto' => $producto,
            'talla_colores' => $talla_colores,
            'id' => Yii::$app->request->post('id'),
       ]);
    }

    public function actionChangeColor(){
       $producto = new ProductoForm();
       $producto->cargarDatos(Yii::$app->request->post('id'));
      
       if($producto->categoria_nombre == 'Blancos'){
           $tallas = Talla::find()->where(['categoria.nombre' => 'Blancos'])->innerJoin('categoria', 'talla.categoria_id = categoria.id')->all();
       } else {
           $tallas = Talla::find()->where(['categoria.nombre' => 'Blancos'])->innerJoin('categoria', 'talla.categoria_id != categoria.id')->all();
       }
        if(Yii::$app->request->post('check') == 'true'){
            $color_producto = new ColorProducto();
            $color_producto->producto_id = Yii::$app->request->post('id');
            $color_producto->color_id = Yii::$app->request->post('color');
            if(!$color_producto->save()){
                var_dump($color_producto->getErrors());exit;
                return false;
            }
        } else {
            $color_producto = ColorProducto::find()->where(['producto_id' => Yii::$app->request->post('id'), 'color_id' => Yii::$app->request->post('color')])->all();
            foreach($color_producto as $color){
                if(!$color->delete()){
                    var_dump($color->getErrors());exit;
                    return false;
                }
            }
        }
        $talla_colores = $this->actionSold(Yii::$app->request->post('id'));
        
        return $this->renderAjax('_talla_colores', [
            'producto' => $producto,
            'talla_colores' => $talla_colores,
            'id' => Yii::$app->request->post('id'),
       ]);
    }
}
