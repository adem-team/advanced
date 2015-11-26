<?php

namespace lukisongroup\esm\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\esm\models\Barang;
//use lukisongroup\models\esm\Barangmaxi;

use lukisongroup\models\master\Tipebarang;
use lukisongroup\models\master\Kategori;

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
            [['ID', 'HPP', 'HARGA', 'BARCODE', 'NOTE', 'STATUS', 'CREATED_BY', 'CREATED_AT', 'UPDATED_AT','nmsuplier','unitbrg','tipebrg','nmkategori'], 'safe'],
            [['ID', 'HPP', 'HARGA'], 'integer'],
            [['KD_BARANG', 'KD_TYPE', 'KD_KATEGORI', 'NM_BARANG', 'KD_SUPPLIER', 'KD_DISTRIBUTOR', 'DATA_ALL'], 'safe'],
            // [['nmsuplier','unitbrg','tipebrg','nmkategori'], 'safe'],
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
        $query = Barang::find()->where('b0001.STATUS <> 3');
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
        ]);

		 $dataProvider->setSort([
			'attributes' => [
                'KD_BARANG',
                'NM_BARANG',
                'HPP', 
                'HARGA',
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
                    'asc' => ['dbm002.b1001.NM_TYPE' => SORT_ASC],
                    'desc' => ['dbm002.b1001.NM_TYPE' => SORT_DESC],
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

        $query->andFilterWhere(['like', 'HPP', $this->HPP])
            ->andFilterWhere(['like', 'HARGA', $this->HARGA])
			   ->andFilterWhere(['like', 'NM_BARANG', $this->NM_BARANG])
            ->andFilterWhere(['like', 'b0001.KD_BARANG', $this->KD_BARANG]);
        return $dataProvider;
		/*
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'ID' => $this->ID,
            'HPP' => $this->HPP,
            'HARGA' => $this->HARGA,
            'BARCODE' => $this->BARCODE,
            'NOTE' => $this->NOTE,
            'STATUS' => $this->STATUS,
            'CREATED_BY' => $this->CREATED_BY,
            'CREATED_AT' => $this->CREATED_AT,
            'UPDATED_AT' => $this->UPDATED_AT,
        ]);

        $query->andFilterWhere(['like', 'KD_BARANG', $this->KD_BARANG])
            ->andFilterWhere(['like', 'NM_BARANG', $this->NM_BARANG])
            ->andFilterWhere(['like', 'KD_SUPPLIER', $this->KD_SUPPLIER])
            ->andFilterWhere(['like', 'KD_DISTRIBUTOR', $this->KD_DISTRIBUTOR])
            ->andFilterWhere(['like', 'DATA_ALL', $this->DATA_ALL]);

        return $dataProvider;
		
		*/
    }
}
