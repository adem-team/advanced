<?php

namespace lukisongroup\warehouse\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\warehouse\models\RcvdReleaseHeader;

/**
 * HeaderDetailRcvdSearch represents the model behind the search form about `lukisongroup\purchasing\models\warehouse\HeaderDetailRcvd`.
 */
class RcvdReleaseHeaderSearch extends RcvdReleaseHeader
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
         return [
            [['ID'], 'required'],
            [['ID'], 'integer'],
            [['TGL', 'ETD', 'ETA', 'CREATE_AT', 'UPDATE_AT'], 'safe'],
            [['QTY_UNIT', 'QTY_PCS',  'DELIVERY_COST'], 'number'],
            [['NOTE','TYPE','TYPE_KTG','TYPE_NOTE'], 'string'],
            [['CUST_KD','KD_RCVD','KD_SO', 'CREATE_BY', 'UPDATE_BY'], 'string', 'max' => 50],
            [['CUST_NM'], 'string', 'max' => 255]
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
        $query = RcvdReleaseHeader::find();

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
            'ETD' => $this->ETD,
            'ETA' => $this->ETA,
            'QTY_UNIT' => $this->QTY_UNIT,
            'QTY_PCS' => $this->QTY_PCS,
            'DELIVERY_COST' => $this->DELIVERY_COST,
            'CREATE_AT' => $this->CREATE_AT,
            'UPDATE_AT' => $this->UPDATE_AT,
        ]);

        $query->andFilterWhere(['like', 'KD_SJ', $this->KD_SJ])
            ->andFilterWhere(['like', 'KD_SO', $this->KD_SO])
            ->andFilterWhere(['like', 'NOTE', $this->NOTE])
            ->andFilterWhere(['like', 'CREATE_BY', $this->CREATE_BY])
            ->andFilterWhere(['like', 'UPDATE_BY', $this->UPDATE_BY]);

        return $dataProvider;
    }
}
