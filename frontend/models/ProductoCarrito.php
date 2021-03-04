<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "producto_carrito".
 *
 * @property int $id
 * @property int $carrito_id
 * @property int $producto_id
 * @property int $talla_id
 * @property int $color_id
 * @property int $cantidad
 *
 * @property Carrito $carrito
 * @property Color $color
 * @property Producto $producto
 * @property Talla $talla
 */
class ProductoCarrito extends \yii\db\ActiveRecord
{
    public $nombre;
    public $producto;
    public $producto_carrito;
    public $talla;
    public $color;
    public $precio;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'producto_carrito';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['carrito_id', 'producto_id', 'talla_id', 'color_id', 'cantidad'], 'required'],
            [['carrito_id', 'producto_id', 'talla_id', 'color_id', 'cantidad'], 'integer'],
            [['carrito_id'], 'exist', 'skipOnError' => true, 'targetClass' => Carrito::className(), 'targetAttribute' => ['carrito_id' => 'id']],
            [['color_id'], 'exist', 'skipOnError' => true, 'targetClass' => Color::className(), 'targetAttribute' => ['color_id' => 'id']],
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
            'carrito_id' => 'Carrito ID',
            'producto_id' => 'Producto ID',
            'talla_id' => 'Talla ID',
            'color_id' => 'Color ID',
            'cantidad' => 'Cantidad',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarrito()
    {
        return $this->hasOne(Carrito::className(), ['id' => 'carrito_id']);
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
