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
    
	public $kD_CORP;
	public $pARENT_PO;
	public $poRSLT;
	  
    public function rules()
    {
        return [			
			[['pARENT_PO','kD_CORP'],'required'],		
			[['pARENT_PO','kD_CORP'],'string'],
			//[['po_RSLT'],'safe'],				
			//[['dISC'], 'number', 'numberPattern' => '/^\s*[-+]?[0-9]*[.]?[0-9]+([eE][-+]?[0-9]+)?\s*$/'],			
		];
    }
	
	/**
     * Check KD_PO Generate
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	/* public function findcheck($attribute, $params)
    {        
		if (!$this->hasErrors()) {
			 $cntDetailPo = Purchaseorder::find()->where(['KD_PO'=>$this->pARENT_PO])->count();
			if (!$cntDetailPo) {
                $this->addError($attribute, 'ID PO, have been taken, use other');				
            } 
       }
    }  */
	
	/**
     * Generate PO | PO PLUS | PO Normal | Purchaseorder
	 * PO PLUS ['POA.'.date('ymdhis')] -> PO DENGAN LIMIT HARGA
	 * PO Normal ['PO.'.date('ymdhis')] -> PO Dengan Persetujuan orderby | RequestOrder|SalesOrder
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	public function generatepo_saved()
    {	
		$this->poRSLT=\Yii::$app->ambilkonci->getPoCode($this->kD_CORP,$this->pARENT_PO);
		
		$poHeader = New Purchaseorder();
		if ($this->validate()) {			
			$poHeader->KD_PO = $this->poRSLT;
			$poHeader->KD_CORP = $this->kD_CORP;		
			$poHeader->PARENT_PO = $this->pARENT_PO=='POC' ? 1:0;
			$poHeader->STATUS = '0';
            $poHeader->CREATE_AT = date("Y-m-d H:i:s");
            $poHeader->CREATE_BY = Yii::$app->user->identity->EMP_ID;
			if ($poHeader->save()) {
				return  $this->poRSLT;	
            }
			return $this->poRSLT;	
		}		
		return null;	
	}
	
	/* public function attributeLabels()
    {
        return [
            'pARENT_PO' => 'PO Option Create'
        ];
    } */
	
}
