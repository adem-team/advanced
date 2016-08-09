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
	
class EtaValidation extends Model
{
    public $kD_PO;
	public $eTA;
	  
    public function rules()
    {
        return [			
			[['kD_PO'], 'findcheck'],	
			[['eTA'], 'findcheckETA'],				
			[['kD_PO','eTA'], 'required'],					
			[['eTA'], 'safe'],			
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
	public function findcheckETA($attribute, $params)
    {         
		if (!$this->hasErrors()) {
			 $poHeader = Purchaseorder::findOne($this->kD_PO);
			if ((strtotime(\Yii::$app->formatter->asDate($this->eTA,'Y-M-d')) < strtotime(\Yii::$app->formatter->asDate($poHeader->CREATE_AT,'Y-M-d'))) or (strtotime(\Yii::$app->formatter->asDate($this->eTA,'Y-M-d')) < strtotime(\Yii::$app->formatter->asDate($poHeader->ETD,'Y-M-d')))) {
                $this->addError($attribute, 'Estimated Time Arrival, should be higher than the date Estimated Delivery Time');				
            } 
       }
    }
	
	/**
     * Saved Data Purchaseorder
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	public function eta_saved()
    {
		if ($this->validate()) {
			$poHeader = Purchaseorder::findOne($this->kD_PO);
			$poHeader->ETA = \Yii::$app->formatter->asDate($this->eTA,'Y-M-d');			
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
            'eTA' => 'ETA',
            'kD_PO' => 'Kode.PO'
        ];
    }
	
}
