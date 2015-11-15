<?php

namespace lukisongroup\child\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\child\models\Child;

/**
 * ChildSearch represents the model behind the search form about `lukisongroup\child\models\Child`.
 */
class ChildSearch extends Child
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CHILD_ID', 'PARENT_ID'], 'integer'],
            [['CHILD_NAME'], 'safe'],
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
        $query = Child::find();

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
            'CHILD_ID' => $this->CHILD_ID,
            'PARENT_ID' => $this->PARENT_ID,
        ]);

        $query->andFilterWhere(['like', 'CHILD_NAME', $this->CHILD_NAME]);

        return $dataProvider;
    }
}
