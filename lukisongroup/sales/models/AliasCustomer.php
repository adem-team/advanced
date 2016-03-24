<?php
namespace lukisongroup\sales\models;

use Yii;
use yii\base\Model;
//use lukisongroup\master\models\Customersalias;
use lukisongroup\sales\models\SalesCustomerAlias;

class AliasCustomer extends Model
{
    public $kD_CUST;
	public $nM_CUST;
    public $kD_CUST_ALIAS;
    public $nM_CUST_ALIAS;
    public $kD_REF;
    public $kD_REF_NM;

	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['kD_CUST','kD_CUST_ALIAS'], 'required'],
			[['kD_REF','kD_REF_NM'], 'safe'],
        ];
    }
	public function alias_customer_save(){
		$rcCustomer= new SalesCustomerAlias;
		//if ($this->validate()) {
			$rcCustomer->KD_CUSTOMERS=$this->kD_CUST;
			$rcCustomer->KD_ALIAS=$this->kD_CUST_ALIAS;
			$rcCustomer->KD_PARENT = '1';
			$rcCustomer->DIS_REF=$this->kD_REF;
			$rcCustomer->CREATED_AT = date('Y-m-d');
			$rcCustomer->CREATED_BY =$username=Yii::$app->user->identity->username;
			$rcCustomer->save();
			// print_r($rcCustomer->save());
			// die();			
			return $rcCustomer;
		//}
		//return null;
	}
}
