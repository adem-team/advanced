<?php

namespace crm\mastercrm\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use crm\mastercrm\models\DraftPlanHeader;

/**
 * DraftPlanHeaderSearch represents the model behind the search form about `lukisongroup\master\models\DraftPlanHeader`.
 */
class DraftPlanHeaderSearch extends DraftPlanHeader
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'SCDL_GROUP', 'STATUS', 'STT_UBAH'], 'integer'],
            [['TGL', 'NOTE', 'USER_ID', 'CREATE_BY', 'CREATE_AT', 'UPDATE_BY', 'UPDATE_AT'], 'safe'],
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
        $query = DraftPlanHeader::find();

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
            'TGL' => $this->TGL,
            'SCDL_GROUP' => $this->SCDL_GROUP,
            'STATUS' => $this->STATUS,
            'CREATE_AT' => $this->CREATE_AT,
            'STT_UBAH' => $this->STT_UBAH,
            'UPDATE_AT' => $this->UPDATE_AT,
        ]);

        $query->andFilterWhere(['like', 'NOTE', $this->NOTE])
            ->andFilterWhere(['like', 'USER_ID', $this->USER_ID])
            ->andFilterWhere(['like', 'CREATE_BY', $this->CREATE_BY])
            ->andFilterWhere(['like', 'UPDATE_BY', $this->UPDATE_BY]);

        return $dataProvider;
    }
}
