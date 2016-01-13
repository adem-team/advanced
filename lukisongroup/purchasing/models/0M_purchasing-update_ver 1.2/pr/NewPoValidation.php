<?php
namespace lukisongroup\purchasing\models\pr;

use Yii;
use yii\base\Model;
use lukisongroup\purchasing\models\pr\Purchaseorder;
use lukisongroup\purchasing\models\pr\Purchasedetail;
	/*
	* Discount Validation
	* @author ptrnov  <piter@lukison.com>
	* @since 1.1
	*/
	
class NewPoValidation extends Model
{
    public $PO_GNR;
	public $PO_RSLT;
	  
    public function rules()
    {
        return [			
			[['PO_GNR'],'required'],		
			[['PO_GNR'],'integer'],		
			//[['dISC'], 'number', 'numberPattern' => '/^\s*[-+]?[0-9]*[.]?[0-9]+([eE][-+]?[0-9]+)?\s*$/'],			
		];
    }
	
	/**
     * Check KD_PO Generate
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	public function findcheck($attribute, $params)
    {        
		if (!$this->hasErrors()) {
			 $cntDetailPo = Purchaseorder::find()->where(['KD_PO'=>$this->PO_GNR])->count();
			if (!$cntDetailPo) {
                $this->addError($attribute, 'ID PO, have been taken, use other');				
            } 
       }
    } 
	
	/**
     * Generate PO | PO PLUS | PO Normal | Purchaseorder
	 * PO PLUS ['POA.'.date('ymdhis')] -> PO DENGAN LIMIT HARGA
	 * PO Normal ['PO.'.date('ymdhis')] -> PO Dengan Persetujuan orderby | RequestOrder|SalesOrder
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	public function generatepo_saved()
    {	
		$poHeader = New Purchaseorder();
		if ($this->validate()) {			
			$poHeader->KD_PO = $this->PO_GNR==0 ?  'PO.'.date('ymdhis') : 'POA.'.date('ymdhis');	
			$poHeader->STATUS = '0';
            $poHeader->CREATE_AT = date("Y-m-d H:i:s");
            $poHeader->CREATE_BY = Yii::$app->user->identity->EMP_ID;
			if ($poHeader->save()) {
				 $this->PO_RSLT=$poHeader->KD_PO;
                return $poHeader->KD_PO;	
            }
			return $poHeader->KD_PO;
		}		
		return null;	
	}
	
	public function attributeLabels()
    {
        return [
            'PO_GNR' => 'PO Option Create'
        ];
    }
	
}
