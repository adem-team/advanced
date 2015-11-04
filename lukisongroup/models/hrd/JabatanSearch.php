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
class JabatanSearch extends Jabatan
{
	/*	[1] FILTER */
    public function rules()
    {
        return [
            [['JAB_ID'], 'string', 'max' => 5],
            [['JAB_NM'], 'string', 'max' => 30],
			[['SORT'], 'integer'],
			[['JAB_DCRP'], 'string'],
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
		$query = Jabatan::find();
        $dataProvider_Jab = new ActiveDataProvider([
            'query' => $query,
        ]);
		
		/*[5.3] LOAD VALIDATION PARAMS */
			/*LOAD FARM VER 1*/
			$this->load($params);
			if (!$this->validate()) {
				return $dataProvider_Jab;
			}

		/*[5.4] FILTER WHERE LIKE (string/integer)*/
			/* FILTER COLUMN Author -ptr.nov-*/
			 $query->andFilterWhere(['like', 'JAB_ID', $this->JAB_ID])
					->andFilterWhere(['like', 'JAB_NM', $this->JAB_NM]);			
        return $dataProvider_Jab;
    }
}
