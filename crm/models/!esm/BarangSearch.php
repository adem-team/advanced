<?php

namespace lukisongroup\models\esm;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\models\esm\Barang;
use lukisongroup\models\esm\Barangmaxi;

/**
 * BarangSearch represents the model behind the search form about `app\models\esm\Barang`.
 */
class BarangSearch extends Barang
{
	public $nmdbtr;
	public $unitbrg;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'HPP', 'HARGA', 'BARCODE', 'NOTE', 'STATUS', 'CREATED_BY', 'CREATED_AT', 'UPDATED_AT'], 'safe'],
            [['ID', 'HPP', 'HARGA'], 'integer'],
            [['KD_BARANG', 'KD_TYPE', 'KD_KATEGORI', 'NM_BARANG', 'KD_SUPPLIER', 'KD_DISTRIBUTOR', 'DATA_ALL'], 'safe'],
            [['nmdbtr','unitbrg'], 'safe'],
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
		$query->joinWith(['dbtr' => function ($q) {
			$q->where('d0001.NM_DISTRIBUTOR LIKE "%' . $this->nmdbtr . '%"');
		}]);
		$query->joinWith(['unitb' => function ($q) {
			$q->where('ub0001.NM_UNIT LIKE "%' . $this->unitbrg . '%"');
		}]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

		 $dataProvider->setSort([
			'attributes' => [
            'KD_BARANG',
            'NM_BARANG',
			'nmdbtr' => [
				'asc' => ['d0001.NM_DISTRIBUTOR' => SORT_ASC],
				'desc' => ['d0001.NM_DISTRIBUTOR' => SORT_DESC],
				'label' => 'Nama Distributor',
			],
			
			'unitbrg' => [
				'asc' => ['ub0001.NM_UNIT' => SORT_ASC],
				'desc' => ['ub0001.NM_UNIT' => SORT_DESC],
				'label' => 'Unit Barang',
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
        $query->andFilterWhere(['like', 'b0001.KD_BARANG', $this->KD_BARANG]);
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
