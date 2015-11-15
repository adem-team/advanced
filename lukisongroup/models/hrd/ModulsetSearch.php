<?php
/**
 * NOTE: Nama Class harus diawali Hurup Besar
 * Server Linux 	: hurup besar/kecil bermasalah -case sensitif-
 * Server Windows 	: hurup besar/kecil tidak bermasalah
 * Author: -ptr.nov-
*/

namespace lukisongroup\models\hrd;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Author -ptr.nov- Employe Search
 */
class ModulsetSearch extends Modulset
{
	/*	[1] FILTER */
    public function rules()
    {
        return [
           // [['MDL_ID','MDL_NM'], 'required'],
            [['MDL_ID','MDL_STS'], 'integer'],
            [['MDL_NM'], 'string', 'max' => 50],
			[['MDL_DCRP'], 'string'],
			[['SORT'], 'integer'],
        ];
    }
	
	/*	[4] SCNARIO */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
	
	/*	[5] SEARCH dataProvider -> SHOW GRIDVIEW */
    public function search($params)
    {	
		/*[5.1] JOIN TABLE */
		$query = Modulset::find();
        $dataProvider_hrd = new ActiveDataProvider([
            'query' => $query,
        ]);
		
		/*[5.3] LOAD VALIDATION PARAMS */
			/*LOAD FARM VER 1*/
			$this->load($params);
			if (!$this->validate()) {
				return $dataProvider_hrd;
			}

		/*[5.4] FILTER WHERE LIKE (string/integer)*/
			/* FILTER COLUMN Author -ptr.nov-*/
			 $query->andFilterWhere(['like', 'MDL_ID', $this->MDL_ID])
					->andFilterWhere(['like', 'MDL_NM', $this->MDL_NM]);			
        return $dataProvider_hrd;
    }
}
