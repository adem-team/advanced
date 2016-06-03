<?php

namespace lukisongroup\sistem\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\sistem\models\HelpDesk;
use lukisongroup\hrd\models\Employe;
use lukisongroup\purchasing\models\pr\Purchaseorder;

/**
 * HelpDeskSearch represents the model behind the search form about `lukisongroup\sistem\models\HelpDeskPoSearch`.
 */
class HelpDeskSearch extends HelpDesk
{

    public $pembuat;
    public $disetujui;
    public $approved;
	  public $namasuplier;
	  public $nmcorp;
    public $nmcorphistory;
    public $nmcorpoutbox;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['STATUS'], 'integer'],
            [['KD_PO', 'KD_SUPPLIER', 'CREATE_BY','CREATE_AT1','CREATE_AT2','CREATE_AT', 'NOTE','PAJAK','DISCOUNT','ETD', 'ETA', 'SHIPPING', 'BILLING', 'DELIVERY_COST', 'namasuplier'], 'safe'],
            [['nmcorp','SIG1_NM','SIG2_NM','SIG3_NM','SIG4_NM','nmcorphistory','nmcorpoutbox'], 'safe'],
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

    public function searchproses($params)
      {
          $query = Purchaseorder::find()->where('p0001.STATUS = 100')
                                        ->orderBy(['CREATE_AT'=> SORT_DESC]);

          $query->joinWith(['suplier' => function ($q) {
                  $q->where('s1000.NM_SUPPLIER LIKE "%' . $this->namasuplier . '%"');
              }]);


    		$dataprovider = new ActiveDataProvider([
                'query' => $query,
            ]);

            $dataprovider->setSort([
               'attributes' => [
               'KD_PO',
               //'KD_SUPPLIER',

               /* 'pembuat' => [
                   'asc' => ['a0001.EMP_NM' => SORT_ASC],
                   'desc' => ['a0001.EMP_NM' => SORT_DESC],
                   'label' => 'Pembuat',
               ],

               'disetujui' => [
                   'asc' => ['a0001.EMP_NM' => SORT_ASC],
                   'desc' => ['a0001.EMP_NM' => SORT_DESC],
                   'label' => 'Pembuat',
               ],

               'approved' => [
                   'asc' => ['a0001.EMP_NM' => SORT_ASC],
                   'desc' => ['a0001.EMP_NM' => SORT_DESC],
                   'label' => 'Pembuat',
               ],    */

               ]
           ]);

           if (!($this->load($params) && $this->validate())) {
               return $dataprovider;
           }

           $query->andFilterWhere([
               'STATUS' => $this->STATUS,
           ]);

           $query->andFilterWhere(['like', 'KD_PO', $this->KD_PO])
         //->andFilterWhere(['like', 'KD_SUPPLIER', $this->KD_SUPPLIER])
               ->andFilterWhere(['like', 'SIG1_NM', $this->SIG1_NM])
               ->andFilterWhere(['like', 'SIG2_NM', $this->SIG2_NM])
               ->andFilterWhere(['like', 'SIG3_NM', $this->SIG3_NM])
               ->andFilterWhere(['like', 'SIG4_NM', $this->SIG4_NM])
               ->andFilterWhere(['like', 'CREATE_BY', $this->CREATE_BY])
               ->andFilterWhere(['like', 'p0001.KD_CORP', $this->nmcorpoutbox]);

               if($this->CREATE_AT1!=''){
                       $query->andFilterWhere(['like','CREATE_AT', $this->CREATE_AT1]);
                   }



    		return $dataprovider;
        }

        /*
      	 * Tab History PO
      	 * APPROVAL
      	 * @author wawan
      	 * @since 1.2
      	*/
      	public function searchchecked($params)
          {

            $query = Purchaseorder::find()->where('p0001.STATUS = 101')->orderBy(['CREATE_AT'=> SORT_DESC]);
        		$query->joinWith(['suplier' => function ($q) {
                    $q->where('s1000.NM_SUPPLIER LIKE "%' . $this->namasuplier . '%"');
                }]);

      		$dataProvider = new ActiveDataProvider([
                  'query' => $query,
              ]);

              $dataProvider->setSort([
                 'attributes' => [
                 'KD_PO',
                 //'KD_SUPPLIER',

                 /* 'pembuat' => [
                     'asc' => ['a0001.EMP_NM' => SORT_ASC],
                     'desc' => ['a0001.EMP_NM' => SORT_DESC],
                     'label' => 'Pembuat',
                 ],

                 'disetujui' => [
                     'asc' => ['a0001.EMP_NM' => SORT_ASC],
                     'desc' => ['a0001.EMP_NM' => SORT_DESC],
                     'label' => 'Pembuat',
                 ],

                 'approved' => [
                     'asc' => ['a0001.EMP_NM' => SORT_ASC],
                     'desc' => ['a0001.EMP_NM' => SORT_DESC],
                     'label' => 'Pembuat',
                 ],    */

                 ]
             ]);

             if (!($this->load($params) && $this->validate())) {
                 return $dataProvider;
             }

             $query->andFilterWhere([
                 'STATUS' => $this->STATUS,
             ]);

             $query->andFilterWhere(['like', 'KD_PO', $this->KD_PO])
           //->andFilterWhere(['like', 'KD_SUPPLIER', $this->KD_SUPPLIER])
                 ->andFilterWhere(['like', 'SIG1_NM', $this->SIG1_NM])
                 ->andFilterWhere(['like', 'SIG2_NM', $this->SIG2_NM])
                 ->andFilterWhere(['like', 'SIG3_NM', $this->SIG3_NM])
                 ->andFilterWhere(['like', 'SIG4_NM', $this->SIG4_NM])
                 ->andFilterWhere(['like', 'CREATE_BY', $this->CREATE_BY])
                 ->andFilterWhere(['like', 'p0001.KD_CORP', $this->nmcorphistory]);

         if($this->CREATE_AT!=''){

                 $query->andFilterWhere(['like','CREATE_AT', $this->CREATE_AT]);
             }


      		return $dataProvider;
          }


  	/*
  	 * INBOX PO
  	 * ACTION CHECKED | APPROVAL
  	 * @author ptrnov [piter@lukison]
  	 * @since 1.2
  	*/
  	public function searchapproval($params)
      {

  			$query = Purchaseorder::find()->where('STATUS = 102');

    		$dataProvider = new ActiveDataProvider([
                'query' => $query,
            ]);

            $dataProvider->setSort([
               'attributes' => [
               'KD_PO',
             //'KD_SUPPLIER',

             /* 'pembuat' => [
                 'asc' => ['a0001.EMP_NM' => SORT_ASC],
                 'desc' => ['a0001.EMP_NM' => SORT_DESC],
                 'label' => 'Pembuat',
             ],

             'disetujui' => [
                 'asc' => ['a0001.EMP_NM' => SORT_ASC],
                 'desc' => ['a0001.EMP_NM' => SORT_DESC],
                 'label' => 'Pembuat',
             ],

             'approved' => [
                 'asc' => ['a0001.EMP_NM' => SORT_ASC],
                 'desc' => ['a0001.EMP_NM' => SORT_DESC],
                 'label' => 'Pembuat',
             ],    */

             ]
         ]);

         if (!($this->load($params) && $this->validate())) {
             return $dataProvider;
         }

         $query->andFilterWhere([
             'STATUS' => $this->STATUS,
         ]);

         $query->andFilterWhere(['like', 'KD_PO', $this->KD_PO])
             ->andFilterWhere(['like', 'SIG1_NM', $this->SIG1_NM])
             ->andFilterWhere(['like', 'SIG2_NM', $this->SIG2_NM])
             ->andFilterWhere(['like', 'SIG3_NM', $this->SIG3_NM])
             ->andFilterWhere(['like', 'SIG4_NM', $this->SIG4_NM])
             ->andFilterWhere(['like', 'CREATE_BY', $this->CREATE_BY])
             ->andFilterWhere(['like', 'p0001.KD_CORP', $this->nmcorp]);

             if($this->CREATE_AT2!=''){
                     $query->andFilterWhere(['like','CREATE_AT', $this->CREATE_AT2]);
                 }


  		return $dataProvider;
      }

}
