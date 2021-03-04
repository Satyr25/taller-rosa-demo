<?php

namespace frontend\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "carrito".
 *
 * @property int $id
 * @property int $cliente_id
 * @property string $cookie_id
 * @property double $total
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Cliente $cliente
 * @property ProductoCarrito[] $productoCarritos
 */
class Carrito extends \yii\db\ActiveRecord
{
    public $cantidad;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'carrito';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cliente_id', 'created_at', 'updated_at'], 'integer'],
            [['total'], 'number'],
            [['cookie_id'], 'string', 'max' => 45],
        ];
    }

    public function behaviors(){
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cliente_id' => 'Cliente ID',
            'cookie_id' => 'Cookie ID',
            'total' => 'Total',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCliente()
    {
        return $this->hasOne(Cliente::className(), ['id' => 'cliente_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductoCarritos()
    {
        return $this->hasMany(ProductoCarrito::className(), ['carrito_id' => 'id']);
    }

    public function idCarrito($cookie_id){
        $carrito = Carrito::find()->where('cookie_id="'.$cookie_id.'"')->one();
        if($carrito)
            return $carrito->id;
        $this->cookie_id = $cookie_id;
        if(!$this->save())
            return false;
        return $this->id;

    }
}
