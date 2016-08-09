<?php
namespace lukisongroup\purchasing\models\pr;

use Yii;
use yii\base\Model;
use lukisongroup\purchasing\models\pr\Purchaseorder;
	/*
	* ETD Validation | Estimate Time Delevery
	* @author ptrnov  <piter@lukison.com>
	* @since 1.1
	*/
	
class EtdValidation extends Model
{
    public $kD_PO;
	public $eTD;
	  
    public function rules()
    {
        return [			
			[['kD_PO'], 'findcheck'],	
			[['eTD'], 'findcheckETD'],				
			[['kD_PO','eTD'], 'required'],					
			[['eTD'], 'safe'],			
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
                $this->addError($attribute, 'PO Not Found, Please Generate PO');				
            } 
       }
    }
	
	/**
     * Check ETD | Lebih besar sama dengan tanggal Create
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	public function findcheckETD($attribute, $params)
    {         
		if (!$this->hasErrors()) {
			 $poHeader = Purchaseorder::findOne($this->kD_PO);
			if (strtotime(Yii::$app->formatter->asDate($this->eTD,'Y-M-d')) < strtotime(Yii::$app->formatter->asDate($poHeader->CREATE_AT,'Y-M-d'))) {
				$this->addError($attribute, 'Estimated Delivery Time, must be higher than the PO date made');					
            } 
       }
    }
	
	/**
     * Saved Data Purchaseorder
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	public function etd_saved()
    {
		if ($this->validate()) {
			$poHeader = Purchaseorder::findOne($this->kD_PO);
			$poHeader->ETD = \Yii::$app->formatter->asDate($this->eTD,'Y-M-d');			
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
            'eTD' => 'ETD',
            'kD_PO' => 'Kode.PO'
        ];
    }
	
}
