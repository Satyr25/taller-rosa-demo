<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "sold".
 *
 * @property int $id
 * @property int $producto_id
 * @property int $talla_id
 * @property int $color_id
 *
 * @property Color $color
 * @property Producto $producto
 * @property Talla $talla
 */
class Sold extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sold';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['producto_id', 'talla_id', 'color_id'], 'required'],
            [['producto_id', 'talla_id', 'color_id'], 'integer'],
            [['color_id'], 'exist', 'skipOnError' => true, 'targetClass' => Color::className(), 'targetAttribute' => ['color_id' => 'id']],
            [['producto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Producto::className(), 'targetAttribute' => ['producto_id' => 'id']],
            [['talla_id'], 'exist', 'skipOnError' => true, 'targetClass' => Talla::className(), 'targetAttribute' => ['talla_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'producto_id' => 'Producto ID',
            'talla_id' => 'Talla ID',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTalla()
    {
        return $this->hasOne(Talla::className(), ['id' => 'talla_id']);
    }
}
