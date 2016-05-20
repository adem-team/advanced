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
     public $corpnnm;
     public $corpnm;
     public $deptnm;
     public $deptmn;
     public $corphistory;
     public $depthistory;
     public function attributes()
   	{
   		/*Author -ptr.nov- add related fields to searchable attributes */
   		return array_merge(parent::attributes(), ['corpnnm','deptnm','corpnm','deptmn','depthistory','corphistory']);
   	}
    public function rules()
    {
        return [
            [['ID', 'STATUS'], 'integer'],
            [['KD_BERITA','JUDUL','corpnm','deptmn','ISI', 'KD_CORP','corpnnm','deptnm','depthistory','corphistory', 'KD_CAB', 'KD_DEP', 'DATA_PICT', 'DATA_FILE', 'CREATED_ATCREATED_BY','CREATED_AT','CREATE_AT', 'CREATED_BY', 'UPDATE_AT', 'DATA_ALL','KD_REF'], 'safe'],
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
    public function searchBeritaInbox($params)
    {
        $profile = Yii::$app->getUserOpt->profile_user(); //componen
        $emp_id = $profile->EMP_ID;
        $dep_id = $profile->emp->DEP_ID;

        $query = Berita::find()->where('USER_CC like "%'.$emp_id.'%"OR KD_DEP="'.$dep_id.'" AND STATUS<>0');

						/*  ->where(['OR',
                          ['USER_CC'=>$emp_id],
                          ['KD_DEP'=>"0"],
                          ['KD_DEP'=>$dep_id],
                          ])->andwhere('STATUS<>0'); */


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
            ->andFilterWhere(['like', 'KD_CORP', $this->corpnnm])
            ->andFilterWhere(['like', 'KD_CAB', $this->KD_CAB])
            ->andFilterWhere(['like', 'KD_DEP', $this->deptnm])
            ->andFilterWhere(['like', 'DATA_PICT', $this->DATA_PICT])
            ->andFilterWhere(['like', 'DATA_FILE', $this->DATA_FILE])
            ->andFilterWhere(['like', 'CREATED_BY', $this->CREATED_BY])
            ->andFilterWhere(['like', 'DATA_ALL', $this->DATA_ALL]);

        return $dataProvider;
    }

    public function searchBeritaOutbox($params)
    {
        $profile = Yii::$app->getUserOpt->profile_user(); //componen
        $emp_id = $profile->EMP_ID;
        $query = Berita::find()->where(['CREATED_BY'=>$emp_id])
                               ->andwhere('STATUS<>0');

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
            'CREATED_ATCREATED_BY' => $this->CREATED_AT,
            'UPDATE_AT' => $this->UPDATE_AT,
        ]);

        $query->andFilterWhere(['like', 'KD_BERITA', $this->KD_BERITA])
            ->andFilterWhere(['like', 'JUDUL', $this->JUDUL])
            ->andFilterWhere(['like', 'ISI', $this->ISI])
            ->andFilterWhere(['like', 'KD_CORP', $this->corpnm])
            ->andFilterWhere(['like', 'KD_CAB', $this->KD_CAB])
            ->andFilterWhere(['like', 'KD_DEP', $this->deptmn])
            ->andFilterWhere(['like', 'DATA_PICT', $this->DATA_PICT])
            ->andFilterWhere(['like', 'DATA_FILE', $this->DATA_FILE])
            ->andFilterWhere(['like', 'CREATED_BY', $this->CREATED_BY])
            ->andFilterWhere(['like', 'DATA_ALL', $this->DATA_ALL]);

        return $dataProvider;
    }

    public function searchBeritaClose($params)
    {
        $query = Berita::find()->where('STATUS<>1');

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
            'CREATED_ATCREATED_BY' => $this->CREATE_AT,
            'UPDATE_AT' => $this->UPDATE_AT,
        ]);

        $query->andFilterWhere(['like', 'KD_BERITA', $this->KD_BERITA])
            ->andFilterWhere(['like', 'JUDUL', $this->JUDUL])
            ->andFilterWhere(['like', 'ISI', $this->ISI])
            ->andFilterWhere(['like', 'KD_CORP', $this->corphistory])
            ->andFilterWhere(['like', 'KD_CAB', $this->KD_CAB])
            ->andFilterWhere(['like', 'KD_DEP', $this->depthistory])
            ->andFilterWhere(['like', 'DATA_PICT', $this->DATA_PICT])
            ->andFilterWhere(['like', 'DATA_FILE', $this->DATA_FILE])
            ->andFilterWhere(['like', 'CREATED_BY', $this->CREATED_BY])
            ->andFilterWhere(['like', 'DATA_ALL', $this->DATA_ALL]);

        return $dataProvider;
    }
}
