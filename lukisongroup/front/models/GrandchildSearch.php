<?php

namespace lukisongroup\front\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\front\models\Grandchild;

/**
 * GrandchildSearch represents the model behind the search form about `lukisongroup\grandchild\models\Grandchild`.
 */
class GrandchildSearch extends Grandchild
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['GRANDCHILD_ID', 'CHILD_ID', 'PARENT_ID'], 'integer'],
            [['GRANDCHILD'], 'safe'],
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
        $query = Grandchild::find();

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
            'GRANDCHILD_ID' => $this->GRANDCHILD_ID,
            'CHILD_ID' => $this->CHILD_ID,
            'PARENT_ID' => $this->PARENT_ID,
        ]);

        $query->andFilterWhere(['like', 'GRANDCHILD', $this->GRANDCHILD]);

        return $dataProvider;
    }
}
