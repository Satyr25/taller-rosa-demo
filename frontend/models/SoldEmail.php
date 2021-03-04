<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "sold_email".
 *
 * @property int $id
 * @property string $email
 * @property int $producto_id
 * @property int $talla_id
 * @property int $color_id
 * @property int $enviado
 *
 * @property Color $color
 * @property Producto $producto
 * @property Talla $talla
 */
class SoldEmail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sold_email';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'producto_id', 'talla_id', 'color_id'], 'required'],
            [['producto_id', 'talla_id', 'color_id', 'enviado'], 'integer'],
            [['email'], 'string', 'max' => 255],
            ['email', 'email'],
            ['email', 'trim'],
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
            'email' => 'Email',
            'producto_id' => 'Producto ID',
            'talla_id' => 'Talla ID',
            'color_id' => 'Color ID',
            'enviado' => 'Enviado',
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
