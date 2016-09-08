<?php

namespace crm\mastercrm\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use crm\mastercrm\models\CustomercallExpired;

/**
 * CustomercallExpiredSearch represents the model behind the search form about `lukisongroup\master\models\CustomercallExpired`.
 */
class CustomercallExpiredSearch extends CustomercallExpired
{
    /**
     * @inheritdoc
     */
	 
	//private $tglpersen;
	public $custNm;
    public function rules()
    {
        return [
            [['ID', 'ID_PRIORITASED', 'ID_DETAIL', 'USER_ID', 'QTY', 'STATUS', 'CREATE_BY', 'UPDATE_BY'], 'integer'],
            [['CUST_ID', 'BRG_ID', 'TGL_KJG', 'DATE_EXPIRED', 'CREATE_AT', 'UPDATE_AT','custNm','barangNm'], 'safe'],
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
        $query = CustomercallExpired::find();

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
            'ID_PRIORITASED' => $this->ID_PRIORITASED,
            'ID_DETAIL' => $this->ID_DETAIL,
            'USER_ID' => $this->USER_ID,
            'TGL_KJG' => $this->TGL_KJG,
            'QTY' => $this->QTY,
            'DATE_EXPIRED' => $this->DATE_EXPIRED,
            'STATUS' => $this->STATUS,
            'CREATE_AT' => $this->CREATE_AT,
            'UPDATE_AT' => $this->UPDATE_AT,
            'CREATE_BY' => $this->CREATE_BY,
            'UPDATE_BY' => $this->UPDATE_BY,
        ]);

        $query->andFilterWhere(['like', 'CUST_ID', $this->CUST_ID])
            ->andFilterWhere(['like', 'BRG_ID', $this->BRG_ID]);

        return $dataProvider;
    }
	
	/**
	 * REPORT FOR CUSTOMER VISIT
	*/
	public function searchReport($params)
    {
        $query = CustomercallExpired::find();

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
			'custNm'=>$this->custNm
            // 'ID' => $this->ID,
            // 'ID_PRIORITASED' => $this->ID_PRIORITASED,
            // 'ID_DETAIL' => $this->ID_DETAIL,
            // 'USER_ID' => $this->USER_ID,
            // 'TGL_KJG' => $this->TGL_KJG,
            // 'QTY' => $this->QTY,
            // 'DATE_EXPIRED' => $this->DATE_EXPIRED,
            // 'STATUS' => $this->STATUS,
            // 'CREATE_AT' => $this->CREATE_AT,
            // 'UPDATE_AT' => $this->UPDATE_AT,
            // 'CREATE_BY' => $this->CREATE_BY,
            // 'UPDATE_BY' => $this->UPDATE_BY,
        ]);
		
        $query->andFilterWhere(['like', 'TGL_KJG',$this->TGL_KJG])
			  ->andFilterWhere(['like', 'USER_ID',$this->USER_ID]);
        return $dataProvider;
    }
	
	public function  tglpersen(){
		return $this->TGL_KJG.' %';
	}
	
}
