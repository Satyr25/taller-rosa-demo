<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "divisa".
 *
 * @property int $id
 * @property string $clave
 * @property string $nombre
 *
 * @property Precio[] $precios
 */
class Divisa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'divisa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['clave', 'nombre'], 'required'],
            [['clave'], 'string', 'max' => 5],
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
            'clave' => 'Clave',
            'nombre' => 'Nombre',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrecios()
    {
        return $this->hasMany(Precio::className(), ['divisa_id' => 'id']);
    }
}
