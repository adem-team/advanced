<?php

namespace lukisongroup\efenbi\rasasayang\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use lukisongroup\efenbi\rasasayang\models\Transaksi;

/**
 * TransaksiSearch represents the model behind the search form about `lukisongroup\efenbi\rasasayang\models\Transaksi`.
 */
class TransaksiSearch extends Transaksi
{
	public function attributes()
	{
		//Author -ptr.nov- add related fields to searchable attributes 
		return array_merge(parent::attributes(), ['TypeNm']);
	}
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'STATUS', 'TRANS_TYPE', 'ITEM_QTY'], 'integer'],
            [['CREATE_BY', 'CREATE_AT', 'UPDATE_BY', 'UPDATE_AT', 'TRANS_ID', 'TRANS_DATE', 'USER_ID', 'OUTLET_ID', 'OUTLET_NM', 'CONSUMER_NM', 'CONSUMER_EMAIL', 'CONSUMER_PHONE', 'ITEM_ID', 'ITEM_NM', 'ITEM_DISCOUNT_TIME','TypeNm'], 'safe'],
            [['ITEM_HARGA', 'ITEM_DISCOUNT'], 'number'],
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
        $query = Transaksi::find();

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
            'CREATE_AT' => $this->CREATE_AT,
            'UPDATE_AT' => $this->UPDATE_AT,
            'STATUS' => $this->STATUS,
            'TRANS_TYPE' => $this->getAttribute('TypeNm'),
            'TRANS_DATE' => $this->TRANS_DATE,
            'ITEM_QTY' => $this->ITEM_QTY,
            'ITEM_HARGA' => $this->ITEM_HARGA,
            'ITEM_DISCOUNT' => $this->ITEM_DISCOUNT,
        ]);

        $query->andFilterWhere(['like', 'CREATE_BY', $this->CREATE_BY])
            ->andFilterWhere(['like', 'UPDATE_BY', $this->UPDATE_BY])
            ->andFilterWhere(['like', 'TRANS_ID', $this->TRANS_ID])
            ->andFilterWhere(['like', 'USER_ID', $this->USER_ID])
            //->andFilterWhere(['like', 'OUTLET_ID', $this->OUTLET_ID])
           // ->andFilterWhere(['like', 'OUTLET_ID', $this->getAttribute('OUTLET_NM')])
            ->andFilterWhere(['like', 'OUTLET_NM', $this->getAttribute('OUTLET_NM')])
            ->andFilterWhere(['like', 'CONSUMER_NM', $this->CONSUMER_NM])
            ->andFilterWhere(['like', 'CONSUMER_EMAIL', $this->CONSUMER_EMAIL])
            ->andFilterWhere(['like', 'CONSUMER_PHONE', $this->CONSUMER_PHONE])
            ->andFilterWhere(['like', 'ITEM_ID', $this->ITEM_ID])
            ->andFilterWhere(['like', 'ITEM_NM', $this->ITEM_NM])
            ->andFilterWhere(['like', 'ITEM_DISCOUNT_TIME', $this->ITEM_DISCOUNT_TIME]);

        return $dataProvider;
    }
	
	/**
	* MENU SET BOOKING.
	* LATEST BOOKING & CREATE BOOKING EDITABLE QTY.
	*/
	public function searchBooking($params){
		$booking= new ArrayDataProvider([
			'allModels'=>Yii::$app->db_efenbi->createCommand("	
				SELECT x1.TRANS_DATE,x1.TRANS_ID,x1.OUTLET_NM,x1.ITEM_NM,x1.ITEM_QTY,x1.ITEM_HARGA,x1.ITEM_DISCOUNT,x1.ITEM_DISCOUNT_TIME,
					   x2.TYPE_NM
				FROM transaksi_test x1
					INNER JOIN 
					(SELECT OUTLET_ID,max(date(TRANS_DATE)) As TRANS_DATE,TRANS_TYPE
					FROM transaksi_test
					WHERE TRANS_TYPE=1 
					GROUP BY OUTLET_ID,TRANS_TYPE
					HAVING TRANS_TYPE=1) M 
				ON x1.OUTLET_ID=M.OUTLET_ID AND date(x1.TRANS_DATE)=M.TRANS_DATE AND x1.TRANS_TYPE=M.TRANS_TYPE
				LEFT JOIN transaksi_type x2 on x2.ID=x1.TRANS_TYPE
				ORDER BY x1.OUTLET_ID;
			")->queryAll(), 
			
		]);
		return $booking;
	}
	
	/**
	* MENU TRANSACTION REPORT.
	* HEADER GRIDVIEW EXPAND ROWS.
	*/
	public function searchTransReportHeader($params){
		 $query = Transaksi::find();

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
            'CREATE_AT' => $this->CREATE_AT,
            'UPDATE_AT' => $this->UPDATE_AT,
            'STATUS' => $this->STATUS,
            'TRANS_TYPE' => $this->getAttribute('TypeNm'),
            'TRANS_DATE' => $this->TRANS_DATE,
            'ITEM_QTY' => $this->ITEM_QTY,
            'ITEM_HARGA' => $this->ITEM_HARGA,
            'ITEM_DISCOUNT' => $this->ITEM_DISCOUNT,
        ]);

        $query->andFilterWhere(['like', 'CREATE_BY', $this->CREATE_BY])
            ->andFilterWhere(['like', 'UPDATE_BY', $this->UPDATE_BY])
            ->andFilterWhere(['like', 'TRANS_ID', $this->TRANS_ID])
            ->andFilterWhere(['like', 'USER_ID', $this->USER_ID])
            //->andFilterWhere(['like', 'OUTLET_ID', $this->OUTLET_ID])
           // ->andFilterWhere(['like', 'OUTLET_ID', $this->getAttribute('OUTLET_NM')])
            ->andFilterWhere(['like', 'OUTLET_NM', $this->getAttribute('OUTLET_NM')])
            ->andFilterWhere(['like', 'CONSUMER_NM', $this->CONSUMER_NM])
            ->andFilterWhere(['like', 'CONSUMER_EMAIL', $this->CONSUMER_EMAIL])
            ->andFilterWhere(['like', 'CONSUMER_PHONE', $this->CONSUMER_PHONE])
            ->andFilterWhere(['like', 'ITEM_ID', $this->ITEM_ID])
            ->andFilterWhere(['like', 'ITEM_NM', $this->ITEM_NM])
            ->andFilterWhere(['like', 'ITEM_DISCOUNT_TIME', $this->ITEM_DISCOUNT_TIME]);
		$query->groupBy('OUTLET_ID,date(TRANS_DATE)');
        
		return $dataProvider;
	}
	
	/**
	* MENU TRANSACTION REPORT.
	* DETAIL - GRIDVIEW EXPAND ROWS.
	*/
	public function searchTransReportDetail($paramsConditional){
		if(is_array($paramsConditional)){
			$variableTambahan = " WHERE date(TRANS_DATE)='".$paramsConditional['TRANS_DATE']."' AND OUTLET_ID='0002' ";
			//WHERE date(TRANS_DATE)='2017-03-12' AND OUTLET_ID='0002'
		}else{
			$variableTambahan='';
		}		
		print_r($variableTambahan);

	
		//WHERE date(TRANS_DATE)='2017-03-12' AND OUTLET_ID='0002'
		$qryTransReportDetail= new ArrayDataProvider([
			'allModels'=>Yii::$app->db_efenbi->createCommand("	
				SELECT	OUTLET_NM,ITEM_NM
						,MAX(CASE WHEN TRANS_TYPE=1 AND ITEM_QTY<>'' THEN ITEM_QTY ELSE 0 END) AS QTY_ORDER
						,MAX(CASE WHEN TRANS_TYPE=2 AND ITEM_QTY<>'' THEN ITEM_QTY ELSE 0 END) AS QTY_BUY
						,MAX(CASE WHEN TRANS_TYPE=3 AND ITEM_QTY<>'' THEN ITEM_QTY ELSE 0 END) AS QTY_RCVD
						,MAX(CASE WHEN TRANS_TYPE=4 AND ITEM_QTY<>'' THEN ITEM_QTY ELSE 0 END) AS QTY_SELL
						,MAX(CASE WHEN TRANS_TYPE=4 AND ITEM_QTY<>'' THEN ITEM_HARGA ELSE 0 END) AS PRC_SELL
						,date(TRANS_DATE) as TRANS_DATE
						,time(TRANS_DATE) as TRANS_TIME
						,TRANS_ID,TRANS_TYPE,USER_ID,OUTLET_ID,OUTLET_NM,ITEM_ID,ITEM_NM,ITEM_QTY,ITEM_HARGA,ITEM_DISCOUNT,ITEM_DISCOUNT_TIME,STATUS
						FROM transaksi_test
						".$variableTambahan."						
						GROUP BY date(CREATE_AT),ITEM_ID
			")->queryAll(), 			
		]);
		return $qryTransReportDetail;
	}
	
	
	
	
	
	public function searchMaxOrder($params)
    {
		$maxID=Transaksi::find()->groupBy('OUTLET_ID')->having(['TRANS_TYPE'=>1])->max('date(TRANS_DATE)');
		//$maxID->max('TRANS_DATE');
		//$maxID=Transaksi::find()->select("TRANS_DATE")->max("ID");
		print_r($maxID);
		die();
		//$itemGroupData = Transaksi::find()->select(['ID'])->where(['LOCATE'=>$paramCari['locate'],'LOCATE_SUB'=>$paramCari['locatesub']])->asArray()->all();
		
		//$iteData = Item::find()->where(['not in','ITEM_ID',$itemGroupData])->all();
        $query = Transaksi::find();
		//$maxID=Item::find()->max('ID');
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
            'CREATE_AT' => $this->CREATE_AT,
            'UPDATE_AT' => $this->UPDATE_AT,
            'STATUS' => $this->STATUS,
            'TRANS_TYPE' => $this->getAttribute('TypeNm'),
            'TRANS_DATE' => $this->TRANS_DATE,
            'ITEM_QTY' => $this->ITEM_QTY,
            'ITEM_HARGA' => $this->ITEM_HARGA,
            'ITEM_DISCOUNT' => $this->ITEM_DISCOUNT,
        ]);

        $query->andFilterWhere(['like', 'CREATE_BY', $this->CREATE_BY])
            ->andFilterWhere(['like', 'UPDATE_BY', $this->UPDATE_BY])
            ->andFilterWhere(['like', 'TRANS_ID', $this->TRANS_ID])
            ->andFilterWhere(['like', 'USER_ID', $this->USER_ID])
            //->andFilterWhere(['like', 'OUTLET_ID', $this->OUTLET_ID])
           // ->andFilterWhere(['like', 'OUTLET_ID', $this->getAttribute('OUTLET_NM')])
            ->andFilterWhere(['like', 'OUTLET_NM', $this->getAttribute('OUTLET_NM')])
            ->andFilterWhere(['like', 'CONSUMER_NM', $this->CONSUMER_NM])
            ->andFilterWhere(['like', 'CONSUMER_EMAIL', $this->CONSUMER_EMAIL])
            ->andFilterWhere(['like', 'CONSUMER_PHONE', $this->CONSUMER_PHONE])
            ->andFilterWhere(['like', 'ITEM_ID', $this->ITEM_ID])
            ->andFilterWhere(['like', 'ITEM_NM', $this->ITEM_NM])
            ->andFilterWhere(['like', 'ITEM_DISCOUNT_TIME', $this->ITEM_DISCOUNT_TIME]);

        return $dataProvider;
    }
	
}
