<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "producto_pedido".
 *
 * @property int $id
 * @property int $pedido_id
 * @property int $producto_id
 * @property int $talla_id
 * @property int $color_id
 * @property int $cantidad
 * @property string $total
 *
 * @property Color $color
 * @property Pedido $pedido
 * @property Producto $producto
 * @property Talla $talla
 */
class ProductoPedido extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'producto_pedido';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pedido_id', 'producto_id', 'talla_id', 'color_id', 'total'], 'required'],
            [['pedido_id', 'producto_id', 'talla_id', 'color_id', 'cantidad'], 'integer'],
            [['total'], 'number'],
            [['color_id'], 'exist', 'skipOnError' => true, 'targetClass' => Color::className(), 'targetAttribute' => ['color_id' => 'id']],
            [['pedido_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pedido::className(), 'targetAttribute' => ['pedido_id' => 'id']],
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
            'pedido_id' => 'Pedido ID',
            'producto_id' => 'Producto ID',
            'talla_id' => 'Talla ID',
            'color_id' => 'Color ID',
            'cantidad' => 'Cantidad',
            'total' => 'Total',
        ];
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
    public function getPedido()
    {
        return $this->hasOne(Pedido::className(), ['id' => 'pedido_id']);
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
