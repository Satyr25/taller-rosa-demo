<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Press;

/**
 * ClienteSearch represents the model behind the search form about `common\models\Cliente`.
 */
class PressSearch extends Press
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           [['id', 'created_at',], 'integer'],
           [['titulo',], 'safe'],
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
        $query = Press::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

       $this->load($params);

       if (!$this->validate()) {
           // uncomment the following line if you do not want to return any records when validation fails
           // $query->where('0=1');
           return $dataProvider;
       }

       // grid filtering conditions
       // $query->andFilterWhere([
       //     'id' => $this->id,
       //     'created_at' => $this->created_at,
       //     'updated_at' => $this->updated_at,
       // ]);

       // $query->andFilterWhere(['like', 'titulo', $this->titulo])
       //     ->andFilterWhere(['like', 'texto', $this->texto])
       //     ->andFilterWhere(['like', 'imagen', $this->imagen])
       //     ->andFilterWhere(['like', 'creditos', $this->creditos]);

       return $dataProvider;
    }
}
