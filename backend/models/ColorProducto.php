<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "color_producto".
 *
 * @property int $id
 * @property int $producto_id
 * @property int $color_id
 *
 * @property Color $color
 * @property Producto $producto
 */
class ColorProducto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'color_producto';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['producto_id', 'color_id'], 'required'],
            [['producto_id', 'color_id'], 'integer'],
            [['color_id'], 'exist', 'skipOnError' => true, 'targetClass' => Color::className(), 'targetAttribute' => ['color_id' => 'id']],
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
            'producto_id' => 'Producto ID',
            'color_id' => 'Color ID',
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
    public function getProducto()
    {
        return $this->hasOne(Producto::className(), ['id' => 'producto_id']);
    }
}
