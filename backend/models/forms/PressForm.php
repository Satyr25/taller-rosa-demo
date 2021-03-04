<?php

namespace backend\models\forms;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

use app\models\Press;
use app\models\PressImg;
use app\models\PressVideo;

ini_set('upload_max_filesize', '10M');


/**
 * ContactForm is the model behind the contact form.
 */
class PressForm extends Model
{
    public $id;
    public $fecha;
    public $titulo;
    public $texto;
    public $creditos;
    public $imagen;
    public $video_id;
    public $videos;
    public $fotos;
    public $imagen_upd;

    private $transaction;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['titulo','texto', ], 'required'],
            [['texto','creditos','titulo'], 'string'],
            ['imagen', 'each', 'rule' => ['file']],
            ['videos', 'each', 'rule' => ['string']],

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

        
        $press = new Press();
        $press->titulo = $this->titulo;
        $press->creditos = $this->creditos;
        $press->texto = $this->texto;

        if(!$press->save()){
            $this->transaction->rollback();
            return false;
        }
        $this->id = $press->id;
        
        foreach($this->videos as $video){
            if($video != ''){
                
                $press_video = new PressVideo();
                $press_video->video = substr(parse_url($video, PHP_URL_QUERY), 2, 12);
                $press_video->press_id = $this->id;
                if(!$press_video->save()){
                    var_dump($press_video->errors);exit;
                    $this->transaction->rollback();
                    return false;
                }
            }
        } 
        
        if(!$this->guardaFotos()){
            $this->transaction->rollback();
            return false;
        }

        $this->transaction->commit();
        return true;
    }

    public function actualizar($id){
        $connection = \Yii::$app->db;
        $this->transaction = $connection->beginTransaction();

        $press = Press::find()->where('press.id='.$id)->one();
        $press->titulo = $this->titulo;
        $press->creditos = $this->creditos;
        $press->texto = $this->texto;
        $this->id = $press->id;
        
        foreach($this->videos as $video){
            if($video != ''){
                $press_video = new PressVideo();
                $press_video->video = substr(parse_url($video, PHP_URL_QUERY), 2, 12);
                $press_video->press_id = $this->id;
                if(!$press_video->save()){
                    var_dump($press_video->errors);exit;
                    $this->transaction->rollback();
                    return false;
                }
            }
        } 
        
        if(!$this->guardaFotos()){
            $this->transaction->rollback();
            return false;
        }

        if(!$press->save()){
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
                $ruta = Yii::getAlias('@backend/web/images/').'press/'.preg_replace("/[^a-z0-9\.]/", "", strtolower($this->fecha));
                $ruta_frontend = Yii::getAlias('@frontend/web/images/').'press/'.preg_replace("/[^a-z0-9\.]/", "", strtolower($this->fecha));
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
                $foto = new PressImg();
                $foto->imagen = 'press/'.preg_replace("/[^a-z0-9\.]/", "", strtolower($this->fecha)).'/'.$nombre_archivo;
                $foto->press_id = $this->id;
                if(!$foto->save()){
                    var_dump($this->id);exit;
                    return false;
                }
            }
        }
        return true;
    }
    
    public function cargarDatos($id){
        $press = Press::find()->where('press.id='.$id)->one();
        $this->titulo = $press->titulo;
        $this->creditos = $press->creditos;
        $this->texto = $press->texto;
        $this->imagen = $press->pressImgs;
        $this->videos = $press->pressVideos;
    }
}
