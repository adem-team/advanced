<?php

namespace lukisongroup\purchasing\models\stck;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\purchasing\models\stck\StockRcvd;

/**
 * StockRcvdSearch represents the model behind the search form about `lukisongroup\purchasing\models\stck\StockRcvd`.
 */
class StockRcvdSearch extends StockRcvd
{
	
	public $ID; 
	public $TGL;
	public $KD_PO;
	public $KD_BARANG;
	public $NM_BARANG;
	public $PO_QTY;
	public $QTY_RCVD;
	public $QTY_REJECT;
	public $QTY_RETURE;
	public $QTY_CANCEL;
	public $UNIT;
	public $UNIT_QTY;
	public $UNIT_WIGHT;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'TYPE', 'STATUS'], 'integer'],
            [['TGL', 'KD_PO', 'KD_REF', 'KD_SPL', 'ID_BARANG', 'NM_BARANG', 'UNIT', 'UNIT_NM', 'NOTE', 'CREATE_BY', 'CREATE_AT', 'UPDATE_BY', 'UPDATE_AT'], 'safe'],
            [['UNIT_QTY', 'UNIT_WIGHT', 'QTY'], 'number'],
			[['TGL','TGL','KD_PO','KD_BARANG','NM_BARANG','PO_QTY','QTY_RCVD','QTY_REJECT',''],'safe],
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
        $query = StockRcvd::find();

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
            'TYPE' => $this->TYPE,
            'UNIT_QTY' => $this->UNIT_QTY,
            'UNIT_WIGHT' => $this->UNIT_WIGHT,
            'QTY' => $this->QTY,
            'STATUS' => $this->STATUS,
            'CREATE_AT' => $this->CREATE_AT,
            'UPDATE_AT' => $this->UPDATE_AT,
        ]);

        $query->andFilterWhere(['like', 'KD_PO', $this->KD_PO])
            ->andFilterWhere(['like', 'KD_REF', $this->KD_REF])
            ->andFilterWhere(['like', 'KD_SPL', $this->KD_SPL])
            ->andFilterWhere(['like', 'ID_BARANG', $this->ID_BARANG])
            ->andFilterWhere(['like', 'NM_BARANG', $this->NM_BARANG])
            ->andFilterWhere(['like', 'UNIT', $this->UNIT])
            ->andFilterWhere(['like', 'UNIT_NM', $this->UNIT_NM])
            ->andFilterWhere(['like', 'NOTE', $this->NOTE])
            ->andFilterWhere(['like', 'CREATE_BY', $this->CREATE_BY])
            ->andFilterWhere(['like', 'UPDATE_BY', $this->UPDATE_BY]);

        return $dataProvider;
    }
	
	/*GET STOCK PO ->VALIDATION FORM*/
	public function searchPODetailForm($params){
		$data= Yii::$app->db_esm->createCommand("CALL PURCHASING_po_detail_form()")->queryAll();  
		$dataProvider= new ArrayDataProvider([
			'key' => 'ID',
			'allModels'=>$data,			
			'pagination' => [
				'pageSize' => 100,
			]
		]);
		//if (!($this->load($params) && $this->validate())) {
		if (!($this->load($params))) {
 			return $dataProvider;
 		}
		
		$filter = new Filter();
 		$this->addCondition($filter, 'ID', true);
 		$this->addCondition($filter, 'CREATE_AT', true);
 		$this->addCondition($filter, 'KD_PO', true);	
 		$this->addCondition($filter, 'KD_CORP', true);	
 		$this->addCondition($filter, 'PARENT_PO', false);	
 		$this->addCondition($filter, 'SUPPLIER', true);	
 		$this->addCondition($filter, 'TOP_TYPE', true);	
 		$this->addCondition($filter, 'TOP_DURATION', true);	
 		$this->addCondition($filter, 'PAJAK', true);	
 		$this->addCondition($filter, 'DELIVERY_COST', true);	
 		$this->addCondition($filter, 'NOTE', true);	
 		$this->addCondition($filter, 'SIG1_NM', true);	
 		$this->addCondition($filter, 'SIG2_NM', true);	
 		$this->addCondition($filter, 'SIG3_NM', true);	
 		$this->addCondition($filter, 'KD_RO', true);	
 		$this->addCondition($filter, 'KD_COSTCENTER', true);	
 		$this->addCondition($filter, 'KD_BARANG', true);	
 		$this->addCondition($filter, 'NM_BARANG', true);	
 		$this->addCondition($filter, 'QTY', true);	
 		$this->addCondition($filter, 'HARGA', true);	
 		$this->addCondition($filter, 'UNIT', true);	
 		$this->addCondition($filter, 'HARGA', true);	
 		$this->addCondition($filter, 'UNIT_QTY', true);	
 		$this->addCondition($filter, 'UNIT_WIGHT', true);	
 		$this->addCondition($filter, 'STT_HDR', true);	
 		$this->addCondition($filter, 'STT_DTL', true);	
 		$this->addCondition($filter, 'SUB_TTL', true);	
 		$dataProvider->allModels = $filter->filter($data);   
		return $dataProvider;
	}
}
