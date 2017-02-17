<?php

namespace lukisongroup\salesmd\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\salesmd\models\RekapStockVisit;

/**
 * RekapStockVisitSearch represents the model behind the search form about `lukisongroup\salesmd\models\RekapStockVisit`.
 */
class RekapStockVisitSearch extends RekapStockVisit
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'SO_TYPE'], 'integer'],
            [['CUST_KD', 'CUST_NM', 'KD_BARANG', 'NM_BARANG', 'TGL', 'POS', 'USER_ID'], 'safe'],
            [['w0', 'w1', 'w2', 'w3', 'w4', 'w5', 'w6', 'w7', 'w8', 'w9', 'w10', 'w11', 'w12', 'w13', 'w14', 'w15', 'w16', 'w17', 'w18', 'w19', 'w20', 'w21', 'w22', 'w23', 'w24', 'w25', 'w26', 'w27', 'w28', 'w29', 'w30', 'w31', 'w32', 'w33', 'w34', 'w35', 'w36', 'w37', 'w38', 'w39', 'w40', 'w41', 'w42', 'w43', 'w44', 'w45', 'w46', 'w47', 'w48', 'w49', 'w50', 'w51', 'w52', 'w53'], 'number'],
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
        $query = RekapStockVisit::find()->JoinWith('headerTbl',true,'INNER JOIN');
		$count = $query->count();
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query->orderBy(['CUST_KD'=>SORT_ASC,'KD_BARANG'=>SORT_ASC]),
			'pagination'=>[
				'pageSize'=>$count,
			]
        ]);

		/* $dataProvider->sort->attributes['sot2_rekap_salesmd_stock.CUST_KD'] = [
			'asc' => ['sot2_rekap_salesmd_stock.CUST_KD' => SORT_ASC],
			//'asc' => ['sot2_rekap_salesmd_stock.CUST_KD' => SORT_ASC,'sot2_rekap_salesmd_stock.KD_BARANG'=>SORT_ASC],
			//'desc' => ['u0002b.DEP_SUB_NM' => SORT_DESC],
		]; */
			
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'ID' => $this->ID,
            'SO_TYPE' => $this->SO_TYPE,
            'w0' => $this->w0,
            'w1' => $this->w1,
            'w2' => $this->w2,
            'w3' => $this->w3,
            'w4' => $this->w4,
            'w5' => $this->w5,
            'w6' => $this->w6,
            'w7' => $this->w7,
            'w8' => $this->w8,
            'w9' => $this->w9,
            'w10' => $this->w10,
            'w11' => $this->w11,
            'w12' => $this->w12,
            'w13' => $this->w13,
            'w14' => $this->w14,
            'w15' => $this->w15,
            'w16' => $this->w16,
            'w17' => $this->w17,
            'w18' => $this->w18,
            'w19' => $this->w19,
            'w20' => $this->w20,
            'w21' => $this->w21,
            'w22' => $this->w22,
            'w23' => $this->w23,
            'w24' => $this->w24,
            'w25' => $this->w25,
            'w26' => $this->w26,
            'w27' => $this->w27,
            'w28' => $this->w28,
            'w29' => $this->w29,
            'w30' => $this->w30,
            'w31' => $this->w31,
            'w32' => $this->w32,
            'w33' => $this->w33,
            'w34' => $this->w34,
            'w35' => $this->w35,
            'w36' => $this->w36,
            'w37' => $this->w37,
            'w38' => $this->w38,
            'w39' => $this->w39,
            'w40' => $this->w40,
            'w41' => $this->w41,
            'w42' => $this->w42,
            'w43' => $this->w43,
            'w44' => $this->w44,
            'w45' => $this->w45,
            'w46' => $this->w46,
            'w47' => $this->w47,
            'w48' => $this->w48,
            'w49' => $this->w49,
            'w50' => $this->w50,
            'w51' => $this->w51,
            'w52' => $this->w52,
            'w53' => $this->w53,
        ]);

        $query->andFilterWhere(['like', 'CUST_KD', $this->CUST_KD])
            ->andFilterWhere(['like', 'CUST_NM', $this->CUST_NM])
            ->andFilterWhere(['like', 'KD_BARANG', $this->KD_BARANG])
            ->andFilterWhere(['like', 'NM_BARANG', $this->NM_BARANG])
           // ->andFilterWhere(['like', 'TGL', $this->TGL])
            ->andFilterWhere(['like', 'TGL', '2017'])
            ->andFilterWhere(['like', 'POS', $this->POS])
            ->andFilterWhere(['like', 'USER_ID', $this->USER_ID]);

        return $dataProvider;
    }
}
