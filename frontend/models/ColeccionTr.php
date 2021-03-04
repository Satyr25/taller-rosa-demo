<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "coleccion_tr".
 *
 * @property int $id
 * @property string $nombre
 * @property int $status
 */
class ColeccionTr extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'coleccion_tr';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['status'], 'integer'],
            [['nombre'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'status' => 'Status',
        ];
    }
}
