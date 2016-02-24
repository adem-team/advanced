<?php

namespace lukisongroup\hrd\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\hrd\models\Machine;

/**
 * MachineSearch represents the model behind the search form about `lukisongroup\hrd\models\Machine`.
 */
class MachineSearch extends Machine
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TerminalID', 'MESIN_NM', 'MESIN_SN', 'CAB_ID'], 'safe'],
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
        $query = Machine::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'TerminalID', $this->TerminalID])
            ->andFilterWhere(['like', 'MESIN_NM', $this->MESIN_NM])
            ->andFilterWhere(['like', 'MESIN_SN', $this->MESIN_SN])
            ->andFilterWhere(['like', 'CAB_ID', $this->CAB_ID]);

        return $dataProvider;
    }
}
