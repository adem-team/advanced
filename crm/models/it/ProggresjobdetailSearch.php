<?php

namespace lukisongroup\models\it;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\models\it\Proggresjobdetail;

/**
 * ProggresjobdetailSearch represents the model behind the search form about `backend\models\Proggresjobdetail`.
 */
class ProggresjobdetailSearch extends Proggresjobdetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['proggresjobdetail_id', 'progress_id'], 'integer'],
            [['created_date', 'keterangan', 'pic'], 'safe'],
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
        $query = Proggresjobdetail::find();

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
            'proggresjobdetail_id' => $this->proggresjobdetail_id,
            'progress_id' => $this->progress_id,
            'created_date' => $this->created_date,
        ]);

        $query->andFilterWhere(['like', 'keterangan', $this->keterangan])
            ->andFilterWhere(['like', 'pic', $this->pic]);

        return $dataProvider;
    }
}
