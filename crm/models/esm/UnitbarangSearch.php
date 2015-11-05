<?php

namespace lukisongroup\models\esm;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\models\esm\Unitbarang;

/**
 * UnitbarangSearch represents the model behind the search form about `app\models\esm\Unitbarang`.
 */
class UnitbarangSearch extends Unitbarang
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'QTY', 'SIZE', 'WEIGHT', 'STATUS'], 'integer'],
            [['KD_UNIT', 'UPDATED_BY', 'NM_UNIT', 'COLOR', 'NOTE', 'CREATED_BY', 'CREATED_AT', 'UPDATED_AT'], 'safe'],
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
        $query = Unitbarang::find();

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
            'ID' => $this->ID,
            'QTY' => $this->QTY,
            'SIZE' => $this->SIZE,
            'WEIGHT' => $this->WEIGHT,
            'STATUS' => $this->STATUS,
        ]);

        $query->andFilterWhere(['like', 'KD_UNIT', $this->KD_UNIT])
            ->andFilterWhere(['like', 'NM_UNIT', $this->NM_UNIT])
            ->andFilterWhere(['like', 'COLOR', $this->COLOR])
            ->andFilterWhere(['like', 'NOTE', $this->NOTE])
            ->andFilterWhere(['like', 'CREATED_BY', $this->CREATED_BY])
            ->andFilterWhere(['like', 'CREATED_AT', $this->CREATED_AT])
            ->andFilterWhere(['like', 'UPDATED_AT', $this->UPDATED_AT]);

        return $dataProvider;
    }
}
