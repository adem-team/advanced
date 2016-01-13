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
	
class SendPoQtyValidation extends Model
{
   //public $kD_PO;
	//public $kD_RO;
	//public $kD_BARANG;
	public $iD;	
	public $PQTY;
	  
    public function rules()
    {
        return [			
			[['PQTY'], 'findcheck'],
			[['iD'],'required'],	
			//[['kD_PO','kD_RO','kD_BARANG'],'required'],					
		];
    }
	
	/**
     * Check QTY SUM |RoDetail <= Purchasdetail 
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	public function findcheck($attribute, $params)
    {        
		if (!$this->hasErrors()) {
			$roDetail=Rodetail::find()->where(['ID'=>$this->$iD])->one();
			//$cntDetailPo = Purchasedetail::find()->where(['KD_PO'=>$this->kD_PO,'KD_BARANG'=>$this->kD_BARANG])->count();
			$pqtyTaken= "SELECT SUM(QTY) as QTY FROM p0002 WHERE KD_RO='" .$roDetail->kD_RO. "' AND KD_BARANG='" .$roDetail->kD_BARANG ."'";
			$poDetailQtySum=Purchasedetail::findBySql($pqtyTaken)->one();
			//$roDetail=Rodetail::find()->where(['KD_RO'=>$this->kD_PO,'KD_BARANG'=>$this->kD_BARANG])->one();
			$poQty=$poDetailQtySum->QTY!=''? $poDetailQtySum->QTY :0;
			$roQty=$roDetail->SQTY;
			if ($poDetailQtySum) {
					$ttlPQTY=$roQty - $poQty;
					if ($this->PQTY > $ttlPQTY){
						$this->addError($attribute, 'QTY Request Order Limited, please insert free Qty, Check Request Order');	
					}
			}elseif(!$poDetailQtySum){
					if ($this->PQTY > $roQty){
						$this->addError($attribute, 'QTY Request Order Limited, please insert free Qty, Check Request Order');	
					}	
			}
		}
    }
	
	/**
     * QTY SAVE VALIDATION Purchasedetail
	 * SQTY RoDetail - SUM QTY Purchasedetail (sama dengan atau lebih kecil, lebih besar =error)
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	public function sendpo_saved()
    {
		if ($this->validate()) {
			$poDetailModal = Purchasedetail::findOne($this->iD);
			$poDetailModal->QTY = $this->PQTY;			
			if ($poDetailModal->save()) {
                return $poDetailModal;
            }
			return $poDetailModal;
		}		
		return null;	
	}
	/*
	public function attributeLabels()
    {
        return [
            //'kD_PO'=>'Kode.PO';
			//'kD_RO'=>'Kode.RO';
			//'kD_BARANG'=>'Kode.Barang';
			'iD'=>'ID';
			'PQTY'=>'QTY';
        ];
    } */
}
