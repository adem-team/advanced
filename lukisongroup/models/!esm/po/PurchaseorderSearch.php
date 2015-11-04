<?php

namespace lukisongroup\models\esm\po;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\models\esm\po\Purchaseorder;

/**
 * PurchaseorderSearch represents the model behind the search form about `lukisongroup\models\esm\po\Purchaseorder`.
 */
class PurchaseorderSearch extends Purchaseorder
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'STATUS'], 'integer'],
            [['KD_PO', 'KD_SUPPLIER', 'CREATE_BY', 'CREATE_AT', 'APPROVE_BY', 'APPROVE_AT', 'NOTE'], 'safe'],
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
        $query = Purchaseorder::find();

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
            'CREATE_AT' => $this->CREATE_AT,
            'APPROVE_AT' => $this->APPROVE_AT,
            'STATUS' => $this->STATUS,
        ]);

        $query->andFilterWhere(['like', 'KD_PO', $this->KD_PO])
            ->andFilterWhere(['like', 'KD_SUPPLIER', $this->KD_SUPPLIER])
            ->andFilterWhere(['like', 'CREATE_BY', $this->CREATE_BY])
            ->andFilterWhere(['like', 'APPROVE_BY', $this->APPROVE_BY])
            ->andFilterWhere(['like', 'NOTE', $this->NOTE]);

        return $dataProvider;
    }
}
