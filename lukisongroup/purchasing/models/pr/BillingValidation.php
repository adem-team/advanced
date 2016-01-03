<?php
namespace lukisongroup\purchasing\models\pr;

use Yii;
use yii\base\Model;
use lukisongroup\purchasing\models\pr\Purchaseorder;
	/*
	* BillingValidation
	* @author ptrnov  <piter@lukison.com>
	* @since 1.1
	*/
	
class BillingValidation extends Model
{
    public $kD_PO;
	public $bILLING;
	  
    public function rules()
    {
        return [			
			[['kD_PO'], 'findcheck'],	
			[['kD_PO','bILLING'], 'required'],					
			[['bILLING'], 'safe'],			
		];
    }
	
	/**
     * Check KD_PO Purchaseorder 
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	public function findcheck($attribute, $params)
    {        
		if (!$this->hasErrors()) {
			 $cntDetailPo = Purchaseorder::find()->where(['KD_PO'=>$this->kD_PO])->count();
			if (!$cntDetailPo) {
                $this->addError($attribute, 'PO Not Found, Please Generate PO the first');				
            } 
       }
    }
	
	/**
     * Saved Data Purchaseorder
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	public function billing_saved()
    {
		if ($this->validate()) {
			$poHeader = Purchaseorder::findOne($this->kD_PO);
			$poHeader->BILLING =$this->bILLING;			
			if ($poHeader->save()) {
                return $poHeader;
            }
			return $poHeader;
		}		
		return null;	
	}
	
	public function attributeLabels()
    {
        return [
            'bILLING' => 'Billing',
            'kD_PO' => 'Kode.PO'
        ];
    }
	
}
