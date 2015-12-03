<?php

namespace lukisongroup\sales\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\sales\models\Purchaseorder;
use lukisongroup\hrd\models\Employe;

/**
 * PurchaseorderSearch represents the model behind the search form about `lukisongroup\models\esm\po\Purchaseorder`.
 */
class PurchaseorderSearch extends Purchaseorder
{

    public $pembuat;
    public $disetujui;
    public $approved;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'STATUS'], 'integer'],
            [['KD_PO', 'KD_SUPPLIER', 'CREATE_BY', 'CREATE_AT', 'APPROVE_BY', 'APPROVE_AT', 'NOTE','PAJAK','DISC','ETD', 'ETA', 'SHIPPING', 'BILLING', 'DELIVERY_COST', 'APPROVE_DIR', 'TGL_APPROVE', 'pembuat', 'disetujui', 'approved'], 'safe'],
        ];
    }

    /**S
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
        $query = Purchaseorder::find();

        $query->joinWith(['employe' => function ($q) {
            $q->where('a0001.EMP_NM LIKE "%' . $this->pembuat . '%"');
        }]);

        $query->joinWith(['employe' => function ($q) {
            $q->where('a0001.EMP_NM LIKE "%' . $this->disetujui . '%"');
        }]);

        $query->joinWith(['employe' => function ($q) {
            $q->where('a0001.EMP_NM LIKE "%' . $this->approved . '%"');
        }]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

         $dataProvider->setSort([
            'attributes' => [
            'KD_PO',
            'KD_SUPPLIER',
            
            'pembuat' => [
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
            ],     
                 
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'ID' => $this->ID,
            'CREATE_AT' => $this->CREATE_AT,
            'APPROVE_AT' => $this->APPROVE_AT,
            'STATUS' => $this->STATUS,
        ]);

        $query->andFilterWhere(['like', 'KD_PO', $this->KD_PO])
            ->andFilterWhere(['like', 'KD_SUPPLIER', $this->KD_SUPPLIER])
            ->andFilterWhere(['like', 'CREATE_BY', $this->CREATE_BY])
            ->andFilterWhere(['like', 'APPROVE_BY', $this->APPROVE_BY])
            ->andFilterWhere(['like', 'NOTE', $this->NOTE]);

        return $dataProvider;
    }
}
