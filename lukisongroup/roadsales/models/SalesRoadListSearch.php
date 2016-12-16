<?php

namespace lukisongroup\roadsales\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\roadsales\models\SalesRoadList;

/**
 * SalesRoadListSearch represents the model behind the search form about `lukisongroup\roadsales\models\SalesRoadList`.
 */
class SalesRoadListSearch extends SalesRoadList
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'STATUS'], 'integer'],
            [['CASE_NAME', 'CASE_DSCRIP', 'CREATED_BY', 'CREATED_AT'], 'safe'],
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
        $query = SalesRoadList::find();

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
            'STATUS' => $this->STATUS,
            'CREATED_AT' => $this->CREATED_AT,
        ]);

        $query->andFilterWhere(['like', 'CASE_NAME', $this->CASE_NAME])
            ->andFilterWhere(['like', 'CASE_DSCRIP', $this->CASE_DSCRIP])
            ->andFilterWhere(['like', 'CREATED_BY', $this->CREATED_BY]);

        return $dataProvider;
    }
}
