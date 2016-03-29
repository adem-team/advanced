<?php

namespace lukisongroup\purchasing\models\rpt;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\debug\components\search\Filter;
use yii\debug\components\search\matchers;

/**
 * PersonallogSearch represents the model behind the search form about `lukisongroup\hrd\models\Personallog`.
 */
class PoReportSearch extends Model
{	
	public $ID;
	public $CREATE_AT;
	public $KD_PO;
	public $KD_CORP;
	public $PARENT_PO;
	public $SUPPLIER;
	public $TOP_TYPE;
	public $TOP_DURATION;
	public $PAJAK;
	public $DELIVERY_COST;
	public $NOTE;
	public $SIG1_NM;
	public $SIG2_NM;
	public $SIG3_NM;
	public $KD_RO;
	public $KD_COSTCENTER;
	public $KD_BARANG;
	public $NM_BARANG;
	public $QTY;
	public $HARGA;
	public $UNIT;
	public $UNIT_QTY;
	public $UNIT_WIGHT;
	public $STT_HDR;
	public $STT_DTL;
	public $SUB_TTL;
	
    /**
     * @inheritdoc	
     */
    public function rules()
    {
        return [
            [['ID','CREATE_AT','KD_PO','KD_CORP','PARENT_PO ','SUPPLIER','TOP_TYPE','TOP_DURATION','PAJAK','DELIVERY_COST','NOTE','SIG1_NM','SIG2_NM','SIG3_NM'], 'safe'],
            [['KD_RO','KD_COSTCENTER','KD_BARANG','NM_BARANG','QTY','HARGA','UNIT','UNIT_QTY','UNIT_WIGHT','STT_HDR','STT_DTL','SUB_TTL'], 'safe'],
        ];
    }

    /*
	 * PURCHASING REPORT ALL
	 * @author ptrnov [piter@lukison.com]
	 * @since 1.2
	*/
	public function poReportAll($params){
		$data= Yii::$app->db3->createCommand("CALL PURCHASING_report()")->queryAll();  
		$dataProvider= new ArrayDataProvider([
			'key' => 'ID',
			'allModels'=>$data,			
			'pagination' => [
				'pageSize' => 500,
			]
		]);
		//if (!($this->load($params) && $this->validate())) {
		if (!($this->load($params))) {
 			return $dataProvider;
 		}
		
		$filter = new Filter();
 		$this->addCondition($filter, 'ID', true);
 		$this->addCondition($filter, 'CREATE_AT', true);
 		$this->addCondition($filter, 'KD_PO', true);	
 		$this->addCondition($filter, 'KD_CORP', true);	
 		$this->addCondition($filter, 'PARENT_PO', false);	
 		$this->addCondition($filter, 'SUPPLIER', true);	
 		$this->addCondition($filter, 'TOP_TYPE', true);	
 		$this->addCondition($filter, 'TOP_DURATION', true);	
 		$this->addCondition($filter, 'PAJAK', true);	
 		$this->addCondition($filter, 'DELIVERY_COST', true);	
 		$this->addCondition($filter, 'NOTE', true);	
 		$this->addCondition($filter, 'SIG1_NM', true);	
 		$this->addCondition($filter, 'SIG2_NM', true);	
 		$this->addCondition($filter, 'SIG3_NM', true);	
 		$this->addCondition($filter, 'KD_RO', true);	
 		$this->addCondition($filter, 'KD_COSTCENTER', true);	
 		$this->addCondition($filter, 'KD_BARANG', true);	
 		$this->addCondition($filter, 'NM_BARANG', true);	
 		$this->addCondition($filter, 'QTY', true);	
 		$this->addCondition($filter, 'HARGA', true);	
 		$this->addCondition($filter, 'UNIT', true);	
 		$this->addCondition($filter, 'HARGA', true);	
 		$this->addCondition($filter, 'UNIT_QTY', true);	
 		$this->addCondition($filter, 'UNIT_WIGHT', true);	
 		$this->addCondition($filter, 'STT_HDR', true);	
 		$this->addCondition($filter, 'STT_DTL', true);	
 		$this->addCondition($filter, 'SUB_TTL', true);	
 		$dataProvider->allModels = $filter->filter($data);   
		return $dataProvider;
	}	
	
	/*
	 * CONDITION FILTER
	 * @author ptrnov [piter@lukison.com]
	 * @since 1.2 
	*/
	public function addCondition(Filter $filter, $attribute, $partial = false)
    {
        $value = $this->$attribute;

        if (mb_strpos($value, '>') !== false) {
            $value = intval(str_replace('>', '', $value));
            $filter->addMatcher($attribute, new matchers\GreaterThan(['value' => $value]));

        } elseif (mb_strpos($value, '<') !== false) {
            $value = intval(str_replace('<', '', $value));
            $filter->addMatcher($attribute, new matchers\LowerThan(['value' => $value]));
        } else {
            $filter->addMatcher($attribute, new matchers\SameAs(['value' => $value, 'partial' => $partial]));
        }
    }
	
	
	
	
	
	
	
	
	
	
	
	
	
}
