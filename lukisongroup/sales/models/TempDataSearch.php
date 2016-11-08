<?php

namespace lukisongroup\sales\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\sales\models\TempData;

/**
 * TempDataSearch represents the model behind the search form about `lukisongroup\sales\models\TempData`.
 */
class TempDataSearch extends TempData
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'SO_TYPE', 'STATUS','STT_ERROR'], 'integer'],
            [['TGL', 'CUST_KD', 'CUST_KD_ALIAS', 'CUST_NM', 'CUST_NM_ALIAS', 'ITEM_ID', 'ITEM_ID_ALIAS', 'ITEM_NM', 'ITEM_NM_ALIAS', 'DIS_REF', 'DIS_REF_NM', 'POS', 'USER_ID','MSG_ERROR'], 'safe'],
            [['QTY_PCS', 'QTY_UNIT'], 'number'],
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
        $query = TempData::find();

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
			'USER_ID'=>$this->USER_ID,
            'TGL' => $this->TGL,
            'QTY_PCS' => $this->QTY_PCS,
            'QTY_UNIT' => $this->QTY_UNIT,
            'SO_TYPE' => $this->SO_TYPE,
            'STATUS' => $this->STATUS,
        ]);

        $query->andFilterWhere(['like', 'CUST_KD', $this->CUST_KD])
            ->andFilterWhere(['like', 'CUST_KD_ALIAS', $this->CUST_KD_ALIAS])
            ->andFilterWhere(['like', 'CUST_NM', $this->CUST_NM])
            ->andFilterWhere(['like', 'CUST_NM_ALIAS', $this->CUST_NM_ALIAS])
            ->andFilterWhere(['like', 'ITEM_ID', $this->ITEM_ID])
            ->andFilterWhere(['like', 'ITEM_ID_ALIAS', $this->ITEM_ID_ALIAS])
            ->andFilterWhere(['like', 'ITEM_NM', $this->ITEM_NM])
            ->andFilterWhere(['like', 'ITEM_NM_ALIAS', $this->ITEM_NM_ALIAS])
            ->andFilterWhere(['like', 'DIS_REF', $this->DIS_REF])
            ->andFilterWhere(['like', 'DIS_REF_NM', $this->DIS_REF_NM])
            ->andFilterWhere(['like', 'POS', $this->POS]);

        return $dataProvider;
    }
	
	
	/*GRID ARRAY DATA PROVIDER*/
	/* private function gvValidateArrayDataProvider(){
		$user= Yii::$app->user->identity->username;
		$data=Yii::$app->db_esm->createCommand("CALL ESM_SALES_IMPORT_TEMP_view('STOCK','".$user."')")->queryAll(); 
		$aryDataProvider= new ArrayDataProvider([
			'key' => 'ID',
			'allModels'=>$data,
			 'pagination' => [
				'pageSize' => 500,
			]
		]);
		
		return $aryDataProvider;  
	} */
	
	
}
