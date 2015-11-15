<?php

namespace lukisongroup\models\it;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\models\it\Proggresjob;

/**
 * ProggresjobSearch represents the model behind the search form about `backend\models\Proggresjob`.
 */
class ProggresjobSearch extends Proggresjob
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['proggres_id', 'status'], 'integer'],
            [['user_id', 'modul', 'judul', 'keterangan', 'start_data', 'end_date', 'proggres'], 'safe'],
            [['keterangan_detail','start_data'], 'safe'],

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
        $query = Proggresjob::find();

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
            'proggres_id' => $this->proggres_id,
            'start_data' => $this->start_data,
            'end_date' => $this->end_date,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'user_id', $this->user_id])
            ->andFilterWhere(['like', 'modul', $this->modul])
            ->andFilterWhere(['like', 'judul', $this->judul])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan])
            ->andFilterWhere(['like', 'proggres', $this->proggres]);

        return $dataProvider;
    }
}
