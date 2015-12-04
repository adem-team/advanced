<?php

namespace lukisongroup\purchasing\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
//use lukisongroup\purchasing\models\Rodetail;

/**
 * RodetailSearch represents the model behind the search form about `app\models\esm\ro\Rodetail`.
 */
class RodetailSearch extends Rodetail
{
    /**
     * @inheritdoc
     */
	public $parentro;
	
	public function attributes()
	{
		/*Author -ptr.nov- add related fields to searchable attributes */
		return array_merge(parent::attributes(), ['parentro.KD_RO','parentro.CREATED_AT']);
	}
	
	
    public function rules()
    {
        return [
            [['ID','STATUS'], 'integer'],
			[['parentro','RQTY','SQTY'], 'safe'],
            [['parentro.KD_RO','parentro.CREATED_AT','KD_RO', 'KD_BARANG', 'NM_BARANG', 'NO_URUT', 'NOTE', 'CREATED_AT', 'UPDATED_AT'], 'safe']
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

	
	public function searchChildRo($params,$kdro='')
    {
		
		/* if($kdro!=''){
			$getkdro=" and r0001.KD_RO='".$kdro."'";
		}else{
			$getkdro='';
		} */
		
		$profile=Yii::$app->getUserOpt->Profile_user();
        //$query = Pilotproject::find()->Where('sc0001.STATUS<>3 AND DEP_ID="'.$profile->emp->DEP_ID .'"');
		
		if($profile->emp->JOBGRADE_ID == 'M' OR $profile->emp->JOBGRADE_ID == 'SM' ){
			$query = Rodetail::find()
						->JoinWith('parentro',false,'RIGHT JOIN')
						->where("(r0001.status <> 3 and r0001.KD_CORP = '" .$profile->emp->EMP_CORP_ID ."' and r0001.ID_USER = '".$profile->emp->EMP_ID."') OR (r0001.status <> 3 and r0001.KD_CORP = '" .$profile->emp->EMP_CORP_ID ."' and r0001.KD_DEP = '".$profile->emp->DEP_ID."')");
        }else{
			$query = Rodetail::find()
					->JoinWith('parentro',false,'RIGHT JOIN')
					->where("r0001.status <> 3 and r0001.KD_CORP = '" .$profile->emp->EMP_CORP_ID ."' and r0001.ID_USER = '".$profile->emp->EMP_ID."' " . $getkdro);
		}
		$dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

         $this->load($params);
			if (!$this->validate()) {
				//return $dataProvider;
				//$dataProvider->query->where('0=1');
				return $dataProvider;
			} 
		/* if (isset($_GET['RodetailSearch']) && !($this->load($params) && $this->validate())) {
			return $dataProvider;
		} */	
			
			
        $query->andFilterWhere([
            'RQTY' => $this->RQTY,
			'SQTY' => $this->SQTY,
            'STATUS' => $this->STATUS,
            'CREATED_AT' => $this->CREATED_AT,
            'UPDATED_AT' => $this->UPDATED_AT,
        ]);
		
		$query->andFilterWhere(['like', 'r0001.KD_RO', $this->getAttribute('parentro.KD_RO')])
			//->andFilterWhere(['like', 'r0001.CREATED_AT',$this->getAttribute('parentro.CREATED_AT')])
            ->andFilterWhere(['like', 'KD_BARANG', $this->KD_BARANG])
            ->andFilterWhere(['like', 'NM_BARANG', $this->NM_BARANG])
            ->andFilterWhere(['like', 'NO_URUT', $this->NO_URUT])
            ->andFilterWhere(['like', 'NOTE', $this->NOTE]);
			
		if($this->getAttribute('parentro.CREATED_AT')!=''){
            $date_explode = explode(" - ", $this->getAttribute('parentro.CREATED_AT'));
            $date1 = trim($date_explode[0]);
            $date2= trim($date_explode[1]);
            $query->andFilterWhere(['between','r0001.CREATED_AT', $date1,$date2]);
        } 
		
        return $dataProvider;
		
    }
	
	
	/*
	 * RO DataProvider Select By KD_RO
	*/
	public function search_listbyro($kd_ro)
    {
		$query = Rodetail::find()
					->JoinWith('parentro',true,'INNER JOIN')
					->where("r0001.status <> 3 and r0001.KD_RO = '".$kd_ro."'");
		
		$dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        /* $this->load($params);
		 	if (!$this->validate()) {
				return $dataProvider;
			}  */
			
        return $dataProvider;
		
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
