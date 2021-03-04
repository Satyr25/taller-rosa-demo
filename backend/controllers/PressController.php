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

use backend\models\forms\PressForm;
use app\models\search\PressSearch;
use app\models\Press;
use app\models\PressImg;
use app\models\PressVideo;

/**
 * Site controller
 */
class PressController extends Controller
{
    private $transaction;
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
                        'actions' => ['index', 'agregar', 'view', 'delete', 'update', 'deleteimg', 'deletevideo'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
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
        $searchModel = new PressSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // $dataProvider = $searchModel->search();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
        // return $this->render('index');
    }

    public function actionAgregar(){
        $press = new PressForm();
//        var_dump(Yii::$app->request->post());exit;
        if ($press->load(Yii::$app->request->post())) {
            if ($press->guardar()) {
                Yii::$app->session->setFlash('success', "Producto creado correctamente");
                return $this->redirect(['press/']);

            }else{
                Yii::$app->session->setFlash('error', "Ocurrió un error al guardar el producto.");
                return $this->refresh();
            }
        }
        return $this->render('agregar',[
            'press' => $press,
        ]);
    }

    public function actionUpdate($id){
        $press = new PressForm();
        if ($press->load(Yii::$app->request->post())) {
            if ($press->actualizar($id)) {
                Yii::$app->session->setFlash('success', "Producto creado correctamente");
                return $this->redirect(['press/']);

            }else{
                Yii::$app->session->setFlash('error', "Ocurrió un error al guardar el producto.");
                return $this->refresh();
            }
        }

        $press->cargarDatos($id);
        return $this->render('update',[
            'press' => $press,
        ]);
    }

    public function actionView($id){
        $press = Press::find()->where('press.id='.$id)->one();
        return $this->render('view',[
            'press'=>$press
        ]);
    }

    public function actionDelete($id)
    {
        $connection = \Yii::$app->db;
        $this->transaction = $connection->beginTransaction();
        
        $press_img = PressImg::find()->where('press_img.press_id='.$id)->all();
        foreach( $press_img as $imagen ){
            if (!$imagen->delete()){
                $this->transaction->rollback();
                Yii::$app->session->setFlash('error', 'No se pudo eliminar las imagenes relacionadas');
            }
        }
        $press = Press::find()->where('press.id='.$id)->one();
        if (!$press->delete()){
            $this->transaction->rollback();
            Yii::$app->session->setFlash('error', 'No se pudo eliminar la entrada');
        }
        $this->transaction->commit();
        Yii::$app->session->setFlash('success', 'Se ha eliminado correctamente la entrada');
        
        return $this->redirect(['index']);
    }
    public function actionDeleteimg(){
        $id = Yii::$app->request->post('id');
        $imagen = PressImg::find()->where(['id' => $id])->one();
        if (!$imagen->delete()){
            return false;
        }
        return true;
    }
    public function actionDeletevideo(){
        $id = Yii::$app->request->post('id');
        $imagen = PressVideo::find()->where(['id' => $id])->one();
        if (!$imagen->delete()){
            return false;
        }
        return true;
    }

}
