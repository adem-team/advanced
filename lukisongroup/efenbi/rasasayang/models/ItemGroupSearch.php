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
	public function attributes()
	{
		//Author -ptr.nov- add related fields to searchable attributes 
		return array_merge(parent::attributes(), ['ItemNm']);
	}
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CREATE_BY', 'CREATE_AT', 'UPDATE_BY', 'UPDATE_AT','ITEM_BARCODE', 'ItemNm','HPP', 'OUTLET_ID','GRP_DISPLAY'], 'safe'],
            [['STATUS','LOCATE', 'LOCATE_SUB'], 'integer'],
            [['PERSEN_MARGIN'], 'number'],
            [['ITEM_ID','FORMULA_ID'], 'string'],
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
        $query = ItemGroup::find()->JoinWith('itemTbl',true,'LEFT JOIN');

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
            'Item_group.CREATE_AT' => $this->CREATE_AT,
            'Item_group.UPDATE_AT' => $this->UPDATE_AT,
            'Item_group.STATUS' => $this->STATUS,
            'Item_group.LOCATE' => $this->LOCATE,
            'Item_group.LOCATE_SUB' => $this->LOCATE_SUB,
            'Item_group.OUTLET_ID' => $this->OUTLET_ID,
            'Item_group.ITEM_ID' => $this->ITEM_ID,
            'Item_group.PERSEN_MARGIN' => $this->PERSEN_MARGIN,
        ]);

        $query->andFilterWhere(['like', 'Item_group.CREATE_BY', $this->CREATE_BY])
            ->andFilterWhere(['like', 'Item_group.UPDATE_BY', $this->UPDATE_BY])
            ->andFilterWhere(['like', 'Item_group.GRP_DISPLAY',$this->getAttribute('GRP_DISPLAY')])
            ->andFilterWhere(['like', 'item.ITEM_NM',$this->getAttribute('ItemNm')])
            ->andFilterWhere(['like', 'ITEM_BARCODE', $this->ITEM_BARCODE]);

        return $dataProvider;
    }
}
