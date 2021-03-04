<?php

namespace frontend\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "cliente".
 *
 * @property int $id
 * @property string $nombre
 * @property string $apellidos
 * @property string $correo
 * @property string $telefono
 * @property int $created_at
 * @property int $updated_at
 * @property string $calle
 * @property string $num_int
 * @property string $num_ext
 * @property string $colonia
 * @property string $municipio
 * @property string $estado
 * @property int $cp
 *
 * @property Carrito[] $carritos
 * @property Pedido[] $pedidos
 */
class Cliente extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cliente';
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
            [['nombre', 'apellidos', 'correo','calle', 'num_ext', 'colonia', 'municipio', 'estado', 'cp'], 'required'],
            [['created_at', 'updated_at', 'cp'], 'integer'],
            [['nombre', 'apellidos', 'correo', 'telefono'], 'string', 'max' => 128],
            [['calle', 'num_int', 'num_ext', 'colonia', 'municipio', 'estado'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'apellidos' => 'Apellidos',
            'correo' => 'Correo',
            'telefono' => 'Telefono',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'calle' => 'Calle',
            'num_int' => 'Num Int',
            'num_ext' => 'Num Ext',
            'colonia' => 'Colonia',
            'municipio' => 'Municipio',
            'estado' => 'Estado',
            'cp' => 'Cp',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarritos()
    {
        return $this->hasMany(Carrito::className(), ['cliente_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPedidos()
    {
        return $this->hasMany(Pedido::className(), ['cliente_id' => 'id']);
    }
}
