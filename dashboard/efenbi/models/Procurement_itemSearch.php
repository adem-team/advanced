<?php

namespace lukisongroup\front\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\front\models\Procurement_item;

/**
 * Procurement_itemSearch represents the model behind the search form about `lukisongroup\front\models\Procurement_item`.
 */
class Procurement_itemSearch extends Procurement_item
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'PARENT', 'SORT_PATENT', 'PRC_BRG_ID', 'KATEGORI','GROUP'], 'integer'],
            [['PRC_BRG_NM', 'PRC_BRG_SPEK', 'PRC_BRG_DCRP', 'TGL_START', 'TGL_END', 'CREATED_BY', 'UPDATED_BY', 'UPDATED_TIME'], 'safe'],
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
        $query = Procurement_item::find();

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
            'PARENT' => $this->PARENT,
            'SORT_PATENT' => $this->SORT_PATENT,
            'PRC_BRG_ID' => $this->PRC_BRG_ID,
            'KATEGORI' => $this->KATEGORI,
            'GROUP' => $this->GROUP,
            'TGL_START' => $this->TGL_START,
            'TGL_END' => $this->TGL_END,
            'UPDATED_TIME' => $this->UPDATED_TIME,
        ]);

        $query->andFilterWhere(['like', 'PRC_BRG_NM', $this->PRC_BRG_NM])
            ->andFilterWhere(['like', 'PRC_BRG_SPEK', $this->PRC_BRG_SPEK])
            ->andFilterWhere(['like', 'PRC_BRG_DCRP', $this->PRC_BRG_DCRP])
            ->andFilterWhere(['like', 'CREATED_BY', $this->CREATED_BY])
            ->andFilterWhere(['like', 'UPDATED_BY', $this->UPDATED_BY]);

        return $dataProvider;
    }
}
