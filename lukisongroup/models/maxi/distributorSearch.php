<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\distributor;

/**
 * distributorSearch represents the model behind the search form about `app\models\distributor`.
 */
class distributorSearch extends distributor
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['DBTR_ID', 'DBTR_STT'], 'integer'],
            [['DBTR_NM', 'DBTR_JOIN', 'DBTR_PIC', 'DBTR_ALMT', 'DBTR_ID_TLP'], 'safe'],
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
        $query = distributor::find();

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
            'DBTR_ID' => $this->DBTR_ID,
            'DBTR_STT' => $this->DBTR_STT,
            'DBTR_JOIN' => $this->DBTR_JOIN,
        ]);

        $query->andFilterWhere(['like', 'DBTR_NM', $this->DBTR_NM])
            ->andFilterWhere(['like', 'DBTR_PIC', $this->DBTR_PIC])
            ->andFilterWhere(['like', 'DBTR_ALMT', $this->DBTR_ALMT])
            ->andFilterWhere(['like', 'DBTR_ID_TLP', $this->DBTR_ID_TLP]);

        return $dataProvider;
    }
}
