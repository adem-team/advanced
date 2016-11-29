<?php

namespace lukisongroup\master\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\master\models\SopSalesHeader;
use lukisongroup\master\models\SopSalesDetail;

/**
 * SopSalesHeaderSearch represents the model behind the search form about `lukisongroup\master\models\SopSalesHeader`.
 */
class SopSalesHeaderSearch extends SopSalesHeader
{
    /**
     * @inheritdoc
     */
     public $sopNm;
    public function rules()
    {
        return [
            [['ID', 'STT_DEFAULT', 'SOP_TYPE', 'TTL_DAYS'], 'integer'],
            [['TGL', 'KATEGORI', 'TARGET_UNIT', 'CREATE_BY', 'CREATE_AT','sopNm'], 'safe'],
            [['BOBOT_PERCENT', 'TARGET_MONTH', 'TARGET_DAY'], 'number'],
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
        $query = SopSalesHeader::find();

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
            'TGL' => $this->TGL,
            'STT_DEFAULT' => $this->STT_DEFAULT,
            'SOP_TYPE' => $this->sopNm,
            'BOBOT_PERCENT' => $this->BOBOT_PERCENT,
            'TARGET_MONTH' => $this->TARGET_MONTH,
            'TARGET_DAY' => $this->TARGET_DAY,
            'TTL_DAYS' => $this->TTL_DAYS,
            'CREATE_AT' => $this->CREATE_AT,
        ]);

        $query->andFilterWhere(['like', 'KATEGORI', $this->KATEGORI])
            ->andFilterWhere(['like', 'TARGET_UNIT', $this->TARGET_UNIT])
            ->andFilterWhere(['like', 'CREATE_BY', $this->CREATE_BY]);

        return $dataProvider;
    }

}
