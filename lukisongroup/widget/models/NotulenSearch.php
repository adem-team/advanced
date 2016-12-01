<?php

namespace lukisongroup\widget\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\widget\models\Notulen;

/**
 * NotulenSearch represents the model behind the search form about `lukisongroup\widget\models\Notulen`.
 */
class NotulenSearch extends Notulen
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'MODUL', 'STATUS'], 'integer'],
            [['start', 'end', 'title', 'USER_ID', 'CREATE_BY', 'CREATE_AT', 'UPDATE_BY', 'UPDATE_AT'], 'safe'],
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
        $profile = Yii::$app->getUserOpt->profile_user(); //componen
        $id = $profile->id;
        $query = Notulen::find()->where('USER_ID like "%'.$id.'%"')->orwhere(['CREATE_BY'=>$id])->orderby(['start'=>SORT_DESC]);

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
            'MODUL' => $this->MODUL,
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
}
