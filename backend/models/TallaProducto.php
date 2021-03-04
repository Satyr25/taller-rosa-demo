<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "talla_producto".
 *
 * @property int $id
 * @property int $producto_id
 * @property int $talla_id
 *
 * @property Producto $producto
 * @property Talla $talla
 */
class TallaProducto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'talla_producto';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['producto_id', 'talla_id'], 'required'],
            [['producto_id', 'talla_id'], 'integer'],
            [['producto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Producto::className(), 'targetAttribute' => ['producto_id' => 'id']],
            [['talla_id'], 'exist', 'skipOnError' => true, 'targetClass' => Talla::className(), 'targetAttribute' => ['talla_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'producto_id' => 'Producto ID',
            'talla_id' => 'Talla ID',
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
    public function getTalla()
    {
        return $this->hasOne(Talla::className(), ['id' => 'talla_id']);
    }
}
