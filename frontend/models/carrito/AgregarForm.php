<?php

namespace frontend\models\carrito;

use Yii;
use yii\base\Model;

/**
 * Formulario para agregar producto a carrito
 */
class AgregarForm extends Model
{
    public $producto_id;
    public $talla_id;
    public $color_id;
    public $cantidad;

    public function rules()
    {
        return [
            [['producto_id', 'talla_id', 'color_id', 'cantidad'], 'required'],
            [['producto_id', 'talla_id', 'color_id', 'cantidad'], 'integer'],
        ];
    }

    public function agregar(){

    }
}
