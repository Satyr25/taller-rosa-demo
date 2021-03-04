<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "imagery_img".
 *
 * @property int $id
 * @property string $foto
 * @property int $imagery_id
 *
 * @property Imagery $imagery
 */
class ImageryImg extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'imagery_img';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['imagery_id'], 'required'],
            [['imagery_id'], 'integer'],
            [['foto'], 'string', 'max' => 512],
            [['imagery_id'], 'exist', 'skipOnError' => true, 'targetClass' => Imagery::className(), 'targetAttribute' => ['imagery_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'foto' => 'Foto',
            'imagery_id' => 'Imagery ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImagery()
    {
        return $this->hasOne(Imagery::className(), ['id' => 'imagery_id']);
    }
}
