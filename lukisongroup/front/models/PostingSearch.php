<?php

namespace lukisongroup\front\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\front\models\Posting;

/**
 * PostingSearch represents the model behind the search form about `lukisongroup\front\models\Posting`.
 */
class PostingSearch extends Posting
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID'], 'integer'],
            [['PARENT','CHILD','GRANDCHILD','JUDUL', 'RESUME_EN', 'RESUME_ID', 'IMAGE', 'CREATEBY', 'UPDATEBY'], 'safe'],
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
        $query = Posting::find();

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
            'CREATEBY' => $this->CREATEBY,
            'UPDATEBY' => $this->UPDATEBY,
        ]);

        $query->andFilterWhere(['like', 'PARENT', $this->PARENT])
            ->andFilterWhere(['like', 'CHILD', $this->CHILD])
            ->andFilterWhere(['like', 'GRANDCHILD', $this->GRANDCHILD])
            ->andFilterWhere(['like', 'JUDUL', $this->JUDUL])
            ->andFilterWhere(['like', 'RESUME_EN', $this->RESUME_EN])
            ->andFilterWhere(['like', 'RESUME_ID', $this->RESUME_ID])
            ->andFilterWhere(['like', 'IMAGE', $this->IMAGE]);

        return $dataProvider;
    }
}
