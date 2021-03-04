<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Producto;

/**
 * ClienteSearch represents the model behind the search form about `common\models\Cliente`.
 */
class ProductoSearch extends Producto
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'categoria_id', 'coleccion_id', 'status'], 'integer'],
            [['precio'], 'double'],
            [['nombre'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Producto::find()
            ->select([
                'producto.id AS id','producto.status AS status', 'producto.nombre AS nombre',
                'categoria.nombre AS categoria', 'coleccion.nombre AS coleccion',
                'precio.precio AS precio'
            ])
            ->join('INNER JOIN', 'precio', 'precio.id = producto.precio_id')
            ->join('INNER JOIN', 'categoria', 'categoria.id = producto.categoria_id')
            ->join('INNER JOIN', 'coleccion', 'coleccion.id = producto.coleccion_id')
            ->where('producto.status != 0')
            ->andwhere('categoria.nombre != "Blancos"');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->orderBy('producto.created_at DESC');

        return $dataProvider;
    }
    
    public function searchtr($params)
    {
        $query = Producto::find()
            ->select([
                'producto.id AS id','producto.status AS status', 'producto.nombre AS nombre',
                'categoria.nombre AS categoria', 'coleccion.nombre AS coleccion',
                'precio.precio AS precio'
            ])
            ->join('INNER JOIN', 'precio', 'precio.id = producto.precio_id')
            ->join('INNER JOIN', 'categoria', 'categoria.id = producto.categoria_id')
            ->join('INNER JOIN', 'coleccion', 'coleccion.id = producto.coleccion_id')
            ->where('producto.status != 0')
            ->andwhere('categoria.nombre = "Blancos"');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->orderBy('producto.created_at DESC');

        return $dataProvider;
    }
}
