<?php

namespace lukisongroup\widget\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\widget\models\AgendaNotulen;

/**
 * AgendaNotulenSearch represents the model behind the search form about `lukisongroup\widget\models\AgendaNotulen`.
 */
class AgendaNotulenSearch extends AgendaNotulen
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'NOTULEN_ID', 'CREATE_BY', 'UPDATE_BY'], 'integer'],
            [['DESCRIPTION', 'DATE_LINE', 'PIC', 'CREATE_AT', 'UPDATE_AT'], 'safe'],
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
        $query = AgendaNotulen::find();

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
            'NOTULEN_ID' => $this->NOTULEN_ID,
            'DATE_LINE' => $this->DATE_LINE,
            'CREATE_BY' => $this->CREATE_BY,
            'CREATE_AT' => $this->CREATE_AT,
            'UPDATE_BY' => $this->UPDATE_BY,
            'UPDATE_AT' => $this->UPDATE_AT,
        ]);

        $query->andFilterWhere(['like', 'DESCRIPTION', $this->DESCRIPTION])
            ->andFilterWhere(['like', 'PIC', $this->PIC]);

        return $dataProvider;
    }
}
