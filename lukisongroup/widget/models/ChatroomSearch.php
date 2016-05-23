<?php

namespace lukisongroup\widget\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\widget\models\Chatroom;

/**
 * ChatroomSearch represents the model behind the search form about `lukisongroup\widget\models\Chatroom`.
 */
class ChatroomSearch extends Chatroom
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'PARENT', 'SORT'], 'integer'],
            [['GROUP_ID', 'GROUP_NM'], 'safe'],
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
        $query = Chatroom::find()->where('PARENT = 0');

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
            'PARENT' => $this->PARENT,
            'SORT' => $this->SORT,
        ]);

        $query->andFilterWhere(['like', 'GROUP_ID', $this->GROUP_ID])
            ->andFilterWhere(['like', 'GROUP_NM', $this->GROUP_NM]);

				$query->orderby(['SORT'=>SORT_ASC]);

        return $dataProvider;
    }
}
