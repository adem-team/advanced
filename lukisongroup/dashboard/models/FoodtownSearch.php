<?php

namespace lukisongroup\dashboard\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\dashboard\models\Foodtown;

/**
 * FoodtownSearch represents the model behind the search form about `lukisongroup\dashboard\models\Foodtown`.
 */
class FoodtownSearch extends Foodtown
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Id', 'Val_1'], 'integer'],
            [['Val_Nm', 'UPDT', 'Val_Json'], 'safe'],
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
        $query = Foodtown::find();

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
            'Id' => $this->Id,
            'Val_1' => $this->Val_1,
            'UPDT' => $this->UPDT,
        ]);

        $query->andFilterWhere(['like', 'Val_Nm', $this->Val_Nm])
            ->andFilterWhere(['like', 'Val_Json', $this->Val_Json]);

        return $dataProvider;
    }
}
