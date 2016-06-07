<?php

namespace lukisongroup\purchasing\models\data_term;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\purchasing\models\data_term\Termheader;
use lukisongroup\purchasing\models\data_term\Requesttermheader;

/**
 * TermheaderSearch represents the model behind the search form about `lukisongroup\master\models\Termheader`.
 */
class TermheaderSearch extends Termheader
{
    /**
     * @inheritdoc
     */

	/* public function attributes()
	{
		//Author -ptr.nov- add related fields to searchable attributes
		return array_merge(parent::attributes(), ['cus.CUST_NM','dis.NM_DISTRIBUTOR','corp.CORP_NM']);
	} */

    public function rules()
    {
        return [
            [[ 'STATUS'], 'integer'],
            [['GENERAL_TERM','CUST_KD_PARENT','PRINCIPAL_KD','DIST_KD','PERIOD_START', 'PERIOD_END', 'TARGET_TEXT', 'RABATE_CNDT', 'TOP', 'CREATED_BY', 'CREATED_AT', 'UPDATE_BY', 'UPDATE_AT'], 'safe'],
            [['TARGET_VALUE', 'GROWTH'], 'number'],
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
     public function searchcusbyid($params,$id)
     {

         $query = Termheader::find()->where(['TERM_ID'=>$id]);
        //  ->andwhere(['like','KD_RIB','RI'])->andwhere(['like','KD_RIB','RID']);

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
			 'CUST_KD_PARENT' => $this->CUST_KD_PARENT,
             'PERIOD_START' => $this->PERIOD_START,
             'PERIOD_END' => $this->PERIOD_END,
             'TARGET_VALUE' => $this->TARGET_VALUE,
             'GROWTH' => $this->GROWTH,
             'STATUS' => $this->STATUS,
             'CREATED_AT' => $this->CREATED_AT,
             'UPDATE_AT' => $this->UPDATE_AT,
         ]);

         $query->andFilterWhere(['like', 'CUST_KD_PARENT', $this->CUST_KD_PARENT])
			 ->andFilterWhere(['like', 'CUST_KD_PARENT', $this->CUST_KD_PARENT])
             ->andFilterWhere(['like', 'PRINCIPAL_KD', $this->PRINCIPAL_KD])
             ->andFilterWhere(['like', 'DIST_KD', $this->DIST_KD])
             ->andFilterWhere(['like', 'TARGET_TEXT', $this->TARGET_TEXT])
             ->andFilterWhere(['like', 'RABATE_CNDT', $this->RABATE_CNDT])
             ->andFilterWhere(['like', 'TOP', $this->TOP])
             ->andFilterWhere(['like', 'CREATED_BY', $this->CREATED_BY])
             ->andFilterWhere(['like', 'UPDATE_BY', $this->UPDATE_BY]);

         return $dataProvider;
     }

    public function search($params)
    {
      	$profile=Yii::$app->getUserOpt->Profile_user();

        if($profile->emp->DEP_ID == 'GM'|| $profile->emp->DEP_ID == 'DRC')
          {
            $query = Termheader::find()->where('STATUS = 101 OR STATUS = 102');
          }
        elseif($profile->emp->DEP_ID == 'ACT')
        {
            $query = Termheader::find();
        }else{
              $query = Termheader::find()->where(['CREATED_BY'=>$profile->username]);
          }


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
            'PERIOD_START' => $this->PERIOD_START,
            'PERIOD_END' => $this->PERIOD_END,
            'TARGET_VALUE' => $this->TARGET_VALUE,
            'GROWTH' => $this->GROWTH,
            'STATUS' => $this->STATUS,
            'CREATED_AT' => $this->CREATED_AT,
            'UPDATE_AT' => $this->UPDATE_AT,
        ]);

        $query->andFilterWhere(['like', 'CUST_KD_PARENT', $this->CUST_KD_PARENT])
            ->andFilterWhere(['like', 'PRINCIPAL_KD', $this->PRINCIPAL_KD])
            ->andFilterWhere(['like', 'DIST_KD', $this->DIST_KD])
            ->andFilterWhere(['like', 'TARGET_TEXT', $this->TARGET_TEXT])
            ->andFilterWhere(['like', 'RABATE_CNDT', $this->RABATE_CNDT])
            ->andFilterWhere(['like', 'TOP', $this->TOP])
            ->andFilterWhere(['like', 'CREATED_BY', $this->CREATED_BY])
            ->andFilterWhere(['like', 'UPDATE_BY', $this->UPDATE_BY]);

        return $dataProvider;
    }
}
