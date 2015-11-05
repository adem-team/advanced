<?php

namespace lukisongroup\models\hrd;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\models\hrd\Jobgrade;

/**
 * JobgradeSearch represents the model behind the search form about `lukisongroup\models\hrd\Jobgrade`.
 */
class JobgradeSearch extends Jobgrade
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'SORT', 'JOBGRADE_STS'], 'integer'],
            [['JOBGRADE_ID', 'JOBGRADE_NM', 'JOBGRADE_DCRP'], 'safe'],
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
        $query = Jobgrade::find()->Where('u0003c.JOBGRADE_STS<>3');

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
            'SORT' => $this->SORT,
            'JOBGRADE_STS' => $this->JOBGRADE_STS,
        ]);

        $query->andFilterWhere(['like', 'JOBGRADE_ID', $this->JOBGRADE_ID])
            ->andFilterWhere(['like', 'JOBGRADE_NM', $this->JOBGRADE_NM])
            ->andFilterWhere(['like', 'JOBGRADE_DCRP', $this->JOBGRADE_DCRP]);

        return $dataProvider;
    }
}
