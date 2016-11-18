<?php

namespace lukisongroup\purchasing\models\salesmanorder;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\purchasing\models\salesmanorder\SoStatus;

/**
 * SoStatusSearch represents the model behind the search form about `lukisongroup\purchasing\models\salesmanorder\SoStatus`.
 */
class SoStatusSearch extends SoStatus
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'STT_PROCESS'], 'integer'],
            [['KD_SO', 'ID_USER', 'UPDATE_AT'], 'safe'],
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
        $query = SoStatus::find();

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
            'STT_PROCESS' => $this->STT_PROCESS,
            'UPDATE_AT' => $this->UPDATE_AT,
        ]);

        $query->andFilterWhere(['like', 'KD_SO', $this->KD_SO])
            ->andFilterWhere(['like', 'ID_USER', $this->ID_USER]);

        return $dataProvider;
    }
}
