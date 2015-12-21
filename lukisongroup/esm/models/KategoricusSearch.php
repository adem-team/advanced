<?php

namespace lukisongroup\esm\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\esm\models\Kategoricus;

/**
 * KategoricusSearch represents the model behind the search form about `lukisongroup\esm\models\Kategoricus`.
 */
class KategoricusSearch extends Kategoricus
{
     public function attributes()
    {
        /*Author -ptr.nov- add related fields to searchable attributes */
        return array_merge(parent::attributes(), ['customers_Kategori']);
    }
    /**
     * @inheritdoc
     */
    public $PRN_NM;
    public $customers_Kategori;
    public function rules()
    {
        return [
            [['CUST_KTG','PRN_NM','customers_Kategori', 'CUST_KTG_PARENT', 'STATUS'], 'integer'],
            [['CUST_KTG_NM', 'CREATED_BY', 'CREATED_AT', 'UPDATED_BY', 'UPDATED_AT'], 'safe'],
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

    // public function cust()
    // {

    // }
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
	 
	   //  public function searchparent($params)
    // {
        
    //     $query3 = Kategoricus::find()->where('STATUS <> 0')->andwhere('CUST_KTG_PARENT = 0');
    //     $dataProviderparent= new ActiveDataProvider([
    //         'query' => $query3,
    //     ]);

    //     $this->load($params);

    //     if (!$this->validate()) {
    //         // uncomment the following line if you do not want to return any records when validation fails
    //         // $query->where('0=1');
    //         return $dataProviderparent;
    //     }

    //        $query3->andFilterWhere([
    //         'CUST_KTG' => $this->CUST_KTG,
    //         'CUST_KTG_PARENT' => $this->CUST_KTG_PARENT,
    //         // 'CREATED_AT' => $this->CREATED_AT,
    //         // 'UPDATED_AT' => $this->UPDATED_AT,
    //         'STATUS' => $this->STATUS,
    //     ]);

    //     $query3->andFilterWhere(['like', 'CUST_KTG_NM', $this->CUST_KTG_NM]);
    //         // ->andFilterWhere(['like', 'CREATED_BY', $this->CREATED_BY])
    //         // ->andFilterWhere(['like', 'UPDATED_BY', $this->UPDATED_BY]);

    //     return $dataProviderparent;
    // }
	
    public function search($params)
    {
        $sql = "SELECT b.CUST_KTG as CUST_KTG, b.CUST_KTG_NM as PRN_NM,a.CUST_KTG as CUS_ID, 
                                            a.CUST_KTG_NM as customers_Kategori, a.CUST_KTG_PARENT as CUS_Prn  from 
                                            (select * FROM c0001k WHERE CUST_KTG_PARENT<>0) a INNER JOIN
                                            (select * FROM c0001k WHERE CUST_KTG_PARENT= 0) b on a.CUST_KTG_PARENT=b.CUST_KTG
                                            ORDER BY b.CUST_KTG";

        $query = Kategoricus::findBySql($sql);
        // print_r($query);
        // die();
                                            //->where('STATUS <> 3');
             

        $dataProviderkat = new ActiveDataProvider([
            'query' => $query,
        ]);

         $dataProviderkat->sort->attributes['customers_Kategori'] = [
                'asc' => ['a.CUST_KTG_NM ' => SORT_ASC],
                'desc' => ['a.CUST_KTG_NM ' => SORT_DESC],
            ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProviderkat;
        }

        // $query->andFilterWhere([
        //     'customers_Kategori' => $this->CUST_KTG_NM,
        //     // 'CUST_KTG_PARENT' => $this->CUST_KTG_PARENT,
        //     // 'CREATED_AT' => $this->CREATED_AT,
        //     // 'UPDATED_AT' => $this->UPDATED_AT,
        //     // 'STATUS' => $this->STATUS,
        // ]);

        $query->andFilterWhere(['like', 'a.CUST_KTG_NM', $this->getAttribute('customers_Kategori')]);
             // ->andFilterWhere(['like', 'c0001k.CUST_KTG_NM', $this->getAttribute('cus.CUST_KTG_NM')])
            // ->andFilterWhere(['like', 'UPDATED_BY', $this->UPDATED_BY]);

        return $dataProviderkat;
    }
}
