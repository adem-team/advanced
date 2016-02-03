<?php

namespace lukisongroup\master\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\master\models\Customersalias;

/**
 * CustomersaliasSearch represents the model behind the search form about `lukisongroup\master\models\Customersalias`.
 */
class CustomersaliasSearch extends Customersalias
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'KD_PARENT'], 'integer'],
            [['KD_CUSTOMERS', 'KD_ALIAS', 'KD_DISTRIBUTOR', 'CREATED_BY', 'CREATED_AT', 'UPDATED_BY', 'UPDATED_AT'], 'safe'],
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
    public function search($params,$id)
    {
        $query = Customersalias::find()->where(['KD_CUSTOMERS'=>$id]);

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
            'KD_PARENT' => $this->KD_PARENT,
            'CREATED_AT' => $this->CREATED_AT,
            'UPDATED_AT' => $this->UPDATED_AT,
        ]);

        $query->andFilterWhere(['like', 'KD_CUSTOMERS', $this->KD_CUSTOMERS])
            ->andFilterWhere(['like', 'KD_ALIAS', $this->KD_ALIAS])
            ->andFilterWhere(['like', 'KD_DISTRIBUTOR', $this->KD_DISTRIBUTOR])
            ->andFilterWhere(['like', 'CREATED_BY', $this->CREATED_BY])
            ->andFilterWhere(['like', 'UPDATED_BY', $this->UPDATED_BY]);

        return $dataProvider;
    }
}
