<?php
namespace lukisongroup\purchasing\models\pr;

use Yii;
use yii\base\Model;
use lukisongroup\purchasing\models\pr\Purchaseorder;
use lukisongroup\purchasing\models\pr\Purchasedetail;
use lukisongroup\master\models\Barangumum;
/*
* PO PLUS validation | PO Details
* @author ptrnov  <piter@lukison.com>
* @since 1.1
*/
	
class PoPlusValidation extends Model
{
    public $kD_PO;
	public $nM_BARANG;
	public $kD_KATEGORI;
	public $kD_BARANG;
	public $hARGA;
	public $uNIT;
	public $nM_UNIT;
	public $qTY_UNIT;
	public $wEIGHT_UNIT;
	public $qTY;
	public $nOTE;
	  
	/*Result Return Controller*/
	public $PO_PLUS_RSLT;
	
    public function rules()
    {
        return [			
			[['kD_PO','kD_BARANG'],'required'],
			[['kD_BARANG'], 'findcheck'],
			[['nM_BARANG','kD_PO','kD_KATEGORI','uNIT','qTY','nOTE','wEIGHT_UNIT','qTY_UNIT','nM_UNIT'], 'safe'],
			[['hARGA'], 'number', 'numberPattern' => '/^\s*[-+]?[0-9]*[.,]?[0-9]+([eE][-+]?[0-9]+)?\s*$/'],			
		];
    }
	
	/**
     * Check PO PLUS| kD_PO kD_BARANG =0 | Jika Ada, update Harga/QTY 
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	public function findcheck($attribute, $params)
    {        
		if (!$this->hasErrors()) {
			 $cntDetailPo = Purchasedetail::find()->where(['KD_PO'=>$this->kD_PO,'KD_BARANG'=>$this->kD_BARANG])->count();
			if ($cntDetailPo) {
                $this->addError($attribute, 'SKU Alrady Exist,Please Update Quantity or Price');				
            }else{
				$brgUmum=Barangumum::find()->where(['KD_BARANG'=>$this->kD_BARANG])->one();				
				$brgUnit= $brgUmum->unit;
				$this->nM_BARANG=$brgUmum->NM_BARANG;
				$this->nM_UNIT=$brgUnit->NM_UNIT;
				$this->qTY_UNIT=$brgUnit->QTY;
				$this->wEIGHT_UNIT=$brgUnit->WEIGHT;
			} 
       }
    }
	
	/**
     * Saved Data Purchasedetail | PO PLUS
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	public function poplus_saved()
    {	
		$poDetailModel = New Purchasedetail();
		if ($this->validate()) {
			$poDetailModel->KD_PO=$this->kD_PO;
			$poDetailModel->KD_RO='PurchasingPO';
			$poDetailModel->KD_BARANG=$this->kD_BARANG;
			$poDetailModel->NM_BARANG=$this->nM_BARANG;
			$poDetailModel->UNIT=$this->uNIT;
			$poDetailModel->NM_UNIT=$this->nM_UNIT;
			$poDetailModel->UNIT_QTY=$this->qTY_UNIT;
			$poDetailModel->UNIT_WIGHT=$this->wEIGHT_UNIT;
			$poDetailModel->QTY=$this->qTY;
			$poDetailModel->HARGA=$this->hARGA;
			$poDetailModel->STATUS=0; 
			$poDetailModel->STATUS_DATE =date("Y-m-d H:i:s");								
			$poDetailModel->save();							
			if ($poDetailModel->save()) {
				 $this->PO_PLUS_RSLT=$poDetailModel->KD_PO;
                return $poDetailModel->KD_PO;	
            }
			return $poDetailModel->KD_PO;
		}		
		return null;	
	}
		
	public function attributeLabels()
    {
        return [
            'kD_PO' => 'Kode.PO',
			'nM_BARANG'=>'Item.Name',
			'kD_KATEGORI'=>'Category',
			'kD_BARANG'=>'SKU',
			'hARGA'=>'Price		[ex: 1,000,000.00]',
			'uNIT'=>'Unit',
			'qTY'=>'Qty',
			'nOTE'=>'Note',
        ];
    }
	
}
