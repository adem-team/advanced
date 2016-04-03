<?php

namespace lukisongroup\master\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\master\models\CustomerVisitImage;

/**
 * CustomerVisitImageSearch represents the model behind the search form about `lukisongroup\master\models\CustomerVisitImage`.
 */
class CustomerVisitImageSearch extends CustomerVisitImage
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        // return [
            // [['ID', 'STATUS'], 'integer'],
            // [['ID_DETAIL', 'IMG_NM', 'IMG_DECODE', 'CREATE_BY', 'CREATE_AT', 'UPDATE_BY', 'UPDATE_AT'], 'safe'],
        // ];
		return [
            [['IMG_DECODE_START', 'IMG_DECODE_END'], 'safe'],
            [['STATUS'], 'integer'],
            [['CREATE_AT', 'UPDATE_AT', 'TIME_END', 'TIME_START'], 'safe'],
            [['ID_DETAIL'], 'string', 'max' => 20],
            [['IMG_NM_START', 'IMG_NM_END'], 'string', 'max' => 255],
            [['CREATE_BY', 'UPDATE_BY'], 'string', 'max' => 100]
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
        $query = CustomerVisitImage::find();

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
            'STATUS' => $this->STATUS,
            'CREATE_AT' => $this->CREATE_AT,
            'UPDATE_AT' => $this->UPDATE_AT,
        ]);

        $query->andFilterWhere(['like', 'ID_DETAIL', $this->ID_DETAIL])
            ->andFilterWhere(['like', 'IMG_NM_START', $this->IMG_NM_START])
            ->andFilterWhere(['like', 'IMG_DECODE_START', $this->IMG_DECODE_START])
            ->andFilterWhere(['like', 'CREATE_BY', $this->CREATE_BY])
            ->andFilterWhere(['like', 'UPDATE_BY', $this->UPDATE_BY]);
 
        return $dataProvider;
    }
}
