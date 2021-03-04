<?php

namespace backend\models\forms;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

use app\models\Imagery;
use app\models\ImageryImg;


/**
 * ContactForm is the model behind the contact form.
 */
class ImageryForm extends Model
{
    public $id;
    public $coleccion;
    public $fotos;
    public $fotos_upd;
    public $fotos_elim;
    private $transaction;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['coleccion',], 'required'],
            [['coleccion'], 'string'],
            ['fotos', 'each', 'rule' => ['file']],

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

        $imagery = new Imagery();
        $imagery->nombre = $this->coleccion;
        if(!$imagery->save()){
            $this->transaction->rollback();
            return false;
        }

        $this->id = $imagery->id;

        if(!$this->guardaFotos()){
            $this->transaction->rollback();
            return false;
        }

        $this->transaction->commit();
        return true;
    }

    public function guardaFotos(){
        $this->fotos = UploadedFile::getInstances($this, 'fotos');
        foreach($this->fotos as $i => $foto){
            if($foto){
                $ruta = Yii::getAlias('@backend/web/images/').'imagery/'.preg_replace("/[^a-z0-9\.]/", "", strtolower($this->coleccion));
                $ruta_frontend = Yii::getAlias('@frontend/web/images/').'imagery/'.preg_replace("/[^a-z0-9\.]/", "", strtolower($this->coleccion));
                if(!file_exists($ruta)){
                    if(!mkdir($ruta)){
                        return false;
                    }
                }

                if(!file_exists($ruta_frontend)){
                    if(!mkdir($ruta_frontend)){
                        return false;
                    }
                }
                $guardado = false;
                while(!$guardado){
                    $timestamp = time();
                    $nombre_archivo = $timestamp.preg_replace("/[^a-z0-9\.]/", "", strtolower($foto->name));
                    if(!file_exists($ruta.'/'.$nombre_archivo)){
                        if(!$foto->saveAs($ruta.'/'.$nombre_archivo, false )){
                            return false;
                        }
                        if(!$foto->saveAs($ruta_frontend.'/'.$nombre_archivo, false )){
                            return false;
                        }
                        $guardado = true;
                    }
                }
                $foto = new ImageryImg();
                $foto->foto = 'imagery/'.preg_replace("/[^a-z0-9\.]/", "", strtolower($this->coleccion)).'/'.$nombre_archivo;
                $foto->imagery_id = $this->id;
                if(!$foto->save()){
                    return false;
                }
            }
        }
        return true;
    }

    public function actualizar($id){
        $connection = \Yii::$app->db;
        $this->transaction = $connection->beginTransaction();

        $imagery = Imagery::find()->where('imagery.id='.$id)->one();
        $this->id = $imagery->id;
        if($imagery->nombre =! $this->coleccion)
        {
            $imagery->nombre = $this->coleccion;
            if(!$imagery->update()){
                $this->transaction->rollback();
                return false;
            }
        }

        if(isset($this->fotos_elim))
        {
            if(!$this->actualizaFotos()){
                $this->transaction->rollback();
                return false;
            }
        }

        if(isset($this->fotos))
        {
            if(!$this->guardaFotos()){

                $this->transaction->rollback();
                return false;
            }
        }

        $this->transaction->commit();
        return true;
    }

    public function actualizaFotos()
    {
        foreach($this->fotos_elim as $id_foto)
        {
            if(!ImageryImg::find()->where('imagery_img.id='.$id_foto)->one()->delete())
            {
                return false;
            }
        }
        return true;
    }

    public function cargarDatos($id)
    {
        $imagery = Imagery::find()->where('imagery.id='.$id)->one();
        $this->coleccion = $imagery->nombre;
        $fotos = ImageryImg::find()->where('imagery_img.imagery_id='.$id)->all();
        $this->fotos_upd = $fotos;
    }
}
