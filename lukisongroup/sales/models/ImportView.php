<?php

namespace lukisongroup\sales\models;

use Yii;
use lukisongroup\master\models\Distributor;
use lukisongroup\master\models\Barang;
use lukisongroup\master\models\Unitbarang;

/**
 * This is the model class for table "so_t2".
 *
 * @property string $ID
 * @property string $TGL
 * @property string $CUST_KD
 * @property string $CUST_KD_ALIAS
 * @property string $CUST_NM
 * @property string $KD_BARANG
 * @property string $KD_BARANG_ALIAS
 * @property string $NM_BARANG
 * @property string $SO_QTY
 * @property integer $SO_TYPE
 * @property string $POS
 * @property string $KD_DIS
 * @property string $NM_DIS
 * @property string $USER_ID
 * @property string $UNIT_BARANG
 * @property string $UNIT_QTY
 * @property string $UNIT_BERAT
 * @property string $HARGA_PABRIK
 * @property string $HARGA_DIS
 * @property string $HARGA_SALES
 * @property string $HARGA_LG
 * @property string $NOTED
 * @property integer $STATUS
 */
class ImportView extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'so_t2';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_esm');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TGL','disNm'], 'safe'],
            [['SO_QTY', 'UNIT_QTY', 'UNIT_BERAT', 'HARGA_PABRIK', 'HARGA_DIS', 'HARGA_SALES', 'HARGA_LG'], 'number'],
            [['SO_TYPE', 'STATUS'], 'integer'],
            [['NOTED'], 'string'],
            [['CUST_KD', 'CUST_KD_ALIAS', 'KD_BARANG', 'KD_DIS', 'USER_ID', 'UNIT_BARANG'], 'string', 'max' => 50],
            [['CUST_NM', 'NM_BARANG', 'POS', 'NM_DIS'], 'string', 'max' => 255],
            [['KD_BARANG_ALIAS'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'TGL' => 'Tgl',
            'CUST_KD' => 'Cust  Kd',
            'CUST_KD_ALIAS' => 'Cust  Kd  Alias',
            'CUST_NM' => 'Cust  Nm',
            'KD_BARANG' => 'Kd  Barang',
            'KD_BARANG_ALIAS' => 'Kd  Barang  Alias',
            'NM_BARANG' => 'Nm  Barang',
            'SO_QTY' => 'So  Qty',
            'SO_TYPE' => 'So  Type',
            'POS' => 'Pos',
            'KD_DIS' => 'Kd  Dis',
            'NM_DIS' => 'Nm  Dis',
            'USER_ID' => 'User  ID',
            'UNIT_BARANG' => 'Unit  Barang',
            'UNIT_QTY' => 'Unit  Qty',
            'UNIT_BERAT' => 'Unit  Berat',
            'HARGA_PABRIK' => 'Harga  Pabrik',
            'HARGA_DIS' => 'Harga  Dis',
            'HARGA_SALES' => 'Harga  Sales',
            'HARGA_LG' => 'Harga  Lg',
            'NOTED' => 'Noted',
            'STATUS' => 'Status',
        ];
    }
	
	public function getTglAlias1(){
		return $this->TGL;
	}
	public function getTglAlias2(){
		return $this->TGL;
	}
	public function getKdBrg1(){
		return $this->KD_BARANG;
	}
	public function getKdBrg2(){
		return $this->KD_BARANG;
	}
	
	public function getDistributor(){
		return $this->hasOne(Distributor::className(), ['KD_DISTRIBUTOR'=>'KD_DIS']);
	}
	
	public function getDisNm(){
		return $this->distributor!=''?$this->distributor->NM_DISTRIBUTOR:'';
	}
	public function getDisNm1(){
		return $this->distributor!=''?$this->distributor->NM_DISTRIBUTOR:'';
	}
	public function getDisNm2(){
		return $this->distributor!=''?$this->distributor->NM_DISTRIBUTOR:'';
	}
	
	/* Unit Via Brang Model*/
	public function getBarangTbl()
    {
        return $this->hasOne(Barang::className(), ['KD_BARANG' => 'KD_BARANG']);
    }	
	
	public function getUnitTbl()
    {
        return $this->hasOne(Unitbarang::className(), ['KD_UNIT' => 'KD_UNIT'])->via('barangTbl');
    }
	
	public function getUnitweight() 
    {
        return $this->barangTbl!=''?$this->barangTbl->Unitweight:0;
    }
	
	public function getKartonqty() 
    {
		if ($this->SO_QTY!=0){
			 $valKartonQty=round(($this->SO_QTY / $this->UNIT_QTY),0,PHP_ROUND_HALF_UP);
			 //$valKartonQty=($this->SO_QTY / $this->UNIT_QTY);
		return  number_format($valKartonQty,2);	
		}
       
    }
	
	
	public function getSubtotaldist() 
    {
        $valSubTtlDist=round(($this->SO_QTY * $this->HARGA_DIS),0,PHP_ROUND_HALF_UP);
		 return  number_format($valSubTtlDist,2);
    }
	
	public function getSubtotalpabrik() 
    {
        $valSubTtlPabrik=round(($this->SO_QTY * $this->HARGA_PABRIK),0,PHP_ROUND_HALF_UP);
		return  number_format($valSubTtlPabrik,2);
    }
	
	public function getSubtotalSales() 
    {
        $valSubTtlSales=round(($this->SO_QTY * $this->HARGA_SALES),0,PHP_ROUND_HALF_UP);
		 return  number_format($valSubTtlSales,2);
    }
	
	public function getBeratunit() 
    {
		$valBerat=round(($this->SO_QTY * $this->UNIT_BERAT),0,PHP_ROUND_HALF_UP);
		return  number_format($valBerat,2);
    }
}
