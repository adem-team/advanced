<?php

namespace lukisongroup\master\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\master\models\DraftLayer;

/**
 * DraftLayerSearch represents the model behind the search form about `lukisongroup\master\models\DraftLayer`.
 */
class DraftLayerSearch extends DraftLayer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['LAYER_ID', 'JEDA_PEKAN'], 'integer'],
            [['LAYER_NM', 'DCRIPT'], 'safe'],
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
        $query = DraftLayer::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'LAYER_ID' => $this->LAYER_ID,
            'JEDA_PEKAN' => $this->JEDA_PEKAN,
        ]);

        $query->andFilterWhere(['like', 'LAYER_NM', $this->LAYER_NM])
            ->andFilterWhere(['like', 'DCRIPT', $this->DCRIPT]);

        return $dataProvider;
    }
}
