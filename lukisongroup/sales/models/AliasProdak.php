<?php
namespace lukisongroup\sales\models;

use Yii;
use yii\base\Model;
use lukisongroup\master\models\Customersalias;

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
	
	public function alias_barang_save(){
		if ($this->validate()) {
				
		}
	}
}
