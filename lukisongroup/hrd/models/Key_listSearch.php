<?php

namespace lukisongroup\hrd\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\hrd\models\Key_list;

/**
 * Key_listSearch represents the model behind the search form about `lukisongroup\hrd\models\Key_list`.
 */
class Key_listSearch extends Key_list
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['FunctionKey'], 'integer'],
            [['FunctionKeyNM'], 'safe'],
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
        $query = Key_list::find();

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
            'FunctionKey' => $this->FunctionKey,
        ]);

        $query->andFilterWhere(['like', 'FunctionKeyNM', $this->FunctionKeyNM]);

        return $dataProvider;
    }
}
