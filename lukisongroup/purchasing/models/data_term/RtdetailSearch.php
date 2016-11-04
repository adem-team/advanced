<?php

namespace lukisongroup\purchasing\models\data_term;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\debug\components\search\Filter;
use yii\debug\components\search\matchers;


class RtdetailSearch extends Rtdetail
{
	public $termheader;
    /**
     * @inheritdoc
     */
	/* public function attributes()
	{
		//Author -ptr.nov- add related fields to searchable attributes
		return array_merge(parent::attributes(), ['termheader.TERM_ID']);
	} */

	public function rules()
    {
        return [
            [['ID','STATUS'], 'integer'],
			//[['termheader.TERM_ID','RQTY','SQTY'], 'safe'],
			[['RQTY','SQTY','label'], 'safe'],
            [['CREATED_AT', 'UPDATED_AT','TERM_ID','ID_INVEST','PERIODE_START'], 'safe']
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

    public function searchInvest($params,$term_id,$inves)
    {

         
        $connect = Yii::$app->db_esm;

            $sql = "SELECT c.INVES_TYPE,ti.PERIODE_START,ti.PERIODE_END,ti.PPN,ti.PPH23,ti.HARGA,ti.INVESTASI_PROGRAM FROM `t0001detail` ti
                    LEFT JOIN t0001header th on ti.KD_RIB = th.KD_RIB
                    LEFT JOIN c0006 c on ti.ID_INVEST = c.ID
                    WHERE ti.TERM_ID ='".$term_id."'
                    AND ti.ID_INVEST ='".$inves."'
                    AND ti.STATUS = 102
                    AND (ti.KD_RIB LIKE 'RID%' OR ti.KD_RIB LIKE 'RI%')";
         $hasil = $connect->createCommand($sql)->queryAll();


        $dataProviderBudgetdetail_inves = new ArrayDataProvider([
                    'allModels' => $hasil,
                    'pagination' => [
                        'pageSize' => 10,
                    ],
                ]);

          $this->load($params);


          // $filter = new Filter();
          // $this->addCondition($filter, 'PERIODE_START', true);
          // $dataProviderBudgetdetail_inves->allModels = $filter->filter($hasil);

        
        return $dataProviderBudgetdetail_inves;

    }

    /**
     * SEARCEH FILTER
     * @author Piter Novian [ptr.nov@gmail.com]
    */
    public function addCondition(Filter $filter, $attribute, $partial = false)
    {
        $value = $this->$attribute;


        if (mb_strpos($value, '>') !== false) {
            $value = intval(str_replace('>', '', $value));
            $filter->addMatcher($attribute, new matchers\GreaterThan(['value' => $value]));

        } elseif (mb_strpos($value, '<') !== false) {
            $value = intval(str_replace('<', '', $value));
            $filter->addMatcher($attribute, new matchers\LowerThan(['value' => $value]));
        } else {
            $filter->addMatcher($attribute, new matchers\SameAs(['value' => $value, 'partial' => $partial]));
        }
    }


	/**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params,$id)
    {

			/**
			  *search redirect accounting only RI and RID
				*@author wawan
				*/
     //    $query = Rtdetail::find()
				 // ->JoinWith('retermheader',true,'left JOIN')
				 // ->where(['t0001header.TERM_ID'=>$id])
				 // ->andwhere(['<>','t0001detail.STATUS',3])
				 // ->andwhere(['LIKE','t0001header.KD_RIB','RI'])
				 // ->andwhere(['LIKE', 't0001header.KD_RIB','RID']);
         $query = Rtdetail::find()
                 ->where(['TERM_ID'=>$id])
                 ->andwhere(['<>','STATUS',3])
                 ->andwhere(['LIKE','KD_RIB','RI'])
                 ->andwhere(['LIKE', 'KD_RIB','RID']);


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        //if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
         //   return $dataProvider;
        //}

        $query->andFilterWhere([
            'ID' => $this->ID,
            // 'TERM_ID' => 'asd123',
		    'STATUS' => $this->STATUS,
            'CREATED_AT' => $this->CREATED_AT,
            'UPDATED_AT' => $this->UPDATED_AT,
        ]);

              return $dataProvider;
    }


}
