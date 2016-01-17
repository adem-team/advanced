<?php

namespace lukisongroup\dashboard\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\master\models\Tipebarang;
use lukisongroup\master\models\Kategori;

/**
 * BarangSearch represents the model behind the search form about `app\models\esm\Barang`.
 */
class BarangSearch extends Barang
{
	public $nmsuplier;
    public $unitbrg;
    public $tipebrg;
	public $nmkategori;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['KD_CORP', 'KD_TYPE', 'KD_KATEGORI','KD_BARANG', 'NM_BARANG', 'KD_UNIT'], 'safe'],
            [['nmsuplier','unitbrg','tipebrg','nmkategori'], 'safe'],
            [['HARGA_SPL','HARGA_PABRIK', 'HARGA_LG','HARGA_DIST','HARGA_SALES'], 'safe'],			
			[['PARENT', 'STATUS'], 'integer'],
			[['BARCODE64BASE','KD_CAB','KD_DEP','DATA_ALL'], 'safe'],
            [['CREATED_BY','CREATED_AT','UPDATED_BY','UPDATED_AT'], 'safe'],
			[['image'], 'file', 'extensions'=>'jpg, gif, png'],
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
     * BARANG PRODUCTION ESM
     * PARENT = 1 [PRODUK]
     * @author ptrnov [piter@lukison.com]
     */
    public function searchBarangESM($params)
    {
        $query = Barang::find()->where('b0001.STATUS <> 3')->andWhere('b0001.PARENT=1')->andWhere('b0001.KD_CORP="ESM"');
		/* $query->joinWith(['sup' => function ($q) {
			$q->where('d0001.NM_DISTRIBUTOR LIKE "%' . $this->nmsuplier . '%"');
		}]); */
        $query->joinWith(['unitb' => function ($q) {
            $q->where('ub0001.NM_UNIT LIKE "%' . $this->unitbrg . '%"');
        }]);

        $query->joinWith(['tipebg' => function ($q) {
            $q->where('b1001.NM_TYPE LIKE "%' . $this->tipebrg . '%"');
        }]);

        $query->joinWith(['kategori' => function ($q) {
            $q->where('b1002.NM_KATEGORI LIKE "%' . $this->nmkategori . '%"');
        }]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
				'pageSize' => 20,
			],
        ]);

		 $dataProvider->setSort([
			'attributes' => [
                'KD_BARANG',
                'NM_BARANG',
               /* 'nmsuplier' => [
    				'asc' => ['d0001.NM_DISTRIBUTOR' => SORT_ASC],
    				'desc' => ['d0001.NM_DISTRIBUTOR' => SORT_DESC],
    				'label' => 'Supplier',
    			], */
    			
                'unitbrg' => [
                    'asc' => ['ub0001.NM_UNIT' => SORT_ASC],
                    'desc' => ['ub0001.NM_UNIT' => SORT_DESC],
                    'label' => 'Unit Barang',
                ],
                
                'tipebrg' => [
                    'asc' => ['dbc002.b1001.NM_TYPE' => SORT_ASC],
                    'desc' => ['dbc002.b1001.NM_TYPE' => SORT_DESC],
                    'label' => 'Tipe Barang',
                ],
                
    			'nmkategori' => [
    				'asc' => ['b1002.NM_KATEGORI' => SORT_ASC],
    				'desc' => ['b1002.NM_KATEGORI' => SORT_DESC],
    				'label' => 'Kategori',
    			],
    			
			]
		]);
		
		if (!($this->load($params) && $this->validate())) {
			/**
			 * The following line will allow eager loading with country data 
			 * to enable sorting by country on initial loading of the grid.
			 */ 
			return $dataProvider;
		}

        $query->andFilterWhere(['like', 'b0001.STATUS', $this->STATUS])
            ->andFilterWhere(['like', 'NM_BARANG', $this->NM_BARANG])
            ->andFilterWhere(['like', 'b0001.KD_BARANG', $this->KD_BARANG]);
        return $dataProvider;
    }	
	
	/**
     * BARANG PRODUCTION SSS
     * PARENT = 1 [PRODUK]
     * @author ptrnov [piter@lukison.com]
     */
    public function searchBarangSSS($params)
    {
        $query = Barang::find()->where('b0001.STATUS <> 3')->andWhere('b0001.PARENT=1')->andWhere('b0001.KD_CORP="SSS"');
		/* $query->joinWith(['sup' => function ($q) {
			$q->where('d0001.NM_DISTRIBUTOR LIKE "%' . $this->nmsuplier . '%"');
		}]); */
        $query->joinWith(['unitb' => function ($q) {
            $q->where('ub0001.NM_UNIT LIKE "%' . $this->unitbrg . '%"');
        }]);

        $query->joinWith(['tipebg' => function ($q) {
            $q->where('b1001.NM_TYPE LIKE "%' . $this->tipebrg . '%"');
        }]);

        $query->joinWith(['kategori' => function ($q) {
            $q->where('b1002.NM_KATEGORI LIKE "%' . $this->nmkategori . '%"');
        }]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
				'pageSize' => 20,
			],
        ]);

		 $dataProvider->setSort([
			'attributes' => [
                'KD_BARANG',
                'NM_BARANG',
               /* 'nmsuplier' => [
    				'asc' => ['d0001.NM_DISTRIBUTOR' => SORT_ASC],
    				'desc' => ['d0001.NM_DISTRIBUTOR' => SORT_DESC],
    				'label' => 'Supplier',
    			], */
    			
                'unitbrg' => [
                    'asc' => ['ub0001.NM_UNIT' => SORT_ASC],
                    'desc' => ['ub0001.NM_UNIT' => SORT_DESC],
                    'label' => 'Unit Barang',
                ],
                
                'tipebrg' => [
                    'asc' => ['dbc002.b1001.NM_TYPE' => SORT_ASC],
                    'desc' => ['dbc002.b1001.NM_TYPE' => SORT_DESC],
                    'label' => 'Tipe Barang',
                ],
                
    			'nmkategori' => [
    				'asc' => ['b1002.NM_KATEGORI' => SORT_ASC],
    				'desc' => ['b1002.NM_KATEGORI' => SORT_DESC],
    				'label' => 'Kategori',
    			],
    			
			]
		]);
		
		if (!($this->load($params) && $this->validate())) {
			/**
			 * The following line will allow eager loading with country data 
			 * to enable sorting by country on initial loading of the grid.
			 */ 
			return $dataProvider;
		}

        $query->andFilterWhere(['like', 'b0001.STATUS', $this->STATUS])
            ->andFilterWhere(['like', 'NM_BARANG', $this->NM_BARANG])
            ->andFilterWhere(['like', 'b0001.KD_BARANG', $this->KD_BARANG]);
        return $dataProvider;
    }
	
	/**
     * BARANG PRODUCTION ALG
     * PARENT = 1 [PRODUK]
     * @author ptrnov [piter@lukison.com]
     */
    public function searchBarangAlg($params)
    {
        $query = Barang::find()->where('b0001.STATUS <> 3')->andWhere('b0001.PARENT=1')->andWhere('b0001.KD_CORP="ALG"');
		/* $query->joinWith(['sup' => function ($q) {
			$q->where('d0001.NM_DISTRIBUTOR LIKE "%' . $this->nmsuplier . '%"');
		}]); */
        $query->joinWith(['unitb' => function ($q) {
            $q->where('ub0001.NM_UNIT LIKE "%' . $this->unitbrg . '%"');
        }]);

        $query->joinWith(['tipebg' => function ($q) {
            $q->where('b1001.NM_TYPE LIKE "%' . $this->tipebrg . '%"');
        }]);

        $query->joinWith(['kategori' => function ($q) {
            $q->where('b1002.NM_KATEGORI LIKE "%' . $this->nmkategori . '%"');
        }]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
				'pageSize' => 20,
			],
        ]);

		 $dataProvider->setSort([
			'attributes' => [
                'KD_BARANG',
                'NM_BARANG',
               /* 'nmsuplier' => [
    				'asc' => ['d0001.NM_DISTRIBUTOR' => SORT_ASC],
    				'desc' => ['d0001.NM_DISTRIBUTOR' => SORT_DESC],
    				'label' => 'Supplier',
    			], */
    			
                'unitbrg' => [
                    'asc' => ['ub0001.NM_UNIT' => SORT_ASC],
                    'desc' => ['ub0001.NM_UNIT' => SORT_DESC],
                    'label' => 'Unit Barang',
                ],
                
                'tipebrg' => [
                    'asc' => ['dbc002.b1001.NM_TYPE' => SORT_ASC],
                    'desc' => ['dbc002.b1001.NM_TYPE' => SORT_DESC],
                    'label' => 'Tipe Barang',
                ],
                
    			'nmkategori' => [
    				'asc' => ['b1002.NM_KATEGORI' => SORT_ASC],
    				'desc' => ['b1002.NM_KATEGORI' => SORT_DESC],
    				'label' => 'Kategori',
    			],
    			
			]
		]);
		
		if (!($this->load($params) && $this->validate())) {
			/**
			 * The following line will allow eager loading with country data 
			 * to enable sorting by country on initial loading of the grid.
			 */ 
			return $dataProvider;
		}

        $query->andFilterWhere(['like', 'b0001.STATUS', $this->STATUS])
            ->andFilterWhere(['like', 'NM_BARANG', $this->NM_BARANG])
            ->andFilterWhere(['like', 'b0001.KD_BARANG', $this->KD_BARANG]);
        return $dataProvider;
    }
	
	/**
     * BARANG PRODUCTION ALG
     * PARENT = 1 [PRODUK]
     * @author ptrnov [piter@lukison.com]
     */
    public function searchBarangGsn($params)
    {
        $query = Barang::find()->where('b0001.STATUS <> 3')->andWhere('b0001.PARENT=1')->andWhere('b0001.KD_CORP="GSN"');
		/* $query->joinWith(['sup' => function ($q) {
			$q->where('d0001.NM_DISTRIBUTOR LIKE "%' . $this->nmsuplier . '%"');
		}]); */
        $query->joinWith(['unitb' => function ($q) {
            $q->where('ub0001.NM_UNIT LIKE "%' . $this->unitbrg . '%"');
        }]);

        $query->joinWith(['tipebg' => function ($q) {
            $q->where('b1001.NM_TYPE LIKE "%' . $this->tipebrg . '%"');
        }]);

        $query->joinWith(['kategori' => function ($q) {
            $q->where('b1002.NM_KATEGORI LIKE "%' . $this->nmkategori . '%"');
        }]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
				'pageSize' => 20,
			],
        ]);

		 $dataProvider->setSort([
			'attributes' => [
                'KD_BARANG',
                'NM_BARANG',
               /* 'nmsuplier' => [
    				'asc' => ['d0001.NM_DISTRIBUTOR' => SORT_ASC],
    				'desc' => ['d0001.NM_DISTRIBUTOR' => SORT_DESC],
    				'label' => 'Supplier',
    			], */
    			
                'unitbrg' => [
                    'asc' => ['ub0001.NM_UNIT' => SORT_ASC],
                    'desc' => ['ub0001.NM_UNIT' => SORT_DESC],
                    'label' => 'Unit Barang',
                ],
                
                'tipebrg' => [
                    'asc' => ['dbc002.b1001.NM_TYPE' => SORT_ASC],
                    'desc' => ['dbc002.b1001.NM_TYPE' => SORT_DESC],
                    'label' => 'Tipe Barang',
                ],
                
    			'nmkategori' => [
    				'asc' => ['b1002.NM_KATEGORI' => SORT_ASC],
    				'desc' => ['b1002.NM_KATEGORI' => SORT_DESC],
    				'label' => 'Kategori',
    			],
    			
			]
		]);
		
		if (!($this->load($params) && $this->validate())) {
			/**
			 * The following line will allow eager loading with country data 
			 * to enable sorting by country on initial loading of the grid.
			 */ 
			return $dataProvider;
		}

        $query->andFilterWhere(['like', 'b0001.STATUS', $this->STATUS])
            ->andFilterWhere(['like', 'NM_BARANG', $this->NM_BARANG])
            ->andFilterWhere(['like', 'b0001.KD_BARANG', $this->KD_BARANG]);
        return $dataProvider;
    }
	
}
