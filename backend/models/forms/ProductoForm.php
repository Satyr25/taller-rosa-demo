<?php

namespace backend\models\forms;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

use app\models\Producto;
use app\models\Precio;
use app\models\Divisa;
use app\models\Foto;
use app\models\Talla;
use app\models\Color;
use app\models\Sold;
use app\models\TallaProducto;
use app\models\ColorProducto;
use app\models\Categoria;



/**
 * ContactForm is the model behind the contact form.
 */
class ProductoForm extends Model
{
    public $id;
    public $categoria;
    public $categoria_nombre;
    public $coleccion;
    public $nombre;
    public $descripcion;
    public $predescripcion;
    public $precio;
    public $colores;
    public $tallas;
    public $talla_colores;
    public $material;
    public $fotos;
    public $fotos_upd;
    public $fotos_elim;
    public $status;
    public $sold;

    private $transaction;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'descripcion', 'predescripcion', 'precio', 'categoria', 'coleccion', 'tallas', 'colores', 'status'], 'required'],
            [['nombre', 'descripcion', 'predescripcion', 'status', 'material'], 'string'],
            [['categoria', 'coleccion'], 'integer'],
            [['precio'], 'double'],
            ['colores', 'each', 'rule' => ['integer']],
            ['tallas', 'each', 'rule' => ['integer']],
            ['sold', 'each', 'rule' => ['integer']],
            ['fotos', 'each', 'rule' => ['file']],

        ];
    }

    public function attributeLabels()
    {
        return [
            'categoria' => 'Categoría',
            'coleccion' => 'Colección',
            'precio' => 'Precio',
            'nombre' => 'Nombre del producto',
            'descripcion' => 'Descripción',
            'material' => 'Material',
            'sold' => 'Sold Out',
        ];
    }

    public function guardar(){
        $connection = \Yii::$app->db;
        $this->transaction = $connection->beginTransaction();

        $mxn = Divisa::find()->where('clave="MXN"')->one();
        $precio = new Precio();
        $precio->divisa_id = $mxn->id;
        $precio->precio = $this->precio;
        if(!$precio->save()){
            $this->transaction->rollback();
            return false;
        }

        $producto = new Producto();
        $producto->status = 1;
        $producto->nombre = $this->nombre;
        $producto->descripcion = $this->descripcion;
        $producto->predescripcion = $this->predescripcion;
        $producto->categoria_id = $this->categoria;
        $producto->coleccion_id = $this->coleccion;
        $producto->precio_id = $precio->id;
        $producto->material = $this->material;
        if(!$producto->save()){
            $this->transaction->rollback();
            return false;
        }

        $this->id = $producto->id;

        if(!$this->guardaTallas()){
            $this->transaction->rollback();
            return false;
        }

        if(!$this->guardaColores()){
            $this->transaction->rollback();
            return false;
        }

        if(!$this->guardaFotos()){
            $this->transaction->rollback();
            return false;
        }

        $this->transaction->commit();
        return true;
    }

    public function actualizar($id){
        $connection = \Yii::$app->db;
        $this->transaction = $connection->beginTransaction();

        $mxn = Divisa::find()->where('clave="MXN"')->one();
        $precio = new Precio();
        $precio->divisa_id = $mxn->id;
        $precio->precio = $this->precio;
        if(!$precio->save()){
            $this->transaction->rollback();
            return false;
        }

        $producto = Producto::find()->where('producto.id='.$id)->one();
        $this->id = $producto->id;
        $producto->nombre = $this->nombre;
        $producto->status = $this->status;
        $producto->descripcion = $this->descripcion;
        $producto->predescripcion = $this->predescripcion;
        $producto->categoria_id = $this->categoria;
        $producto->coleccion_id = $this->coleccion;
        $producto->material = $this->material;
        $producto->precio_id = $precio->id;
        
        if(!$producto->update()){
            $this->transaction->rollback();
            return false;
        }

        if(!$this->actualizaTallas()){
            $this->transaction->rollback();
            return false;
        }

        if(!$this->actualizaColores()){
            $this->transaction->rollback();
            return false;
        }

        if(!$this->guardaSold($id)){
            $this->transaction->rollback();
            return false;
        }  
        
        if(isset($this->fotos_elim))
        {
            if(!$this->actualizaFotos()){
                $this->transaction->rollback();
                return false;
            }
        }

        if(isset($this->fotos))
        {
            if(!$this->guardaFotos()){
                $this->transaction->rollback();
                return false;
            }
        }

        $this->transaction->commit();
        return true;
    }

    public function actualizaFotos()
    {
        foreach($this->fotos_elim as $id_foto)
        {
            if(!Foto::find()->where('foto.id='.$id_foto)->one()->delete())
            {
                return false;
            }
        }
        return true;
    }

    public function guardaFotos(){
        $this->fotos = UploadedFile::getInstances($this, 'fotos');

        foreach($this->fotos as $i => $foto){
            if($foto){
                $ruta = Yii::getAlias('@backend/web/images/').'productos/'.preg_replace("/[^a-z0-9\.]/", "", strtolower($this->nombre));
                $ruta_frontend = Yii::getAlias('@frontend/web/images/').'productos/'.preg_replace("/[^a-z0-9\.]/", "", strtolower($this->nombre));
                if(!file_exists($ruta)){
                    if(!mkdir($ruta)){
                        return false;
                    }
                }

                if(!file_exists($ruta_frontend)){
                    if(!mkdir($ruta_frontend)){
                        return false;
                    }
                }
                $guardado = false;
                while(!$guardado){
                    $timestamp = time();
                    $nombre_archivo = $timestamp.preg_replace("/[^a-z0-9\.]/", "", strtolower($foto->name));
                    if(!file_exists($ruta.'/'.$nombre_archivo)){
                        if(!$foto->saveAs($ruta.'/'.$nombre_archivo, false )){
                            return false;
                        }
                        if(!$foto->saveAs($ruta_frontend.'/'.$nombre_archivo, false )){
                            return false;
                        }
                        $guardado = true;
                    }
                }
                $foto = new Foto();
                $foto->archivo = 'productos/'.preg_replace("/[^a-z0-9\.]/", "", strtolower($this->nombre)).'/'.$nombre_archivo;
                $foto->producto_id = $this->id;
                if(!$foto->save()){
                    return false;
                }
            }
        }
        return true;
    }

    private function guardaTallas(){
        
        $tallas = TallaProducto::find()->where('talla_producto.producto_id='.$this->id)->all();
        if($tallas){
            foreach($tallas as $talla)
            {
                $talla->delete();
            }
        }
        foreach($this->tallas as $talla){
            $talla_producto = new TallaProducto();
            $talla_producto->talla_id = $talla;
            $talla_producto->producto_id = $this->id;
            if(!$talla_producto->save()){
                return false;
            }
        }
        return true;
    }

    private function actualizaTallas(){
        $tallas = TallaProducto::find()->where('talla_producto.producto_id='.$this->id)->all();
        foreach($tallas as $talla)
        {
            $talla->delete();
        }
        foreach($this->tallas as $talla){
            $talla_producto = new TallaProducto();
            $talla_producto->talla_id = $talla;
            $talla_producto->producto_id = $this->id;
            if(!$talla_producto->save()){
                return false;
            }
        }
        return true;
    }

    private function guardaColores(){
        foreach($this->colores as $color){
            $color_producto = new ColorProducto();
            $color_producto->color_id = $color;
            $color_producto->producto_id = $this->id;
            if(!$color_producto->save()){
                return false;
            }
        }
        return true;
    }

    private function actualizaColores(){
        $colores = ColorProducto::find()->where('color_producto.producto_id='.$this->id)->all();
        foreach($colores as $color)
        {
            $color->delete();
        }
        foreach($this->colores as $color){
            $color_producto = new ColorProducto();
            $color_producto->color_id = $color;
            $color_producto->producto_id = $this->id;
            if(!$color_producto->save()){
                return false;
            }
        }
        return true;
    }

    public function cargarDatos($id){
        $producto = Producto::find()->where('producto.id='.$id)->one();

        $this->id = $id;
        $this->categoria = $producto->categoria_id;
        $this->coleccion = $producto->coleccion_id;
        $this->nombre = $producto->nombre;
        $this->status = $producto->status;
        $this->predescripcion = $producto->predescripcion;
        $this->descripcion = $producto->descripcion;
        $this->material = $producto->material;
        
        $this->categoria_nombre = (Categoria::find()->where(['id' => $producto->categoria_id])->one())->nombre;
        
        $precio = Precio::find()->where('precio.id='.$producto->precio_id)->one();
        $this->precio = $precio->precio;
        $colores = ColorProducto::find()->where('color_producto.producto_id='.$id)->all();
        $this->colores=array();
        foreach($colores as $color)
        {
            array_push($this->colores, $color->color_id);
        }
        $tallas = TallaProducto::find()->where('talla_producto.producto_id='.$id)->all();
        $this->tallas=array();
        foreach($tallas as $talla)
        {
            array_push($this->tallas, $talla->talla_id);
        }
        
        $this->talla_colores = Sold::find()->where(['producto_id' => $id])->all();
        
        $fotos = Foto::find()->where('foto.producto_id='.$id)->all();
        $this->fotos_upd= $fotos;
    }
    
    
    public function guardaSold($id){
        
        $delete_solds = Sold::find()->where(['producto_id' => $id])->all();
        if($delete_solds){
            foreach ($delete_solds as $delete_sold){
                if (!$delete_sold->delete()){
                    return false;
                }
            }
        }
        foreach($this->sold as $talla => $colores){
            if ($colores){
                foreach($colores as $color){
                    $add_sold = new Sold();
                    $add_sold->producto_id = $id;
                    $add_sold->talla_id = $talla;
                    $add_sold->color_id = $color;
                    if(!$add_sold->save()){
                        return false;
                    }
                }
            }
        }  
        return true;
    }
    
    
}
