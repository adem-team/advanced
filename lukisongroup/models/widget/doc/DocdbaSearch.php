<?php

namespace lukisongroup\models\widget\doc;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\models\widget\doc\Docdba;

/**
 * DocdbaSearch represents the model behind the search form about `lukisongroup\models\widget\doc\Docdba`.
 */
class DocdbaSearch extends Docdba
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'PARENT', 'STATUS', 'USER_CREATED', 'SORT'], 'integer'],
            [['MDL_ID', 'MDL_NM', 'MDL_DB', 'MDL_DB_ALIAS', 'MDL_TBL', 'MDL_KEY', 'MDL_FLD', 'MDL_CLS', 'MDL_LINK', 'DSCRP', 'CREATED_DATE', 'CORP_ID', 'DEP_ID'], 'safe'],
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
        $query = Docdba::find();

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
            'CREATED_DATE' => $this->CREATED_DATE,
            'STATUS' => $this->STATUS,
            'USER_CREATED' => $this->USER_CREATED,
            'SORT' => $this->SORT,
        ]);
	
        $query->andFilterWhere(['like', 'MDL_ID', $this->MDL_ID])
            ->andFilterWhere(['like', 'MDL_NM', $this->MDL_NM])
            ->andFilterWhere(['like', 'MDL_DB', $this->MDL_DB])
            ->andFilterWhere(['like', 'MDL_DB_ALIAS', $this->MDL_DB_ALIAS])
            ->andFilterWhere(['like', 'MDL_TBL', $this->MDL_TBL])
            ->andFilterWhere(['like', 'MDL_KEY', $this->MDL_KEY])
            ->andFilterWhere(['like', 'MDL_FLD', $this->MDL_FLD])
            ->andFilterWhere(['like', 'MDL_CLS', $this->MDL_CLS])
            ->andFilterWhere(['like', 'MDL_LINK', $this->MDL_LINK])
            ->andFilterWhere(['like', 'DSCRP', $this->DSCRP])
            ->andFilterWhere(['like', 'CORP_ID', $this->CORP_ID])
            ->andFilterWhere(['like', 'DEP_ID', $this->DEP_ID]);
			
		$query->orderby(['SORT'=>SORT_ASC]);
        return $dataProvider;
    }
}
