<?php

namespace lukisongroup\models\hrd;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
//use lukisongroup\models\hrd\Jobgrademodul;

/**
 * JobgrademodulSearch represents the model behind the search form about `lukisongroup\models\hrd\Jobgrademodul`.
 */
class JobgrademodulSearch extends Jobgrademodul
{
	/*	[2] RELATED ATTRIBUTE JOIN TABLE*/
	public function attributes()
	{
		/*Author -ptr.nov- add related fields to searchable attributes */
		return array_merge(parent::attributes(), ['groupfunction.GF_NM','groupseqmen.SEQ_NM']);
	}
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'GF_ID', 'SEQ_ID', 'SORT', 'JOBGRADE_STS'], 'integer'],
            [['JOBGRADE_ID', 'JOBGRADE_NM', 'JOBGRADE_DCRP','groupfunction.GF_NM','groupseqmen.SEQ_NM'], 'safe'],
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
        $query = Jobgrademodul::find()
						 ->JoinWith('groupfunction',true,'left JOIN')						 
						 ->JoinWith('groupseqmen',true,'left JOIN')
						 ->andWhere(['u0003m.JOBGRADE_STS'=> !3]);
						 //->Where('u0003m.JOBGRADE_STS<>3');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);      
		
		/* SORTING Group Function Author -ptr.nov-*/
		$dataProvider->sort->attributes['groupfunction.GF_NM'] = [
			'asc' => ['u0003a.GF_NM' => SORT_ASC],
			'desc' => ['u0003a.GF_NM' => SORT_DESC],
		];
		
		/* SORTING Group Seqment Author -ptr.nov-*/
		$dataProvider->sort->attributes['groupseqmen.SEQ_NM'] = [
			'asc' => ['u0003b.SEQ_NM' => SORT_ASC],
			'desc' => ['u0003b.SEQ_NM' => SORT_DESC],
		];
		$this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
		$query->andFilterWhere(['like', 'JOBGRADE_ID',  $this->JOBGRADE_ID])
					->andFilterWhere(['like', 'JOBGRADE_NM',  $this->JOBGRADE_NM])
					->andFilterWhere(['like', 'u0003a.GF_NM', $this->getAttribute('groupfunction.GF_NM')])
					->andFilterWhere(['like', 'u0003b.SEQ_NM', $this->getAttribute('groupseqmen.SEQ_NM')]);
					
        return $dataProvider;
    }
}
