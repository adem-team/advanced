<?php

namespace lukisongroup\models\hrd;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\models\hrd\Jobdesc;

/**
 * JobdescSearch represents the model behind the search form about `lukisongroup\models\hrd\Jobdesc`.
 */
class JobdescSearch extends Jobdesc
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'JOBGRADE_STS', 'SORT', 'GF_ID', 'SEQ_ID', 'STATUS'], 'integer'],
            [['JOBSDESK_TITLE', 'JOBGRADE_NM', 'JOBGRADE_DCRP', 'JOBSDESK_IMG', 'JOBSDESK_PATH', 'CORP_ID', 'DEP_ID', 'DEP_SUB_ID', 'JOBGRADE_ID', 'CREATED_BY', 'UPDATED_BY', 'UPDATED_TIME'], 'safe'],
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
        $query = Jobdesc::find()->where('STATUS <>3');

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
            'JOBGRADE_STS' => $this->JOBGRADE_STS,
            'SORT' => $this->SORT,
            'GF_ID' => $this->GF_ID,
            'SEQ_ID' => $this->SEQ_ID,
            'UPDATED_TIME' => $this->UPDATED_TIME,
            'STATUS' => $this->STATUS,
        ]);

        $query->andFilterWhere(['like', 'JOBSDESK_TITLE', $this->JOBSDESK_TITLE])
            ->andFilterWhere(['like', 'JOBGRADE_NM', $this->JOBGRADE_NM])
            ->andFilterWhere(['like', 'JOBGRADE_DCRP', $this->JOBGRADE_DCRP])
            ->andFilterWhere(['like', 'JOBSDESK_IMG', $this->JOBSDESK_IMG])
            ->andFilterWhere(['like', 'JOBSDESK_PATH', $this->JOBSDESK_PATH])
            ->andFilterWhere(['like', 'CORP_ID', $this->CORP_ID])
            ->andFilterWhere(['like', 'DEP_ID', $this->DEP_ID])
            ->andFilterWhere(['like', 'DEP_SUB_ID', $this->DEP_SUB_ID])
            ->andFilterWhere(['like', 'JOBGRADE_ID', $this->JOBGRADE_ID])
            ->andFilterWhere(['like', 'CREATED_BY', $this->CREATED_BY])
            ->andFilterWhere(['like', 'UPDATED_BY', $this->UPDATED_BY]);

        return $dataProvider;
    }
}
