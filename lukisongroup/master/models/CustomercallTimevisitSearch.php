<?php

namespace lukisongroup\master\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\master\models\CustomercallTimevisit;

/**
 * CustomercallTimevisitSearch represents the model behind the search form about `lukisongroup\master\models\CustomercallTimevisit`.
 */
class CustomercallTimevisitSearch extends CustomercallTimevisit
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'STS'], 'integer'],
            [['TGL', 'CUST_ID', 'CUST_NM', 'USER_ID', 'USER_NM','SALES_NM','HP', 'SCDL_GROUP', 'SCDL_GRP_NM', 'ABSEN_MASUK', 'ABSEN_KELUAR', 'ABSEN_TOTAL', 'GPS_GRP_LAT', 'GPS_GRP_LONG', 'ABSEN_MASUK_LAT', 'ABSEN_MASUK_LONG', 'ABSEN_MASUK_DISTANCE', 'ABSEN_KELUAR_LAT', 'ABSEN_KELUAR_LONG', 'ABSEN_KELUAR_DISTANCE', 'CUST_CHKIN', 'CUST_CHKOUT', 'LIVE_TIME', 'JRK_TEMPUH', 'JRK_TEMPUH_PULANG', 'GPS_CUST_LAT', 'GPS_CUST_LAG', 'LAT_CHEKIN', 'LONG_CHEKIN', 'DISTANCE_CHEKIN', 'LAT_CHEKOUT', 'LONG_CHEKOUT', 'DISTANCE_CHEKOUT', 'UPDATE_BY', 'UPDATE_AT','IMG_DECODE_START','IMG_DECODE_END'], 'safe'],
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
        $query = CustomercallTimevisit::find();

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
            'STS' => $this->STS,
            'ABSEN_MASUK' => $this->ABSEN_MASUK,
            'ABSEN_KELUAR' => $this->ABSEN_KELUAR,
            'ABSEN_TOTAL' => $this->ABSEN_TOTAL,
            'CUST_CHKIN' => $this->CUST_CHKIN,
            'CUST_CHKOUT' => $this->CUST_CHKOUT,
            'LIVE_TIME' => $this->LIVE_TIME,
            'JRK_TEMPUH' => $this->JRK_TEMPUH,
            'JRK_TEMPUH_PULANG' => $this->JRK_TEMPUH_PULANG,
            'UPDATE_AT' => $this->UPDATE_AT,
        ]);

        $query->andFilterWhere(['like', 'CUST_ID', $this->CUST_ID])
            ->andFilterWhere(['like', 'CUST_NM', $this->CUST_NM])
            ->andFilterWhere(['like', 'USER_ID', $this->USER_ID])
            ->andFilterWhere(['like', 'USER_NM', $this->USER_NM])
            ->andFilterWhere(['like', 'SCDL_GROUP', $this->SCDL_GROUP])
            ->andFilterWhere(['like', 'SCDL_GRP_NM', $this->SCDL_GRP_NM])
            ->andFilterWhere(['like', 'GPS_GRP_LAT', $this->GPS_GRP_LAT])
            ->andFilterWhere(['like', 'GPS_GRP_LONG', $this->GPS_GRP_LONG])
            ->andFilterWhere(['like', 'ABSEN_MASUK_LAT', $this->ABSEN_MASUK_LAT])
            ->andFilterWhere(['like', 'ABSEN_MASUK_LONG', $this->ABSEN_MASUK_LONG])
            ->andFilterWhere(['like', 'ABSEN_MASUK_DISTANCE', $this->ABSEN_MASUK_DISTANCE])
            ->andFilterWhere(['like', 'ABSEN_KELUAR_LAT', $this->ABSEN_KELUAR_LAT])
            ->andFilterWhere(['like', 'ABSEN_KELUAR_LONG', $this->ABSEN_KELUAR_LONG])
            ->andFilterWhere(['like', 'ABSEN_KELUAR_DISTANCE', $this->ABSEN_KELUAR_DISTANCE])
            ->andFilterWhere(['like', 'GPS_CUST_LAT', $this->GPS_CUST_LAT])
            ->andFilterWhere(['like', 'GPS_CUST_LAG', $this->GPS_CUST_LAG])
            ->andFilterWhere(['like', 'LAT_CHEKIN', $this->LAT_CHEKIN])
            ->andFilterWhere(['like', 'LONG_CHEKIN', $this->LONG_CHEKIN])
            ->andFilterWhere(['like', 'DISTANCE_CHEKIN', $this->DISTANCE_CHEKIN])
            ->andFilterWhere(['like', 'LAT_CHEKOUT', $this->LAT_CHEKOUT])
            ->andFilterWhere(['like', 'LONG_CHEKOUT', $this->LONG_CHEKOUT])
            ->andFilterWhere(['like', 'DISTANCE_CHEKOUT', $this->DISTANCE_CHEKOUT])
            ->andFilterWhere(['like', 'UPDATE_BY', $this->UPDATE_BY]);

        return $dataProvider;
    }
}
