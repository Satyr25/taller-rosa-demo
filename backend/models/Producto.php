<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "producto".
 *
 * @property int $id
 * @property int $categoria_id
 * @property int $coleccion_id
 * @property int $precio_id
 * @property string $nombre
 * @property string $descripcion
 * @property string $material
 * @property int $created_at
 * @property int $updated_at
 * @property int $status
 *
 * @property Foto[] $fotos
 * @property Categoria $categoria
 * @property Coleccion $coleccion
 * @property Precio $precio
 * @property ProductoPedido[] $productoPedidos
 * @property Variacion[] $variacions
 */
class Producto extends \yii\db\ActiveRecord
{
    public $categoria;
    public $coleccion;
    public $precio;
    public $talla;
    public $color;
    public $foto;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'producto';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['categoria_id', 'coleccion_id', 'nombre', 'status'], 'required'],
            [['categoria_id', 'coleccion_id', 'precio_id', 'created_at', 'updated_at', 'status'], 'integer'],
            [['descripcion'], 'string'],
            [['material'], 'string', 'max' => 255],
            [['nombre'], 'string', 'max' => 256],
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::className(), 'targetAttribute' => ['categoria_id' => 'id']],
            [['coleccion_id'], 'exist', 'skipOnError' => true, 'targetClass' => Coleccion::className(), 'targetAttribute' => ['coleccion_id' => 'id']],
            [['precio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Precio::className(), 'targetAttribute' => ['precio_id' => 'id']],
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
            'categoria_id' => 'Categoria ID',
            'coleccion_id' => 'Coleccion ID',
            'precio_id' => 'Precio ID',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'categoria' => 'Categoría',
            'coleccion' => 'Colección',
            'material' => 'Material',
            'precio' => 'Precio',
            'status' => 'Status'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFotos()
    {
        return $this->hasMany(Foto::className(), ['producto_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(Categoria::className(), ['id' => 'categoria_id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColeccion()
    {
        return $this->hasOne(Coleccion::className(), ['id' => 'coleccion_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrecio()
    {
        return $this->hasOne(Precio::className(), ['id' => 'precio_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductoPedidos()
    {
        return $this->hasMany(ProductoPedido::className(), ['producto_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVariacions()
    {
        return $this->hasMany(Variacion::className(), ['producto_id' => 'id']);
    }

    public function datos($id){
        return $this->find()
            ->select([
                'producto.*', 'categoria.nombre AS categoria',
                'coleccion.nombre AS coleccion', 'precio.precio AS precio'
            ])
            ->join('INNER JOIN', 'precio', 'precio.id = producto.precio_id')
            ->join('INNER JOIN', 'categoria', 'categoria.id = producto.categoria_id')
            ->join('INNER JOIN', 'coleccion', 'coleccion.id = producto.coleccion_id')
            ->where('producto.id='.$id)
            ->one();
    }

    public function tallas($id){
        return $this->find()
            ->select('talla.talla AS talla')
            ->join('INNER JOIN', 'talla_producto', 'talla_producto.producto_id = producto.id')
            ->join('INNER JOIN', 'talla', 'talla.id = talla_producto.talla_id')
            ->where('producto.id='.$id)
            ->all();
    }

    public function colores($id){
        return $this->find()
            ->select('color.color AS color')
            ->join('INNER JOIN', 'color_producto', 'color_producto.producto_id = producto.id')
            ->join('INNER JOIN', 'color', 'color.id = color_producto.color_id')
            ->where('producto.id='.$id)
            ->all();
    }

    public function fotos($id){
        return $this->find()
            ->select('foto.archivo AS foto')
            ->join('INNER JOIN', 'foto', 'foto.producto_id = producto.id')
            ->where('producto.id='.$id)
            ->all();
    }
}
