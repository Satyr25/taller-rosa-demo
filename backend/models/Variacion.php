<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "variacion".
 *
 * @property int $id
 * @property int $producto_id
 * @property int $talla_id
 * @property int $color_id
 * @property int $precio_id
 * @property int $cantidad
 *
 * @property Foto[] $fotos
 * @property ProductoPedido[] $productoPedidos
 * @property Color $color
 * @property Precio $precio
 * @property Producto $producto
 * @property Talla $talla
 */
class Variacion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'variacion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['producto_id', 'talla_id', 'color_id'], 'required'],
            [['producto_id', 'talla_id', 'color_id', 'precio_id', 'cantidad'], 'integer'],
            [['color_id'], 'exist', 'skipOnError' => true, 'targetClass' => Color::className(), 'targetAttribute' => ['color_id' => 'id']],
            [['precio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Precio::className(), 'targetAttribute' => ['precio_id' => 'id']],
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
            'color_id' => 'Color ID',
            'precio_id' => 'Precio ID',
            'cantidad' => 'Cantidad',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFotos()
    {
        return $this->hasMany(Foto::className(), ['variacion_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductoPedidos()
    {
        return $this->hasMany(ProductoPedido::className(), ['variacion_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColor()
    {
        return $this->hasOne(Color::className(), ['id' => 'color_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrecio()
    {
        return $this->hasOne(Precio::className(), ['id' => 'precio_id']);
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
