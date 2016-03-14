<?php

namespace lukisongroup\dashboard\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\debug\components\search\Filter;
use yii\debug\components\search\matchers;


class RptesmGraph extends Model
{	
	public $KD_BARANG;
	
    /**
     * @inheritdoc	
     */
    public function rules()
    {
        return [
            [['KD_BARANG'], 'safe'],
        ];
    }

  	/*=======================================
	 * ESM-STOCK-PER-SKU
	 * @author ptrnov [piter@lukison.com]
	 * @since 1.2
	 *=======================================
	*/
	public function stockPerSkuValue($params){
		$dataStock= Yii::$app->db_esm->createCommand("CALL ESM_GRAPH_stock_per_sku('value','".$this->KD_BARANG."')")->queryAll();  
		$dataProvider= new ArrayDataProvider([
			'allModels'=>$dataStock,			
			'pagination' => [
				'pageSize' => 500,
			]
		]);
		
		if (!($this->load($params) && $this->validate())) {
 			return $dataProvider;
 		}
		$dataProvider->
		
		
		$filter = new Filter();
 		$this->addCondition($filter, 'KD_BARANG', true);
 		$dataProvider->allModels = $filter->filter($dataStock);
			
		//$result=$aryDataStock->getModels();		
		return $dataProvider;
	}	
	
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
