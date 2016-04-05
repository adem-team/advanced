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
            [['sttKoordinat','radiusMeter','nmgroup','nmuser','nmcust','TGL', 'CUST_ID', 'USER_ID', 'NOTE', 'CREATE_BY', 'CREATE_AT', 'UPDATE_BY', 'UPDATE_AT'], 'safe'],
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
}
