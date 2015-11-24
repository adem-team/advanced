<?php

namespace lukisongroup\widget\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\widget\models\Berita;

/**
 * BeritaSearch represents the model behind the search form about `lukisongroup\widget\models\Berita`.
 */
class BeritaSearch extends Berita
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'STATUS'], 'integer'],
            [['KD_BERITA', 'JUDUL', 'ISI', 'KD_CORP', 'KD_CAB', 'KD_DEP', 'DATA_PICT', 'DATA_FILE', 'CREATED_ATCREATED_BY', 'CREATED_BY', 'UPDATE_AT', 'DATA_ALL'], 'safe'],
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
        $query = Berita::find();

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
            'STATUS' => $this->STATUS,
            'CREATED_ATCREATED_BY' => $this->CREATED_ATCREATED_BY,
            'UPDATE_AT' => $this->UPDATE_AT,
        ]);

        $query->andFilterWhere(['like', 'KD_BERITA', $this->KD_BERITA])
            ->andFilterWhere(['like', 'JUDUL', $this->JUDUL])
            ->andFilterWhere(['like', 'ISI', $this->ISI])
            ->andFilterWhere(['like', 'KD_CORP', $this->KD_CORP])
            ->andFilterWhere(['like', 'KD_CAB', $this->KD_CAB])
            ->andFilterWhere(['like', 'KD_DEP', $this->KD_DEP])
            ->andFilterWhere(['like', 'DATA_PICT', $this->DATA_PICT])
            ->andFilterWhere(['like', 'DATA_FILE', $this->DATA_FILE])
            ->andFilterWhere(['like', 'CREATED_BY', $this->CREATED_BY])
            ->andFilterWhere(['like', 'DATA_ALL', $this->DATA_ALL]);

        return $dataProvider;
    }
}
