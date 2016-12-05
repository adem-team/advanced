<?php

namespace lukisongroup\purchasing\models\salesmanorder;

use Yii;
use lukisongroup\master\models\Customers;


/**
 * This is the model class for table "so_t2".
 *
 * @property integer $ID
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
 * @property string $NOTED
 * @property string $HARGA_LG
 * @property integer $STATUS
 * @property string $WAKTU_INPUT_INVENTORY
 * @property string $ID_GROUP
 * @property string $KODE_REF
 * @property string $SUBMIT_QTY
 * @property string $SUBMIT_PRICE
 */
class SoT2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $UNIT_BRG;
    public $SUB_TOTAL;
    public $SUBMIT_SUB_TOTAL;
    public $NM_UNIT;
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
            [['TGL', 'WAKTU_INPUT_INVENTORY','KD_BARANG'], 'safe'],
            [['KD_BARANG', 'SO_QTY'], 'required','on'=>'create'],
            [['KD_BARANG'], 'CekBarang','on'=>'create'],
            [['SO_QTY', 'UNIT_QTY', 'UNIT_BERAT', 'HARGA_PABRIK', 'HARGA_DIS', 'HARGA_SALES', 'HARGA_LG', 'SUBMIT_QTY', 'SUBMIT_PRICE'], 'number'],
            [['SO_TYPE', 'STATUS'], 'integer'],
            [['NOTED'], 'string'],
            [['CUST_KD', 'CUST_KD_ALIAS', 'KD_DIS', 'USER_ID', 'UNIT_BARANG', 'KODE_REF'], 'string', 'max' => 50],
            [['CUST_NM', 'NM_BARANG', 'POS', 'NM_DIS'], 'string', 'max' => 255],
            [['KD_BARANG_ALIAS'], 'string', 'max' => 30],
            [['ID_GROUP'], 'string', 'max' => 20],
        ];
    }


    public function CekBarang($model){
        $explode = explode(',', $this->KD_BARANG);
        $kondisi = SoT2::find()->where(['KD_BARANG'=>$explode[0],'KODE_REF'=>$this->KODE_REF])->andwhere('STATUS<>3')->one();
        if($kondisi){
            $this->addError($model, 'Duplicated Product because the Product already exists in this Salesman Order !, attention  change name Product or change code ');
        }
    }

    public function getCust(){
		return $this->hasOne(Customers::className(), ['CUST_KD'=>'CUST_KD']);
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
            'NOTED' => 'Noted',
            'HARGA_LG' => 'Harga  Lg',
            'STATUS' => 'Status',
            'WAKTU_INPUT_INVENTORY' => 'Waktu  Input  Inventory',
            'ID_GROUP' => 'Id  Group',
            'KODE_REF' => 'Kode  Ref',
            'SUBMIT_QTY' => 'Submit  Qty',
            'SUBMIT_PRICE' => 'Submit  Price',
        ];
    }
}
