<?php

namespace lukisongroup\models\widget;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\models\widget\Issueproject;

/**
 * IssueprojectSearch represents the model behind the search form about `lukisongroup\models\widget\Issueproject`.
 */
class IssueprojectSearch extends Issueproject
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'PARENT', 'PRIORITY', 'USER_CREATED', 'STATUS'], 'integer'],
            [['ISSUE_NM', 'ISSUE_DESC', 'CLOSE_DATETIME', 'CORP_ID', 'DEP_ID', 'OPEN_DATETIME'], 'safe'],
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
        $query = Issueproject::find();

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
            'PRIORITY' => $this->PRIORITY,
            'CLOSE_DATETIME' => $this->CLOSE_DATETIME,
            'USER_CREATED' => $this->USER_CREATED,
            'STATUS' => $this->STATUS,
            'OPEN_DATETIME' => $this->OPEN_DATETIME,
        ]);

        $query->andFilterWhere(['like', 'ISSUE_NM', $this->ISSUE_NM])
            ->andFilterWhere(['like', 'ISSUE_DESC', $this->ISSUE_DESC])
            ->andFilterWhere(['like', 'CORP_ID', $this->CORP_ID])
            ->andFilterWhere(['like', 'DEP_ID', $this->DEP_ID]);

        return $dataProvider;
    }
}
