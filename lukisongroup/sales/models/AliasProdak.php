<?php
namespace lukisongroup\sales\models;

use Yii;
use yii\base\Model;
use lukisongroup\master\models\Barangalias;

class AliasProdak extends Model
{
    public $kD_BARANG;
    public $nM_BARANG;
	public $kD_BARANG_ALIAS;
    public $nM_BARANG_ALIAS;
	
	public function rules()
    {
        return [
			[['kD_BARANG','kD_BARANG_ALIAS'], 'required'],
        ];
    }
	
	public function distributor(){
		$customersData = Customers::find()->where(['CUST_KD' =>$this->kD_CUST])->one();
		$distributor=$customersData!=''?$customersData['KD_DISTRIBUTOR']:'none';
		return $distributor;
	}
	
	public function alias_barang_save(){
		//if ($this->validate()) {
			$rcBarangalias= new Barangalias;
		//print_r($this->distributor());
		//die();
		
		//print_r($rcBarangalias->getErrors());	
		//die();
		//if ($this->validate()) {
			$rcBarangalias->KD_BARANG=$this->kD_BARANG;
			$rcBarangalias->KD_ALIAS=$this->kD_BARANG_ALIAS;
			//$rcBarangalias->KD_PARENT = '1';
			$aliasCustomr->KD_DISTRIBUTOR=$this->distributor();
			$rcBarangalias->CREATED_AT = date('Y-m-d');
			$rcBarangalias->CREATED_BY =$username=Yii::$app->user->identity->username;
			$rcBarangalias->save();
			// print_r($rcBarangalias->save());
			// die();
					
			return $rcBarangalias;
		//}
		//return null;	
		//}
	}
}
