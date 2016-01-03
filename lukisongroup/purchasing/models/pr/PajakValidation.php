<?php
namespace lukisongroup\purchasing\models\pr;

use Yii;
use yii\base\Model;
use lukisongroup\purchasing\models\pr\Purchaseorder;
use lukisongroup\purchasing\models\pr\Purchasedetail;
	/*
	* Pajak Validation
	* @author ptrnov  <piter@lukison.com>
	* @since 1.1
	*/
	
class PajakValidation extends Model
{
    public $kD_PO;
	public $pAJAK;
	  
    public function rules()
    {
        return [			
			[['kD_PO'], 'findcheck'],		
			[['kD_PO','pAJAK'], 'required'],					
			[['pAJAK'], 'number', 'numberPattern' => '/^\s*[-+]?[0-9]*[.,]?[0-9]+([eE][-+]?[0-9]+)?\s*$/'],			
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
	public function discount_saved()
    {
		if ($this->validate()) {
			$poHeader = Purchaseorder::findOne($this->kD_PO);
			$poHeader->PAJAK = $this->pAJAK;			
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
            'pAJAK' => 'TAX',
            'kD_PO' => 'Kode.PO'
        ];
    }
	
}
