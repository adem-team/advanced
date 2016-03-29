<?php

namespace lukisongroup\hrd\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\hrd\models\ModulEvent;

/**
 * ModulEventSearch represents the model behind the search form about `lukisongroup\hrd\models\ModulEvent`.
 */
class ModulEventSearch extends ModulEvent
{
	public $modul_nm;
	public $ID;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'MODUL_ID','MODUL_PRN', 'STATUS'], 'integer'],
            [['start', 'end', 'title', 'USER_ID', 'CREATE_BY', 'CREATE_AT', 'UPDATE_BY', 'UPDATE_AT','modul_nm','ID'], 'safe'],
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
        $query = ModulEvent::find();

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
            'id' => $this->id,
            'start' => $this->start,
            'end' => $this->end,
            'MODUL_PRN' => $this->MODUL_PRN,
            'MODUL_ID' => $this->MODUL_ID,
            'STATUS' => $this->STATUS,
            'CREATE_AT' => $this->CREATE_AT,
            'UPDATE_AT' => $this->UPDATE_AT,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'USER_ID', $this->USER_ID])
            ->andFilterWhere(['like', 'CREATE_BY', $this->CREATE_BY])
            ->andFilterWhere(['like', 'UPDATE_BY', $this->UPDATE_BY]);

        return $dataProvider;
    }

	public function searchPersonal($params)
    {
				// $EMP_ID=Yii::$app->user->identity->EMP_ID;
				$profile= Yii::$app->getUserOpt->Profile_user();
        $query = ModulEvent::find()->where(['USER_ID'=>$profile->emp->EMP_ID]);

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
            'id' => $this->id,
            'start' => $this->start,
            'end' => $this->end,
            'MODUL_PRN' => $this->MODUL_PRN,
            'MODUL_ID' => $this->MODUL_ID,
            'STATUS' => $this->STATUS,
            'CREATE_AT' => $this->CREATE_AT,
            'UPDATE_AT' => $this->UPDATE_AT,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'USER_ID', $this->USER_ID])
            ->andFilterWhere(['like', 'CREATE_BY', $this->CREATE_BY])
            ->andFilterWhere(['like', 'UPDATE_BY', $this->UPDATE_BY]);

        return $dataProvider;
    }

		public function searchPersonalia($params)
	    {
					// $EMP_ID=Yii::$app->user->identity->EMP_ID;
					$profile= Yii::$app->getUserOpt->Profile_user();
	        $query = ModulEvent::find()->joinWith('modulPesonalia',false)->where(['p0001.USER_ID'=>$profile->emp->EMP_ID]);

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
	            'MODUL_ID' => $this->MODUL_ID,
	        ]);

	        // $query->andFilterWhere(['like', 'title', $this->title])
	        //     ->andFilterWhere(['like', 'USER_ID', $this->USER_ID])
	        //     ->andFilterWhere(['like', 'CREATE_BY', $this->CREATE_BY])
	        //     ->andFilterWhere(['like', 'UPDATE_BY', $this->UPDATE_BY]);

	        return $dataProvider;
	    }



}
