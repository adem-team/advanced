<?php

namespace lukisongroup\models\hrd;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\models\hrd\Groupseqmen;

/**
 * GroupseqmenSearch represents the model behind the search form about `lukisongroup\models\hrd\Groupseqmen`.
 */
class GroupseqmenSearch extends Groupseqmen
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SEQ_ID'], 'integer'],
            [['SEQ_NM'], 'safe'],
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
        $query = Groupseqmen::find()->Where('u0003b.STATUS<>3');;

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
            'SEQ_ID' => $this->SEQ_ID,
        ]);

        $query->andFilterWhere(['like', 'SEQ_NM', $this->SEQ_NM]);

        return $dataProvider;
    }
}
