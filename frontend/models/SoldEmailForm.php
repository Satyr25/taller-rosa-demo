<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class SoldEmailForm extends Model
{
    public $producto_id;
    public $talla_id;
    public $color_id;
    public $email;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['producto_id', 'email', 'talla_id', 'color_id'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
        ];
    }
}
