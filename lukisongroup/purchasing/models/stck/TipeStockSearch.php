<?php

namespace lukisongroup\purchasing\models\stck;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\purchasing\models\stck\TipeStock;

/**
 * TipeStockSearch represents the model behind the search form about `lukisongroup\purchasing\models\stck\TipeStock`.
 */
class TipeStockSearch extends TipeStock
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'TYPE_ID'], 'integer'],
            [['TYPE_PARENT', 'TYPE_KAT', 'TYPE_NAME', 'NOTE'], 'safe'],
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
        $query = TipeStock::find();

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
            'ID' => $this->ID,
            'TYPE_ID' => $this->TYPE_ID,
        ]);

        $query->andFilterWhere(['like', 'TYPE_PARENT', $this->TYPE_PARENT])
            ->andFilterWhere(['like', 'TYPE_KAT', $this->TYPE_KAT])
            ->andFilterWhere(['like', 'TYPE_NAME', $this->TYPE_NAME])
            ->andFilterWhere(['like', 'NOTE', $this->NOTE]);

        return $dataProvider;
    }
}
