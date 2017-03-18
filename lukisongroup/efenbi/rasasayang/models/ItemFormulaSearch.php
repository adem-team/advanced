<?php

namespace lukisongroup\efenbi\rasasayang\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\efenbi\rasasayang\models\ItemFormula;

/**
 * ItemFormulaSearch represents the model behind the search form about `api\modules\efenbi\rasasayang\models\ItemFormula`.
 */
class ItemFormulaSearch extends ItemFormula
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CREATE_AT', 'UPDATE_AT','FORMULA_DCRIP','FORMULA_NM'], 'safe'],
            [['STATUS'], 'integer'],
            [['CREATE_BY', 'UPDATE_BY','FORMULA_ID'], 'string', 'max' => 50],
			// [['CREATE_AT', 'UPDATE_AT', 'DISCOUNT_WAKTU1','DISCOUNT_WAKTU2','DISCOUNT_VALUE','FORMULA_DCRIP','FORMULA_NM'], 'safe'],
            // [['STATUS','DISCOUNT_QTY'], 'integer'],
            // [['CREATE_BY', 'UPDATE_BY','FORMULA_ID','OUTLET_BARCODE','DISCOUNT_HARI'], 'string', 'max' => 50],
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
        $query = ItemFormula::find();

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
            'ID' => $this->ID,            
            'FORMULA_ID' => $this->FORMULA_ID,            
            'STATUS' => $this->STATUS
        ]);
       $query->andFilterWhere(['like', 'CREATE_AT', $this->CREATE_AT])
            ->andFilterWhere(['like', 'CREATE_AT', $this->CREATE_AT])
            ->andFilterWhere(['like', 'UPDATE_BY', $this->UPDATE_BY])
            ->andFilterWhere(['like', 'UPDATE_AT', $this->UPDATE_AT]);

        return $dataProvider;
    }
}
