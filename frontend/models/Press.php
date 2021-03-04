<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "press".
 *
 * @property int $id
 * @property string $titulo
 * @property string $texto
 * @property string $imagen
 * @property string $creditos
 * @property int $created_at
 * @property int $updated_at
 */
class Press extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'press';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['titulo', 'texto', 'created_at', 'updated_at'], 'required'],
            [['texto'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['titulo'], 'string', 'max' => 128],
            [['imagen'], 'string', 'max' => 512],
            [['creditos'], 'string', 'max' => 256],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titulo' => 'Titulo',
            'texto' => 'Texto',
            'imagen' => 'Imagen',
            'creditos' => 'Creditos',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
        
   public function getPressImgs()
   {
       return $this->hasMany(PressImg::className(), ['press_id' => 'id']);
   }
   public function getPressVideos()
   {
       return $this->hasMany(PressVideo::className(), ['press_id' => 'id']);
   }
}
