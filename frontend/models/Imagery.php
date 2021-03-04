<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "imagery".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property ImageryImg[] $imageryImgs
 */
class Imagery extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'imagery';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImageryImgs()
    {
        return $this->hasMany(ImageryImg::className(), ['imagery_id' => 'id']);
    }
}
