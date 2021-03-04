<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Newsletter;
use yii\web\Response;

class NewsletterController extends Controller
{
    public function actionAgregar() {
        
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new Newsletter();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                
                Yii::$app->mailer->compose()
                ->setTo($model->email)
                ->setFrom(["ventas@tallerdelarosa.com"=>"Taller de la Rosa"])
                ->setSubject("Gracias por su registro, te tenemos esta oferta")
                ->setHtmlBody(
                    $this->renderPartial('_correo_newsletter',[
                        'model' => $model,
                    ])
                )
                ->send();
                
                
                return [
                    'success' => true,
                    'message' => 'Se ha agregado correctamente al newsletter'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => "Error: ". $model->error
                ];
            }
        } else {
            return [
                'success' => false,
                'message' => "Error: revisa el correo ingresado."
            ];
        }

    }
}
