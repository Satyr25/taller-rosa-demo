<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "color".
 *
 * @property int $id
 * @property string $color
 *
 * @property ColorProducto[] $colorProductos
 * @property ProductoCarrito[] $productoCarritos
 * @property ProductoPedido[] $productoPedidos
 * @property Variacion[] $variacions
 */
class Color extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'color';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['color'], 'required'],
            [['color'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'color' => 'Color',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColorProductos()
    {
        return $this->hasMany(ColorProducto::className(), ['color_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductoCarritos()
    {
        return $this->hasMany(ProductoCarrito::className(), ['color_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductoPedidos()
    {
        return $this->hasMany(ProductoPedido::className(), ['color_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVariacions()
    {
        return $this->hasMany(Variacion::className(), ['color_id' => 'id']);
    }
}
