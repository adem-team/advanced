<?php

namespace lukisongroup\efenbi\rasasayang\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\efenbi\rasasayang\models\ItemGroup;

/**
 * ItemGroupSearch represents the model behind the search form about `lukisongroup\efenbi\rasasayang\models\ItemGroup`.
 */
class ItemGroupSearch extends ItemGroup
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_DTL_ITEM', 'STATUS', 'TYPE', 'ID_STORE', 'ID_ITEM'], 'integer'],
            [['CREATE_BY', 'CREATE_AT', 'UPDATE_BY', 'UPDATE_AT', 'TYPE_NM'], 'safe'],
            [['PERSEN_MARGIN'], 'number'],
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
        $query = ItemGroup::find();

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
            'ID_DTL_ITEM' => $this->ID_DTL_ITEM,
            'CREATE_AT' => $this->CREATE_AT,
            'UPDATE_AT' => $this->UPDATE_AT,
            'STATUS' => $this->STATUS,
            'TYPE' => $this->TYPE,
            'ID_STORE' => $this->ID_STORE,
            'ID_ITEM' => $this->ID_ITEM,
            'PERSEN_MARGIN' => $this->PERSEN_MARGIN,
        ]);

        $query->andFilterWhere(['like', 'CREATE_BY', $this->CREATE_BY])
            ->andFilterWhere(['like', 'UPDATE_BY', $this->UPDATE_BY])
            ->andFilterWhere(['like', 'TYPE_NM', $this->TYPE_NM]);

        return $dataProvider;
    }
}
