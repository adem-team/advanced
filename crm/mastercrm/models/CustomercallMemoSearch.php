<?php

namespace crm\mastercrm\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use crm\mastercrm\models\CustomercallMemo;

/**
 * CustomercallMemoSearch represents the model behind the search form about `lukisongroup\master\models\CustomercallMemo`.
 */
class CustomercallMemoSearch extends CustomercallMemo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'ID_DETAIL', 'ID_USER', 'STATUS', 'CREATE_BY', 'UPDATE_BY'], 'integer'],
            [['KD_CUSTOMER', 'NM_CUSTOMER', 'NM_USER', 'ISI_MESSAGES', 'TGL', 'CREATE_AT', 'UPDATE_AT'], 'safe'],
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
        $query = CustomercallMemo::find();

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
            'ID_DETAIL' => $this->ID_DETAIL,
            'ID_USER' => $this->ID_USER,
            'TGL' => $this->TGL,
            'STATUS' => $this->STATUS,
            'CREATE_BY' => $this->CREATE_BY,
            'CREATE_AT' => $this->CREATE_AT,
            'UPDATE_BY' => $this->UPDATE_BY,
            'UPDATE_AT' => $this->UPDATE_AT,
        ]);

        $query->andFilterWhere(['like', 'KD_CUSTOMER', $this->KD_CUSTOMER])
            ->andFilterWhere(['like', 'NM_CUSTOMER', $this->NM_CUSTOMER])
            ->andFilterWhere(['like', 'NM_USER', $this->NM_USER])
            ->andFilterWhere(['like', 'ISI_MESSAGES', $this->ISI_MESSAGES]);

        return $dataProvider;
    }
}
