<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "foto".
 *
 * @property int $id
 * @property string $archivo
 * @property int $producto_id
 * @property int $variacion_id
 *
 * @property Producto $producto
 * @property Variacion $variacion
 */
class Foto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'foto';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['archivo', 'producto_id'], 'required'],
            [['producto_id'], 'integer'],
            [['archivo'], 'string', 'max' => 512],
            [['producto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Producto::className(), 'targetAttribute' => ['producto_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'archivo' => 'Archivo',
            'producto_id' => 'Producto ID',
            'variacion_id' => 'Variacion ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducto()
    {
        return $this->hasOne(Producto::className(), ['id' => 'producto_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVariacion()
    {
        return $this->hasOne(Variacion::className(), ['id' => 'variacion_id']);
    }
}
