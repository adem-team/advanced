<?php

namespace lukisongroup\hrd\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\hrd\models\Kar_finger;

/**
 * Kar_fingerSearch represents the model behind the search form about `lukisongroup\hrd\models\Kar_finger`.
 */
class Kar_fingerSearch extends Kar_finger
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NO_URUT'], 'integer'],
            [['TerminalID', 'KAR_ID', 'FingerPrintID', 'FingerTmpl', 'UPDT'], 'safe'],
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
        $query = Kar_finger::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'NO_URUT' => $this->NO_URUT,
            'UPDT' => $this->UPDT,
        ]);

        $query->andFilterWhere(['like', 'TerminalID', $this->TerminalID])
            ->andFilterWhere(['like', 'KAR_ID', $this->KAR_ID])
            ->andFilterWhere(['like', 'FingerPrintID', $this->FingerPrintID])
            ->andFilterWhere(['like', 'FingerTmpl', $this->FingerTmpl]);

        return $dataProvider;
    }
}
