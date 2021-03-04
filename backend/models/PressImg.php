<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "press_img".
 *
 * @property int $id
 * @property string $imagen
 * @property int $press_id
 *
 * @property Press $press
 */
class PressImg extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'press_img';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['imagen', 'press_id'], 'required'],
            [['press_id'], 'integer'],
            [['imagen'], 'string', 'max' => 255],
            [['press_id'], 'exist', 'skipOnError' => true, 'targetClass' => Press::className(), 'targetAttribute' => ['press_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'imagen' => 'Imagen',
            'press_id' => 'Press ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPress()
    {
        return $this->hasOne(Press::className(), ['id' => 'press_id']);
    }
}
