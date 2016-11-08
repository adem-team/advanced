<?php

namespace lukisongroup\sales\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\sales\models\UserFile;

/**
 * UserFileSearch represents the model behind the search form about `lukisongroup\sales\models\UserFile`.
 */
class UserFileGudangSearch extends UserFile
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'STATUS'], 'integer'],
            [['USER_ID', 'FILE_PATH', 'FILE_NM'], 'safe'],
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
        $query = UserFile::find();

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
        ]);

        $query->andFilterWhere(['like', 'USER_ID', $this->USER_ID])
            ->andFilterWhere(['like', 'FILE_PATH', $this->FILE_PATH])
            ->andFilterWhere(['like', 'FILE_NM', $this->FILE_NM]);

        return $dataProvider;
    }
}
