<?php

namespace lukisongroup\purchasing\models\data_term;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;


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
            [['CREATED_AT', 'UPDATED_AT'], 'safe']
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
			/**
			  *search redirect accounting only RI and RID
				*@author wawan
				*/
        $query = Rtdetail::find()
				 ->JoinWith('termheader',true,'left JOIN')
				 ->where(['LIKE', 't0001detail.KD_RIB','RI'])
				 ->orwhere(['LIKE', 't0001detail.KD_RIB','RID']);

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
