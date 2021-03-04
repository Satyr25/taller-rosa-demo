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

use backend\models\forms\ImageryForm;
use app\models\search\ImagerySearch;
use app\models\Imagery;
use app\models\ImageryImg;

/**
 * Site controller
 */
class ImageryController extends Controller
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
                        'actions' => ['index', 'agregar', 'view', 'delete', 'update'],
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
        $searchModel = new ImagerySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // $dataProvider = $searchModel->search();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
        // return $this->render('index');
    }

    public function actionAgregar(){
        $imagery = new ImageryForm();
        if ($imagery->load(Yii::$app->request->post())) {
            if ($imagery->guardar()) {
                Yii::$app->session->setFlash('success', "Producto creado correctamente");
                return $this->redirect(['imagery/']);

            }else{
                Yii::$app->session->setFlash('error', "Ocurrió un error al guardar el producto.");
                return $this->refresh();
            }
        }
        return $this->render('agregar',[
            'imagery' => $imagery,
            // 'colecciones' => ArrayHelper::map(Imagery::find()->all(), 'id', 'nombre'),
        ]);
    }

    public function actionDelete($id)
    {
        $imagery = Imagery::find()->where('imagery.id='.$id)->one();
        $imagery->delete();

        return $this->redirect(['index']);
    }

    public function actionView($id){
        $nombre = Imagery::find()->where('imagery.id='.$id)->one();
        $imagenes = ImageryImg::find()->where('imagery_img.imagery_id='.$id)->all();
        return $this->render('view',[
            'nombre' => $nombre,
            'imagenes' => $imagenes,
        ]);
    }

    public function actionUpdate($id){
        $imagery = new ImageryForm();
        if ($imagery->load(Yii::$app->request->post())) {
            if(isset(Yii::$app->request->post()['ImageryForm']['fotos_elim']))
            {
                $imagery->fotos_elim = Yii::$app->request->post()['ImageryForm']['fotos_elim'];
            }

            if ($imagery->actualizar($id)) {
                Yii::$app->session->setFlash('success', "Producto creado correctamente");
                return $this->redirect(['imagery/']);

            }else{
                Yii::$app->session->setFlash('error', "Ocurrió un error al guardar el producto.");
                return $this->refresh();
            }
        }

        $imagery->cargarDatos($id);

        return $this->render('update',[
            'imagery' => $imagery,
            // 'colecciones' => ArrayHelper::map(Imagery::find()->all(), 'id', 'nombre'),
        ]);
    }

}
