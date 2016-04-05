<?php

namespace lukisongroup\purchasing\models\pr;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\purchasing\models\pr\Purchaseorder;
use lukisongroup\hrd\models\Employe;

/**
 * PurchaseorderSearch represents the model behind the search form about `lukisongroup\models\esm\po\Purchaseorder`.
 */
class PurchaseorderSearch extends Purchaseorder
{

    public $pembuat;
    public $disetujui;
    public $approved;
	public $namasuplier;
	public $nmcorp;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['STATUS'], 'integer'],
            [['KD_PO', 'KD_SUPPLIER', 'CREATE_BY', 'CREATE_AT', 'NOTE','PAJAK','DISCOUNT','ETD', 'ETA', 'SHIPPING', 'BILLING', 'DELIVERY_COST', 'namasuplier'], 'safe'],
            [['nmcorp','SIG1_NM','SIG2_NM','SIG3_NM','SIG4_NM'], 'safe'],
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

    public function searchpoOutbox($params)
      {
        $profile=Yii::$app->getUserOpt->Profile_user();
    		$id = $profile->emp->EMP_ID;
          $query = Purchaseorder::find()->where(['p0001.CREATE_BY'=>$id])
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
               ->andFilterWhere(['like', 'p0001.KD_CORP', $this->nmcorp]);

       if($this->CREATE_AT!=''){
               $date_explode = explode(' - ', $this->CREATE_AT);
               $date1 = trim($date_explode[0]);
               $date2= trim($date_explode[1]);
               $query->andFilterWhere(['between','CREATE_AT', $date1,$date2]);
           }


    		return $dataprovider;
        }

      /**
       * Creates data provider instance with search query applied
       *
       * @param array $params
       *
       * @return ActiveDataProvider
       */
      // public function search($params)
      // {
      //     $query = Purchaseorder::find()->orderBy(['CREATE_AT'=> SORT_DESC]);
  		// $query->joinWith(['suplier' => function ($q) {
      //         $q->where('s1000.NM_SUPPLIER LIKE "%' . $this->namasuplier . '%"');
      //     }]);
      //
      //    /*  $query->joinWith(['employe' => function ($q) {
      //         $q->where('a0001.EMP_NM LIKE "%' . $this->pembuat . '%"');
      //     }]);
      //
      //     $query->joinWith(['employe' => function ($q) {
      //         $q->where('a0001.EMP_NM LIKE "%' . $this->disetujui . '%"');
      //     }]);
      //
      //     $query->joinWith(['employe' => function ($q) {
      //         $q->where('a0001.EMP_NM LIKE "%' . $this->approved . '%"');
      //     }]); */
      //
      //     $dataProvider = new ActiveDataProvider([
      //         'query' => $query,
  		// 	'pagination' => [
  		// 			'pageSize' => 10,
  		// 		],
      //     ]);
      //
      //      $dataProvider->setSort([
      //         'attributes' => [
      //         'KD_PO',
      //         //'KD_SUPPLIER',
      //
      //         /* 'pembuat' => [
      //             'asc' => ['a0001.EMP_NM' => SORT_ASC],
      //             'desc' => ['a0001.EMP_NM' => SORT_DESC],
      //             'label' => 'Pembuat',
      //         ],
      //
      //         'disetujui' => [
      //             'asc' => ['a0001.EMP_NM' => SORT_ASC],
      //             'desc' => ['a0001.EMP_NM' => SORT_DESC],
      //             'label' => 'Pembuat',
      //         ],
      //
      //         'approved' => [
      //             'asc' => ['a0001.EMP_NM' => SORT_ASC],
      //             'desc' => ['a0001.EMP_NM' => SORT_DESC],
      //             'label' => 'Pembuat',
      //         ],    */
      //
      //         ]
      //     ]);
      //
      //     if (!($this->load($params) && $this->validate())) {
      //         return $dataProvider;
      //     }
      //
      //     $query->andFilterWhere([
      //         'STATUS' => $this->STATUS,
      //     ]);
      //
      //     $query->andFilterWhere(['like', 'KD_PO', $this->KD_PO])
  		// 	//->andFilterWhere(['like', 'KD_SUPPLIER', $this->KD_SUPPLIER])
      //         ->andFilterWhere(['like', 'SIG1_NM', $this->SIG1_NM])
      //         ->andFilterWhere(['like', 'SIG2_NM', $this->SIG2_NM])
      //         ->andFilterWhere(['like', 'SIG3_NM', $this->SIG3_NM])
      //         ->andFilterWhere(['like', 'SIG4_NM', $this->SIG4_NM])
      //         ->andFilterWhere(['like', 'CREATE_BY', $this->CREATE_BY])
      //         ->andFilterWhere(['like', 'p0001.KD_CORP', $this->nmcorp]);
      //
  		// if($this->CREATE_AT!=''){
      //         $date_explode = explode(' - ', $this->CREATE_AT);
      //         $date1 = trim($date_explode[0]);
      //         $date2= trim($date_explode[1]);
      //         $query->andFilterWhere(['between','CREATE_AT', $date1,$date2]);
      //     }
      //     return $dataProvider;
      //
      // }

  	/*
  	 * INBOX RO
  	 * ACTION CHECKED | APPROVAL
  	 * @author ptrnov [piter@lukison]
  	 * @since 1.2
  	*/
  	public function searchPoInbox($params)
      {
  		$profile=Yii::$app->getUserOpt->Profile_user();
  		if($profile->emp->GF_ID == 3  ){
  			$query = Purchaseorder::find()->where('STATUS <> 0');
      }elseif($profile->emp->GF_ID == 1 || $profile->emp->GF_ID == 2){
  			$query = Purchaseorder::find()->where('STATUS = 101 OR STATUS = 102');
  		}
      else{

        $query = Purchaseorder::find()->orderBy(['CREATE_AT'=> SORT_DESC]);
    		$query->joinWith(['suplier' => function ($q) {
                $q->where('s1000.NM_SUPPLIER LIKE "%' . $this->namasuplier . '%"');
            }]);

      }

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
             ->andFilterWhere(['like', 'p0001.KD_CORP', $this->nmcorp]);

     if($this->CREATE_AT!=''){
             $date_explode = explode(' - ', $this->CREATE_AT);
             $date1 = trim($date_explode[0]);
             $date2= trim($date_explode[1]);
             $query->andFilterWhere(['between','CREATE_AT', $date1,$date2]);
         }


  		return $dataProvider;
      }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchpoesm($params)
    {
        $query = Purchaseorder::find()->where(['p0001.KD_CORP' => 'ESM' ]);
        $query->joinWith(['suplier' => function ($q) {
                $q->where('s1000.NM_SUPPLIER LIKE "%' . $this->namasuplier . '%"');
            }]);


       /*  $query->joinWith(['employe' => function ($q) {
            $q->where('a0001.EMP_NM LIKE "%' . $this->pembuat . '%"');
        }]);

        $query->joinWith(['employe' => function ($q) {
            $q->where('a0001.EMP_NM LIKE "%' . $this->disetujui . '%"');
        }]);

        $query->joinWith(['employe' => function ($q) {
            $q->where('a0001.EMP_NM LIKE "%' . $this->approved . '%"');
        }]); */

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
					'pageSize' => 10,
				],
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
            ->andFilterWhere(['like', 'p0001.KD_CORP', $this->nmcorp]);

		if($this->CREATE_AT!=''){
            $date_explode = explode(' - ', $this->CREATE_AT);
            $date1 = trim($date_explode[0]);
            $date2= trim($date_explode[1]);
            $query->andFilterWhere(['between','CREATE_AT', $date1,$date2]);
        }
        return $dataProvider;
    }

    public function searchbeverage($params)
    {
        $query = Purchaseorder::find()->where(['p0001.KD_CORP' => 'MM' ]);
        $query->joinWith(['suplier' => function ($q) {
                $q->where('s1000.NM_SUPPLIER LIKE "%' . $this->namasuplier . '%"');
            }]);


       /*  $query->joinWith(['employe' => function ($q) {
            $q->where('a0001.EMP_NM LIKE "%' . $this->pembuat . '%"');
        }]);

        $query->joinWith(['employe' => function ($q) {
            $q->where('a0001.EMP_NM LIKE "%' . $this->disetujui . '%"');
        }]);

        $query->joinWith(['employe' => function ($q) {
            $q->where('a0001.EMP_NM LIKE "%' . $this->approved . '%"');
        }]); */

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
      'pagination' => [
          'pageSize' => 10,
        ],
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
            ->andFilterWhere(['like', 'p0001.KD_CORP', $this->nmcorp]);

    if($this->CREATE_AT!=''){
            $date_explode = explode(' - ', $this->CREATE_AT);
            $date1 = trim($date_explode[0]);
            $date2= trim($date_explode[1]);
            $query->andFilterWhere(['between','CREATE_AT', $date1,$date2]);
        }
        return $dataProvider;
    }

    public function searchLG($params)
    {
        $query = Purchaseorder::find()->where(['p0001.KD_CORP' => 'LG' ]);
        $query->joinWith(['suplier' => function ($q) {
                $q->where('s1000.NM_SUPPLIER LIKE "%' . $this->namasuplier . '%"');
            }]);


       /*  $query->joinWith(['employe' => function ($q) {
            $q->where('a0001.EMP_NM LIKE "%' . $this->pembuat . '%"');
        }]);

        $query->joinWith(['employe' => function ($q) {
            $q->where('a0001.EMP_NM LIKE "%' . $this->disetujui . '%"');
        }]);

        $query->joinWith(['employe' => function ($q) {
            $q->where('a0001.EMP_NM LIKE "%' . $this->approved . '%"');
        }]); */

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
      'pagination' => [
          'pageSize' => 10,
        ],
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
            ->andFilterWhere(['like', 'p0001.KD_CORP', $this->nmcorp]);

    if($this->CREATE_AT!=''){
            $date_explode = explode(' - ', $this->CREATE_AT);
            $date1 = trim($date_explode[0]);
            $date2= trim($date_explode[1]);
            $query->andFilterWhere(['between','CREATE_AT', $date1,$date2]);
        }
        return $dataProvider;
    }

    public function searchSSS($params)
    {
        $query = Purchaseorder::find()->where(['p0001.KD_CORP' => 'SSS' ]);
        $query->joinWith(['suplier' => function ($q) {
                $q->where('s1000.NM_SUPPLIER LIKE "%' . $this->namasuplier . '%"');
            }]);


       /*  $query->joinWith(['employe' => function ($q) {
            $q->where('a0001.EMP_NM LIKE "%' . $this->pembuat . '%"');
        }]);

        $query->joinWith(['employe' => function ($q) {
            $q->where('a0001.EMP_NM LIKE "%' . $this->disetujui . '%"');
        }]);

        $query->joinWith(['employe' => function ($q) {
            $q->where('a0001.EMP_NM LIKE "%' . $this->approved . '%"');
        }]); */

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
      'pagination' => [
          'pageSize' => 10,
        ],
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
            ->andFilterWhere(['like', 'p0001.KD_CORP', $this->nmcorp]);

    if($this->CREATE_AT!=''){
            $date_explode = explode(' - ', $this->CREATE_AT);
            $date1 = trim($date_explode[0]);
            $date2= trim($date_explode[1]);
            $query->andFilterWhere(['between','CREATE_AT', $date1,$date2]);
        }
        return $dataProvider;
    }

    public function searchGSN($params)
    {
        $query = Purchaseorder::find()->where(['p0001.KD_CORP' => 'GSN' ]);
        $query->joinWith(['suplier' => function ($q) {
                $q->where('s1000.NM_SUPPLIER LIKE "%' . $this->namasuplier . '%"');
            }]);


       /*  $query->joinWith(['employe' => function ($q) {
            $q->where('a0001.EMP_NM LIKE "%' . $this->pembuat . '%"');
        }]);

        $query->joinWith(['employe' => function ($q) {
            $q->where('a0001.EMP_NM LIKE "%' . $this->disetujui . '%"');
        }]);

        $query->joinWith(['employe' => function ($q) {
            $q->where('a0001.EMP_NM LIKE "%' . $this->approved . '%"');
        }]); */

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
      'pagination' => [
          'pageSize' => 10,
        ],
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
            ->andFilterWhere(['like', 'p0001.KD_CORP', $this->nmcorp]);

    if($this->CREATE_AT!=''){
            $date_explode = explode(' - ', $this->CREATE_AT);
            $date1 = trim($date_explode[0]);
            $date2= trim($date_explode[1]);
            $query->andFilterWhere(['between','CREATE_AT', $date1,$date2]);
        }
        return $dataProvider;
    }
    public function searchALG($params)
    {
        $query = Purchaseorder::find()->where(['p0001.KD_CORP' => 'ALG' ]);
        $query->joinWith(['suplier' => function ($q) {
                $q->where('s1000.NM_SUPPLIER LIKE "%' . $this->namasuplier . '%"');
            }]);


       /*  $query->joinWith(['employe' => function ($q) {
            $q->where('a0001.EMP_NM LIKE "%' . $this->pembuat . '%"');
        }]);

        $query->joinWith(['employe' => function ($q) {
            $q->where('a0001.EMP_NM LIKE "%' . $this->disetujui . '%"');
        }]);

        $query->joinWith(['employe' => function ($q) {
            $q->where('a0001.EMP_NM LIKE "%' . $this->approved . '%"');
        }]); */

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
      'pagination' => [
          'pageSize' => 10,
        ],
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
            ->andFilterWhere(['like', 'p0001.KD_CORP', $this->nmcorp]);

    if($this->CREATE_AT!=''){
            $date_explode = explode(' - ', $this->CREATE_AT);
            $date1 = trim($date_explode[0]);
            $date2= trim($date_explode[1]);
            $query->andFilterWhere(['between','CREATE_AT', $date1,$date2]);
        }
        return $dataProvider;
    }
}
