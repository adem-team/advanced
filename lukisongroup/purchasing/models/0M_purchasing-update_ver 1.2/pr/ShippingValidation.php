<?php
namespace lukisongroup\purchasing\models\pr;

use Yii;
use yii\base\Model;
use lukisongroup\purchasing\models\pr\Purchaseorder;

	/*
	*ShippingValidation
	* @author ptrnov  <piter@lukison.com>
	* @since 1.1
	*/
	
class ShippingValidation extends Model
{
    public $kD_PO;
	public $sHIPPING;
	  
    public function rules()
    {
        return [			
			[['kD_PO'], 'findcheck'],	
			[['kD_PO','sHIPPING'], 'required'],					
			[['sHIPPING'], 'safe'],			
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
	public function shipping_saved()
    {
		if ($this->validate()) {
			$poHeader = Purchaseorder::findOne($this->kD_PO);
			$poHeader->SHIPPING =$this->sHIPPING;			
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
            'sHIPPING' => 'Shipping',
            'kD_PO' => 'Kode.PO'
        ];
    }
	
}
