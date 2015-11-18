<?php

namespace lukisongroup\models\hrd;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\models\hrd\Regulasi;

/**
 * RegulasiSearch represents the model behind the search form about `lukisongroup\models\hrd\Regulasi`.
 */
class RegulasiSearch extends Regulasi
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'SET_ACTIVE', 'GF_ID', 'SEQ_ID', 'STATUS'], 'integer'],
            [['RGTR_TITEL', 'TGL', 'RGTR_ISI', 'RGTR_DCRPT', 'CORP_ID', 'DEP_ID', 'DEP_SUB_ID', 'JOBGRADE_ID', 'CREATED_BY', 'UPDATED_BY', 'UPDATED_TIME'], 'safe'],
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
        $query = Regulasi::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'ID' => $this->ID,
            'TGL' => $this->TGL,
            'SET_ACTIVE' => $this->SET_ACTIVE,
            'GF_ID' => $this->GF_ID,
            'SEQ_ID' => $this->SEQ_ID,
            'UPDATED_TIME' => $this->UPDATED_TIME,
            'STATUS' => $this->STATUS,
        ]);

        $query->andFilterWhere(['like', 'RGTR_TITEL', $this->RGTR_TITEL])
            ->andFilterWhere(['like', 'RGTR_ISI', $this->RGTR_ISI])
            ->andFilterWhere(['like', 'RGTR_DCRPT', $this->RGTR_DCRPT])
            ->andFilterWhere(['like', 'CORP_ID', $this->CORP_ID])
            ->andFilterWhere(['like', 'DEP_ID', $this->DEP_ID])
            ->andFilterWhere(['like', 'DEP_SUB_ID', $this->DEP_SUB_ID])
            ->andFilterWhere(['like', 'JOBGRADE_ID', $this->JOBGRADE_ID])
            ->andFilterWhere(['like', 'CREATED_BY', $this->CREATED_BY])
            ->andFilterWhere(['like', 'UPDATED_BY', $this->UPDATED_BY]);

        return $dataProvider;
    }
}
