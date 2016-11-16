<?php

namespace lukisongroup\master\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\master\models\Scheduledetail;

/**
 * ScheduledetailSearch represents the model behind the search form about `lukisongroup\master\models\Scheduledetail`.
 */
class ScheduledetailSearch extends Scheduledetail
{
	
	public $nmgroup;
	public $nmuser;
	public $nmcust;
	public $sttKoordinat;
	public $radiusMeter;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'SCDL_GROUP', 'STATUS'], 'integer'],
            [['sttKoordinat','radiusMeter','nmgroup','nmuser','nmcust','TGL', 'CUST_ID', 'USER_ID', 'NOTE', 'CREATE_BY', 'CREATE_AT', 'UPDATE_BY', 'UPDATE_AT',
            'CHECKOUT_LAT','CHECKOUT_LAG'], 'safe'],
            [['LAT', 'LAG', 'RADIUS'], 'number'],
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
        $query = Scheduledetail::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
				'pageSize' => 100,
			],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'ID' => $this->ID,
            'TGL' => $this->TGL,
            'SCDL_GROUP' => $this->SCDL_GROUP,
            'LAT' => $this->LAT,
            'LAG' => $this->LAG,
            'RADIUS' => $this->RADIUS,
            'STATUS' => $this->STATUS,
            'CREATE_AT' => $this->CREATE_AT,
            'UPDATE_AT' => $this->UPDATE_AT,
        ]);

        $query->andFilterWhere(['like', 'CUST_ID', $this->CUST_ID])
            ->andFilterWhere(['like', 'USER_ID', $this->USER_ID])
            ->andFilterWhere(['like', 'NOTE', $this->NOTE])
            ->andFilterWhere(['like', 'CREATE_BY', $this->CREATE_BY])
            ->andFilterWhere(['like', 'UPDATE_BY', $this->UPDATE_BY]);

        return $dataProvider;
    }

      public function searchmapdetail($params)
    {

      
        
        $query = Scheduledetail::find()->where(['CUST_ID'=>$params['cust_kd']])
                                                ->andWhere(['not', ['CHECKOUT_LAT' => null]])
                                                ->andWhere(['not', ['CHECKOUT_LAG' => null]]);


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

         $query->andFilterWhere([
            'ID' => $this->ID,
            'TGL' => $this->TGL,
            'SCDL_GROUP' => $this->SCDL_GROUP,
            'LAT' => $this->LAT,
            'LAG' => $this->LAG,
            'RADIUS' => $this->RADIUS,
            'STATUS' => $this->STATUS,
            'CHECKOUT_LAT' => $this->CHECKOUT_LAT,
            'CHECKOUT_LAG' => $this->CHECKOUT_LAG,
        ]);



        // $query->andFilterWhere(['like', 'CUST_KD', $this->CUST_KD])
        // ->andFilterWhere(['like', 'CUST_KD_ALIAS', $this->CUST_KD_ALIAS])
        // ->andFilterWhere(['like', 'TLP1', $this->TLP1])
        // ->andFilterWhere(['like', 'TLP2', $this->TLP2])
        // ->andFilterWhere(['like', 'FAX', $this->FAX])
        // ->andFilterWhere(['like', 'CUST_KTG', $this->getAttribute('c0001k.CUST_KTG')])
        // ->andFilterWhere(['like', 'CUST_TYPE', $this->getAttribute('custype.CUST_KTG_NM')])
        // ->andFilterWhere(['like', 'CUST_NM', $this->CUST_NM])
        // ->andFilterWhere(['like', 'CUST_GRP', $this->CUST_GRP])
        // ->andFilterWhere(['like', 'MAP_LAT', $this->MAP_LAT])
        // ->andFilterWhere(['like', 'MAP_LNG', $this->MAP_LNG])
        // ->andFilterWhere(['like', 'PIC', $this->PIC])
        // ->andFilterWhere(['like', 'ALAMAT', $this->ALAMAT])
        // ->andFilterWhere(['like', 'EMAIL', $this->EMAIL])
        // ->andFilterWhere(['like', 'WEBSITE', $this->WEBSITE])
        // ->andFilterWhere(['like', 'NOTE', $this->NOTE])
        // ->andFilterWhere(['like', 'NPWP', $this->NPWP])
        // ->andFilterWhere(['like', 'DATA_ALL', $this->DATA_ALL])
        // ->andFilterWhere(['like', 'JOIN_DATE', $this->JOIN_DATE])
        // ->andFilterWhere(['like', 'CUST_GRP', $this->parentName])
        // ->andFilterWhere(['like', 'LAYER', $this->LAYER])
        // ->andFilterWhere(['like', 'GEO', $this->GEO])
        // ->andFilterWhere(['like', 'c0001.STATUS', $this->STATUS])
        // ->andFilterWhere(['like', 'c0001.DC_STATUS', $this->DC_STATUS]);
        //     // ->andFilterWhere(['like', 'CORP_ID', $this->CORP_ID])
        //     // ->andFilterWhere(['like', 'CREATED_BY', $this->CREATED_BY])
        //     // ->andFilterWhere(['like', 'UPDATED_BY', $this->UPDATED_BY]);

        //     $query->orderby(['CUST_GRP'=>SORT_ASC]); //SORT PENTING UNTUK RECURSIVE BIAR TREE BISA URUTAN, save => (IF (PATENT =0) {SORT=ID}, ELSE {SORT=PATENT}, note Parent=ID header
        return $dataProvider;
    }
}
