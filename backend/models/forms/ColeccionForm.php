<?php

namespace backend\models\forms;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

use app\models\Coleccion;
use app\models\ColeccionTr;

/**
 * ContactForm is the model behind the contact form.
 */
class ColeccionForm extends Model
{
    public $coleccion;

    private $transaction;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['coleccion'], 'required'],
            [['coleccion'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'coleccion' => 'Colección',
        ];
    }

    public function guardar(){
        $connection = \Yii::$app->db;
        $this->transaction = $connection->beginTransaction();

        $coleccion = new Coleccion();
        $coleccion->nombre = $this->coleccion;
        if(!$coleccion->save()){
            $this->transaction->rollback();
            return false;
        }

        $this->transaction->commit();
        return true;
    }
    
    public function guardartr(){
        $connection = \Yii::$app->db;
        $this->transaction = $connection->beginTransaction();

        $coleccion = new Coleccion();
        $coleccion->nombre = $this->coleccion;
        $coleccion->tr = 1;
        if(!$coleccion->save()){
            $this->transaction->rollback();
            return false;
        }

        $this->transaction->commit();
        return true;
    }
}
