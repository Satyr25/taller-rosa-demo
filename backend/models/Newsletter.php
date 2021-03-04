<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "newsletter".
 *
 * @property int $id
 * @property string $nombre
 * @property string $email
 * @property int $created_at
 */
class Newsletter extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'newsletter';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'email'], 'required'],
            [['created_at'], 'integer'],
            [['nombre', 'email'], 'string', 'max' => 255],
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
            'email' => 'Email',
            'created_at' => 'Created At',
        ];
    }
}
