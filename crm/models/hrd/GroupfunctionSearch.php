<?php

namespace lukisongroup\models\hrd;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\models\hrd\Groupfunction;

/**
 * GroupfunctionSearch represents the model behind the search form about `lukisongroup\models\hrd\Groupfunction`.
 */
class GroupfunctionSearch extends Groupfunction
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['GF_ID'], 'integer'],
            [['GF_NM'], 'safe'],
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
        $query = Groupfunction::find()->Where('u0003a.STATUS<>3');;

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
            'GF_ID' => $this->GF_ID,
            'SORT' => $this->SORT,
        ]);

        $query->andFilterWhere(['like', 'GF_NM', $this->GF_NM]);

        return $dataProvider;
    }
}
