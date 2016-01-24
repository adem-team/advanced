<?php

namespace lukisongroup\master\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\master\models\Kategori;

/**
 * KategoriSearch represents the model behind the search form about `app\models\master\Kategori`.
 */
class KategoriSearch extends Kategori
{
	
	public function attributes()
	{
		/*Author -ptr.nov- add related fields to searchable attributes */
		return array_merge(parent::attributes(), ['corp.CORP_NM','typebrg.NM_TYPE']);
	}
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'STATUS'], 'integer'],
            [['KD_KATEGORI', 'KD_TYPE','NM_KATEGORI', 'NOTE','PARENT', 'CREATED_BY', 'CREATED_AT', 'UPDATED_BY', 'UPDATED_AT','corp.CORP_NM','typebrg.NM_TYPE'], 'safe'],
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
        $query = Kategori::find()->where('STATUS <> 3')->groupBy(['PARENT','CORP_ID','KD_TYPE','KD_KATEGORI']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
				'pageSize' => 20,
			],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
 //           'id' => $this->id,
            'NM_KATEGORI' => $this->NM_KATEGORI,
            'UPDATED_AT' => $this->UPDATED_AT,
            'STATUS' => $this->STATUS,
			'PARENT' => $this->PARENT,
			'CORP_ID' => $this->getAttribute('corp.CORP_NM'),
			'KD_TYPE' => $this->getAttribute('typebrg.NM_TYPE')			
        ]);

        $query->andFilterWhere(['like', 'KD_KATEGORI', $this->KD_KATEGORI])
            ->andFilterWhere(['like', 'NM_KATEGORI', $this->NM_KATEGORI])
            ->andFilterWhere(['like', 'NOTE', $this->NOTE]);
//            ->andFilterWhere(['like', 'CREATED_BY', $this->CREATED_BY])
//            ->andFilterWhere(['like', 'UPDATED_BY', $this->UPDATED_BY]);

        return $dataProvider;
    }
}
