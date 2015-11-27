<?php

namespace lukisongroup\esm\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\esm\models\Kategoricus;

/**
 * KategoricusSearch represents the model behind the search form about `lukisongroup\esm\models\Kategoricus`.
 */
class KategoricusSearch extends Kategoricus
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CUST_KTG', 'CUST_KTG_PARENT', 'STATUS'], 'integer'],
            [['CUST_KTG_NM', 'CREATED_BY', 'CREATED_AT', 'UPDATED_BY', 'UPDATED_AT'], 'safe'],
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
        $query = Kategoricus::find();

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
            'CUST_KTG' => $this->CUST_KTG,
            'CUST_KTG_PARENT' => $this->CUST_KTG_PARENT,
            'CREATED_AT' => $this->CREATED_AT,
            'UPDATED_AT' => $this->UPDATED_AT,
            'STATUS' => $this->STATUS,
        ]);

        $query->andFilterWhere(['like', 'CUST_KTG_NM', $this->CUST_KTG_NM])
            ->andFilterWhere(['like', 'CREATED_BY', $this->CREATED_BY])
            ->andFilterWhere(['like', 'UPDATED_BY', $this->UPDATED_BY]);

        return $dataProvider;
    }
}
