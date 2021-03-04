<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Coleccion;

/**
 * ClienteSearch represents the model behind the search form about `common\models\Cliente`.
 */
class ColeccionSearch extends Coleccion
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'tr'], 'integer'],
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
        $query = Coleccion::find()
            ->where(['tr' => 0, 'status' => 1]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        return $dataProvider;
    }
    
    public function searchtr($params)
    {
        $query = Coleccion::find()
            ->where(['tr' => 1, 'status' => 1]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        return $dataProvider;
    }
    
}
