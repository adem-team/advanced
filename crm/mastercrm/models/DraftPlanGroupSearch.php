<?php

namespace crm\mastercrm\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use crm\mastercrm\models\DraftPlanGroup;

/**
 * DraftPlanGroupSearch represents the model behind the search form about `lukisongroup\master\models\DraftPlanGroup`.
 */
class DraftPlanGroupSearch extends DraftPlanGroup
{
    /**
     * @inheritdoc
     */
    public $geonm;
    public $ganjilGenap;
    public $dayNm;
    public $useridNm;
    public function rules()
    {
        return [
            [['GEO_ID','DAY_ID', 'DAY_VALUE', 'STATUS'], 'integer'],
            [['TGL_START','SCDL_GROUP', 'SCL_NM', 'USER_ID', 'CREATED_BY', 'CREATED_AT', 'UPDATED_BY', 'UPDATED_AT','geonm','GROUP_PRN','ganjilGenap','dayNm','useridNm'], 'safe'],
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
        $query = DraftPlanGroup::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
             'sort' =>false
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'SCDL_GROUP' => $this->SCDL_GROUP,
            'TGL_START' => $this->TGL_START,
            'GEO_ID' => $this->GEO_ID,
            'DAY_ID' => $this->DAY_ID,
            'DAY_VALUE' => $this->DAY_VALUE,
            'STATUS' => $this->STATUS,
            'CREATED_AT' => $this->CREATED_AT,
            'UPDATED_AT' => $this->UPDATED_AT,
            'GROUP_PRN' => $this->geonm,
            'DAY_ID'=>$this->ganjilGenap,
            'DAY_VALUE'=>$this->dayNm,
            'USER_ID'=>$this->useridNm
        ]);

        $query->andFilterWhere(['like', 'SCL_NM', $this->SCL_NM])
            ->andFilterWhere(['like', 'USER_ID', $this->USER_ID])
            ->andFilterWhere(['like', 'CREATED_BY', $this->CREATED_BY])
            ->andFilterWhere(['like', 'UPDATED_BY', $this->UPDATED_BY]);

        return $dataProvider;
    }
}
