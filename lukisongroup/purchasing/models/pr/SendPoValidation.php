<?php
namespace lukisongroup\purchasing\models\pr;

use Yii;
use yii\base\Model;
use lukisongroup\purchasing\models\pr\Purchaseorder;
use lukisongroup\purchasing\models\pr\Purchasedetail;
use lukisongroup\purchasing\models\ro\Requestorder;
use lukisongroup\purchasing\models\ro\Rodetail;

/*
* Send PO validation | Transfer barang dari RO/SO ke PO
* @author ptrnov  <piter@lukison.com>
* @since 1.1
*/
	
class SendPoValidation extends Model
{
    public $kD_PO;
	public $dELIVERY;
	  
    public function rules()
    {
        return [			
			[['kD_PO'], 'findcheck'],		
			[['kD_PO','dELIVERY'], 'required'],					
			[['dELIVERY'], 'number', 'numberPattern' => '/^\s*[-+]?[0-9]*[.,]?[0-9]+([eE][-+]?[0-9]+)?\s*$/'],			
		];
    }
	
	/**
     * Check KD_PO Purchasdetail 
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	public function findcheck($attribute, $params)
    {        
		if (!$this->hasErrors()) {
			 $cntDetailPo = Purchasedetail::find()->where(['KD_PO'=>$this->kD_PO])->count();
			if (!$cntDetailPo) {
                $this->addError($attribute, 'Please, Input Item SKU First');				
            } 
       }
    }
	
	/**
     * Saved Data Purchaseorder
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	public function delevery_saved()
    {
		if ($this->validate()) {
			$poHeader = Purchaseorder::findOne($this->kD_PO);
			$poHeader->DELIVERY_COST = $this->dELIVERY;			
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
            'dELIVERY' => 'Delivery.Cost  [ex: 1,000,000.00]',
            'kD_PO' => 'Kode.PO'
        ];
    }
	
}
