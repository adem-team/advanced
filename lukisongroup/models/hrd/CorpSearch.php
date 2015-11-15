<?php

namespace lukisongroup\models\hrd;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\models\hrd\Corp;

/**
 * CorpSearch represents the model behind the search form about `lukisongroup\models\hrd\Corp`.
 */
class CorpSearch extends Corp
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CORP_ID', 'CORP_NM', 'CORP_AVATAR', 'CORP_DCRP'], 'safe'],
            [['CORP_STS'], 'integer'],
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
        $query = Corp::find()->Where('u0001.CORP_STS<>3');;

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
            'CORP_STS' => $this->CORP_STS,
            'SORT' => $this->SORT,
        ]);

        $query->andFilterWhere(['like', 'CORP_ID', $this->CORP_ID])
            ->andFilterWhere(['like', 'CORP_NM', $this->CORP_NM])
            ->andFilterWhere(['like', 'CORP_AVATAR', $this->CORP_AVATAR])
            ->andFilterWhere(['like', 'CORP_DCRP', $this->CORP_DCRP]);

        return $dataProvider;
    }
}
