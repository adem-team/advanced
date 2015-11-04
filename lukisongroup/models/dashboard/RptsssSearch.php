<?php

namespace app\models\dashboard;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\dashboard\Rptsss;

/**
 * DashboardSearch represents the model behind the search form about `app\models\system\Dashboard`.
 */
class RptsssSearch extends Rptsss
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CORP_ID', 'CORP_NM'], 'safe'],
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
        $query = Corp::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'CORP_ID', $this->CORP_ID])
            ->andFilterWhere(['like', 'CORP_NM', $this->CORP_NM]);

        return $dataProvider;
    }
}
