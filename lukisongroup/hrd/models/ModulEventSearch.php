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
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'MODUL_HIRS', 'STATUS'], 'integer'],
            [['TGL_START', 'TGL_END', 'TITLE', 'USER_ID', 'CREATE_BY', 'CREATE_AT', 'UPDATE_BY', 'UPDATE_AT'], 'safe'],
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
            'ID' => $this->ID,
            'TGL_START' => $this->TGL_START,
            'TGL_END' => $this->TGL_END,
            'MODUL_HIRS' => $this->MODUL_HIRS,
            'STATUS' => $this->STATUS,
            'CREATE_AT' => $this->CREATE_AT,
            'UPDATE_AT' => $this->UPDATE_AT,
        ]);

        $query->andFilterWhere(['like', 'TITLE', $this->TITLE])
            ->andFilterWhere(['like', 'USER_ID', $this->USER_ID])
            ->andFilterWhere(['like', 'CREATE_BY', $this->CREATE_BY])
            ->andFilterWhere(['like', 'UPDATE_BY', $this->UPDATE_BY]);

        return $dataProvider;
    }
}
