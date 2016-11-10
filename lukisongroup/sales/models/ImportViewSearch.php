<?php

namespace lukisongroup\sales\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\sales\models\ImportView;

/**
 * ImportViewSearch represents the model behind the search form about `lukisongroup\sales\models\ImportView`.
 */
class ImportViewSearch extends ImportView
{
	/**
     * @inheritdoc
     */
	public function attributes()
	{
		// Author -ptr.nov- add related fields to searchable attributes 
		return array_merge(parent::attributes(), ['disNm']);
	} 
	
    public function rules()
    {
        return [
            [['ID', 'SO_TYPE', 'STATUS'], 'integer'],
            [['TGL', 'CUST_KD', 'CUST_KD_ALIAS', 'CUST_NM', 'KD_BARANG', 'KD_BARANG_ALIAS', 'NM_BARANG', 'POS', 'KD_DIS', 'NM_DIS', 'USER_ID', 'UNIT_BARANG', 'NOTED','disNm','kartonqty'], 'safe'],
            [['SO_QTY', 'UNIT_QTY', 'UNIT_BERAT', 'HARGA_PABRIK', 'HARGA_DIS', 'HARGA_SALES', 'HARGA_LG'], 'number'],
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
        $query = ImportView::find()->orderBy('TGL DESC');
		 // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
				 'pageSize' => 200,
			]
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
            'SO_QTY' => $this->SO_QTY,
            'SO_TYPE' => $this->SO_TYPE,
            'UNIT_QTY' => $this->UNIT_QTY,
            'UNIT_BERAT' => $this->UNIT_BERAT,
            'HARGA_PABRIK' => $this->HARGA_PABRIK,
            'HARGA_DIS' => $this->HARGA_DIS,
            'HARGA_SALES' => $this->HARGA_SALES,
            'HARGA_LG' => $this->HARGA_LG,
            'STATUS' => $this->STATUS,
        ]);

        $query->andFilterWhere(['like', 'CUST_KD', $this->CUST_KD])
            ->andFilterWhere(['like', 'CUST_KD_ALIAS', $this->CUST_KD_ALIAS])
            ->andFilterWhere(['like', 'CUST_NM', $this->CUST_NM])
            ->andFilterWhere(['like', 'KD_BARANG', $this->KD_BARANG])
            ->andFilterWhere(['like', 'KD_BARANG_ALIAS', $this->KD_BARANG_ALIAS])
            ->andFilterWhere(['like', 'NM_BARANG', $this->NM_BARANG])
            ->andFilterWhere(['like', 'POS', $this->POS])
            ->andFilterWhere(['like', 'KD_DIS', $this->disNm])
            ->andFilterWhere(['like', 'NM_DIS', $this->NM_DIS])
            ->andFilterWhere(['like', 'USER_ID', $this->USER_ID])
            ->andFilterWhere(['like', 'UNIT_BARANG', $this->UNIT_BARANG])
            ->andFilterWhere(['like', 'NOTED', $this->NOTED]);

        return $dataProvider;
    }
	
	 /**
     * View Latest Data  GUDANG
     * @author piter [ptr.nov@gmail.com]
     */
    public function searchViewLatesGudang($params)
    {
		$maxTgl = ImportView::find()->where(['POS'=>'WEB_IMPORT','SO_TYPE' => '1'])->max('TGL');
		//print_r($this->disNm);
        $query = ImportView::find()->orderBy('TGL DESC');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
				 'pageSize' => 200,
			]
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
            'TGL' =>$this->TGL,
            'SO_QTY' => $this->SO_QTY, 
            'SO_TYPE' => '1',
            'UNIT_QTY' => $this->UNIT_QTY,
            'UNIT_BERAT' => $this->UNIT_BERAT,
            'HARGA_PABRIK' => $this->HARGA_PABRIK,
            'HARGA_DIS' => $this->HARGA_DIS,
            'HARGA_SALES' => $this->HARGA_SALES,
            'HARGA_LG' => $this->HARGA_LG,
            'STATUS' => $this->STATUS,
        ]);

        $query->andFilterWhere(['like', 'CUST_KD', $this->CUST_KD])
            ->andFilterWhere(['like', 'CUST_KD_ALIAS', $this->CUST_KD_ALIAS])
            ->andFilterWhere(['like', 'CUST_NM', $this->CUST_NM])
            ->andFilterWhere(['like', 'KD_BARANG', $this->KD_BARANG])
            ->andFilterWhere(['like', 'KD_BARANG_ALIAS', $this->KD_BARANG_ALIAS])
            ->andFilterWhere(['like', 'NM_BARANG', $this->NM_BARANG])
            ->andFilterWhere(['like', 'POS', 'WEB_IMPORT'])
            ->andFilterWhere(['like', 'KD_DIS',$this->getAttribute('disNm')])
            ->andFilterWhere(['like', 'NM_DIS', $this->NM_DIS])
            ->andFilterWhere(['like', 'USER_ID', $this->USER_ID])
            ->andFilterWhere(['like', 'UNIT_BARANG', $this->UNIT_BARANG])
            ->andFilterWhere(['like', 'NOTED', $this->NOTED]);

        return $dataProvider;
    }
	
	 /**
     * View History Data  GUDANG
     * @author piter [ptr.nov@gmail.com]
     */
	public function searchViewHistoryGudang($params)
    {
		$query = ImportView::find()->orderBy('TGL DESC');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
				 'pageSize' => 200,
			]
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
            'SO_QTY' => $this->SO_QTY,
            'SO_TYPE' => '1',
            'UNIT_QTY' => $this->UNIT_QTY,
            'UNIT_BERAT' => $this->UNIT_BERAT,
            'HARGA_PABRIK' => $this->HARGA_PABRIK,
            'HARGA_DIS' => $this->HARGA_DIS,
            'HARGA_SALES' => $this->HARGA_SALES,
            'HARGA_LG' => $this->HARGA_LG,
            'STATUS' => $this->STATUS,
        ]);

        $query->andFilterWhere(['like', 'CUST_KD', $this->CUST_KD])
            ->andFilterWhere(['like', 'CUST_KD_ALIAS', $this->CUST_KD_ALIAS])
            ->andFilterWhere(['like', 'CUST_NM', $this->CUST_NM])
            ->andFilterWhere(['like', 'KD_BARANG', $this->KD_BARANG])
            ->andFilterWhere(['like', 'KD_BARANG_ALIAS', $this->KD_BARANG_ALIAS])
            ->andFilterWhere(['like', 'NM_BARANG', $this->NM_BARANG])
            ->andFilterWhere(['like', 'POS', 'WEB_IMPORT'])
            ->andFilterWhere(['like', 'KD_DIS',$this->getAttribute('disNm')])
            ->andFilterWhere(['like', 'NM_DIS', $this->NM_DIS])
            ->andFilterWhere(['like', 'USER_ID', $this->USER_ID])
            ->andFilterWhere(['like', 'UNIT_BARANG', $this->UNIT_BARANG])
            ->andFilterWhere(['like', 'NOTED', $this->NOTED]);

        return $dataProvider;
    }
	
	 /**
     * View Latest Data  SALES PO
     * @author piter [ptr.nov@gmail.com]
     */
    public function searchViewLatesSalespo($params)
    {
		$maxTgl = ImportView::find()->where(['POS'=>'WEB_IMPORT','SO_TYPE' => '3'])->max('TGL');
		//print_r($this->disNm);
        $query = ImportView::find()->orderBy('TGL DESC');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
				 'pageSize' => 200,
			]
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
            'TGL' =>$this->TGL,
            'SO_QTY' => $this->SO_QTY, 
            'SO_TYPE' => '3',
            'UNIT_QTY' => $this->UNIT_QTY,
            'UNIT_BERAT' => $this->UNIT_BERAT,
            'HARGA_PABRIK' => $this->HARGA_PABRIK,
            'HARGA_DIS' => $this->HARGA_DIS,
            'HARGA_SALES' => $this->HARGA_SALES,
            'HARGA_LG' => $this->HARGA_LG,
            'STATUS' => $this->STATUS,
        ]);

        $query->andFilterWhere(['like', 'CUST_KD', $this->CUST_KD])
            ->andFilterWhere(['like', 'CUST_KD_ALIAS', $this->CUST_KD_ALIAS])
            ->andFilterWhere(['like', 'CUST_NM', $this->CUST_NM])
            ->andFilterWhere(['like', 'KD_BARANG', $this->KD_BARANG])
            ->andFilterWhere(['like', 'KD_BARANG_ALIAS', $this->KD_BARANG_ALIAS])
            ->andFilterWhere(['like', 'NM_BARANG', $this->NM_BARANG])
            ->andFilterWhere(['like', 'POS', 'WEB_IMPORT'])
            ->andFilterWhere(['like', 'KD_DIS',$this->getAttribute('disNm')])
            ->andFilterWhere(['like', 'NM_DIS', $this->NM_DIS])
            ->andFilterWhere(['like', 'USER_ID', $this->USER_ID])
            ->andFilterWhere(['like', 'UNIT_BARANG', $this->UNIT_BARANG])
            ->andFilterWhere(['like', 'NOTED', $this->NOTED]);

        return $dataProvider;
    }
	
	 /**
     * View History Data  SALES PO
     * @author piter [ptr.nov@gmail.com]
     */
	public function searchViewHistorySalespo($params)
    {
		$query = ImportView::find()->orderBy('TGL DESC');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
				 'pageSize' => 200,
			]
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
            'SO_QTY' => $this->SO_QTY,
            'SO_TYPE' => '3',
            'UNIT_QTY' => $this->UNIT_QTY,
            'UNIT_BERAT' => $this->UNIT_BERAT,
            'HARGA_PABRIK' => $this->HARGA_PABRIK,
            'HARGA_DIS' => $this->HARGA_DIS,
            'HARGA_SALES' => $this->HARGA_SALES,
            'HARGA_LG' => $this->HARGA_LG,
            'STATUS' => $this->STATUS,
        ]);

        $query->andFilterWhere(['like', 'CUST_KD', $this->CUST_KD])
            ->andFilterWhere(['like', 'CUST_KD_ALIAS', $this->CUST_KD_ALIAS])
            ->andFilterWhere(['like', 'CUST_NM', $this->CUST_NM])
            ->andFilterWhere(['like', 'KD_BARANG', $this->KD_BARANG])
            ->andFilterWhere(['like', 'KD_BARANG_ALIAS', $this->KD_BARANG_ALIAS])
            ->andFilterWhere(['like', 'NM_BARANG', $this->NM_BARANG])
            ->andFilterWhere(['like', 'POS', 'WEB_IMPORT'])
            ->andFilterWhere(['like', 'KD_DIS',$this->getAttribute('disNm')])
            ->andFilterWhere(['like', 'NM_DIS', $this->NM_DIS])
            ->andFilterWhere(['like', 'USER_ID', $this->USER_ID])
            ->andFilterWhere(['like', 'UNIT_BARANG', $this->UNIT_BARANG])
            ->andFilterWhere(['like', 'NOTED', $this->NOTED]);

        return $dataProvider;
    }
	
	
}
