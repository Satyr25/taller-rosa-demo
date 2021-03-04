<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "precio".
 *
 * @property int $id
 * @property int $divisa_id
 * @property string $precio
 *
 * @property Divisa $divisa
 * @property Producto[] $productos
 * @property Variacion[] $variacions
 */
class Precio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'precio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['divisa_id', 'precio'], 'required'],
            [['divisa_id'], 'integer'],
            [['precio'], 'number'],
            [['divisa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Divisa::className(), 'targetAttribute' => ['divisa_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'divisa_id' => 'Divisa ID',
            'precio' => 'Precio',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDivisa()
    {
        return $this->hasOne(Divisa::className(), ['id' => 'divisa_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductos()
    {
        return $this->hasMany(Producto::className(), ['precio_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVariacions()
    {
        return $this->hasMany(Variacion::className(), ['precio_id' => 'id']);
    }
}
