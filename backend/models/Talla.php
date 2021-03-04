<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "talla".
 *
 * @property int $id
 * @property string $talla
 *
 * @property Variacion[] $variacions
 */
class Talla extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'talla';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['talla'], 'required'],
            [['talla'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'talla' => 'Talla',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVariacions()
    {
        return $this->hasMany(Variacion::className(), ['talla_id' => 'id']);
    }
}
