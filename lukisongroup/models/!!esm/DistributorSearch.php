<?php

namespace lukisongroup\models\esm;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\models\esm\Distributor;

/**
 * DistributorSearch represents the model behind the search form about `app\models\esm\Distributor`.
 */
class DistributorSearch extends Distributor
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'TLP1', 'TLP2', 'FAX', 'STATUS'], 'integer'],
            [['KD_DISTRIBUTOR', 'NM_DISTRIBUTOR', 'ALAMAT', 'PIC', 'EMAIL', 'WEBSITE', 'NOTE', 'CREATED_BY', 'CREATED_AT', 'UPDATED_AT', 'UPDATED_BY', 'DATA_ALL'], 'safe'],
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
        $query = Distributor::find()->where('d0001.STATUS <> 3');

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
            'TLP1' => $this->TLP1,
            'TLP2' => $this->TLP2,
            'FAX' => $this->FAX,
            'STATUS' => $this->STATUS,
        ]);

        $query->andFilterWhere(['like', 'KD_DISTRIBUTOR', $this->KD_DISTRIBUTOR])
            ->andFilterWhere(['like', 'NM_DISTRIBUTOR', $this->NM_DISTRIBUTOR])
            ->andFilterWhere(['like', 'ALAMAT', $this->ALAMAT])
            ->andFilterWhere(['like', 'PIC', $this->PIC])
            ->andFilterWhere(['like', 'EMAIL', $this->EMAIL])
            ->andFilterWhere(['like', 'WEBSITE', $this->WEBSITE])
            ->andFilterWhere(['like', 'NOTE', $this->NOTE])
            ->andFilterWhere(['like', 'CREATED_BY', $this->CREATED_BY])
            ->andFilterWhere(['like', 'CREATED_AT', $this->CREATED_AT])
            ->andFilterWhere(['like', 'UPDATED_AT', $this->UPDATED_AT])
            ->andFilterWhere(['like', 'DATA_ALL', $this->DATA_ALL]);

        return $dataProvider;
    }
}
