<?php

namespace lukisongroup\models\esm\ro;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\models\esm\ro\Rodetail;

/**
 * RodetailSearch represents the model behind the search form about `app\models\esm\ro\Rodetail`.
 */
class RodetailSearch extends Rodetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'QTY', 'STATUS'], 'integer'],
            [['KD_RO', 'KD_BARANG', 'NM_BARANG', 'NO_URUT', 'NOTE', 'CREATED_AT', 'UPDATED_AT'], 'safe'],
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
        $query = Rodetail::find();

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
            'ID' => $this->ID,
            'QTY' => $this->QTY,
            'STATUS' => $this->STATUS,
            'CREATED_AT' => $this->CREATED_AT,
            'UPDATED_AT' => $this->UPDATED_AT,
        ]);

        $query->andFilterWhere(['like', 'KD_RO', $this->KD_RO])
            ->andFilterWhere(['like', 'KD_BARANG', $this->KD_BARANG])
            ->andFilterWhere(['like', 'NM_BARANG', $this->NM_BARANG])
            ->andFilterWhere(['like', 'NO_URUT', $this->NO_URUT])
            ->andFilterWhere(['like', 'NOTE', $this->NOTE]);

        return $dataProvider;
    }
}
