<?php

namespace lukisongroup\warehouse\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\warehouse\models\TypeSrcDes;

/**
 * TypeKtgSearch represents the model behind the search form about `lukisongroup\warehouse\models\TypeKtg`.
 */
class TypeSrcDesSearch extends TypeSrcDes
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'TYPE', 'SRC_DEST'], 'integer'],
            [['TYPE_NM', 'DSCRPT'], 'safe'],
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
        $query = TypeKtg::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'ID' => $this->ID,
            'TYPE' => $this->TYPE,
            'TYPE_KTG' => $this->TYPE_KTG,
        ]);

        $query->andFilterWhere(['like', 'TYPE_NM', $this->TYPE_NM])
            ->andFilterWhere(['like', 'DSCRPT', $this->DSCRPT]);

        return $dataProvider;
    }
}
