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


    /*attribute join */
    public $disnm;  
    public $custnm;
    public $custpnma;

    public function rules()
    {
        return [
            [['ID'], 'integer'],
            [['KD_CUSTOMERS', 'KD_ALIAS', 'KD_DISTRIBUTOR', 'CREATED_BY', 'CREATED_AT', 'UPDATED_BY', 'UPDATED_AT','disnm','custnm','custpnma','KD_PARENT'], 'safe'],
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
        $query = Customersalias::find();

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
            'KD_PARENT' => $this->custpnma,
            'KD_CUSTOMERS'=>$this->custnm,
            'CREATED_AT' => $this->CREATED_AT,
            'UPDATED_AT' => $this->UPDATED_AT,
            'KD_DISTRIBUTOR'=>$this->disnm,
        ]);

        $query->andFilterWhere(['like', 'KD_CUSTOMERS', $this->custnm])
            ->andFilterWhere(['like', 'KD_ALIAS', $this->KD_ALIAS])
            ->andFilterWhere(['like', 'KD_PARENT', $this->custpnma])
            ->andFilterWhere(['like', 'KD_DISTRIBUTOR', $this->disnm])
            ->andFilterWhere(['like', 'CREATED_BY', $this->CREATED_BY])
            ->andFilterWhere(['like', 'UPDATED_BY', $this->UPDATED_BY]);

        return $dataProvider;
    }
}
