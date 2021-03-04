<?php

namespace frontend\models;

use Yii;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "pedido".
 *
 * @property int $id
 * @property int $cliente_id
 * @property int $created_at
 * @property int $updated_at
 * @property int $datos_pago_id
 *
 * @property Cliente $cliente
 * @property DatosPago $datosPago
 * @property ProductoPedido[] $productoPedidos
 */
class Pedido extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pedido';
    }

    public function behaviors(){
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cliente_id'], 'required'],
            [['cliente_id', 'created_at', 'updated_at', 'datos_pago_id'], 'integer'],
            [['cliente_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cliente::className(), 'targetAttribute' => ['cliente_id' => 'id']],
            [['datos_pago_id'], 'exist', 'skipOnError' => true, 'targetClass' => DatosPago::className(), 'targetAttribute' => ['datos_pago_id' => 'id']],
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
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'datos_pago_id' => 'Datos Pago ID',
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
    public function getDatosPago()
    {
        return $this->hasOne(DatosPago::className(), ['id' => 'datos_pago_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductoPedidos()
    {
        return $this->hasMany(ProductoPedido::className(), ['pedido_id' => 'id']);
    }
}
