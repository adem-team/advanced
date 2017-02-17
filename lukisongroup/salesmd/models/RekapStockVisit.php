<?php

namespace lukisongroup\salesmd\models;

use Yii;
use lukisongroup\salesmd\models\Userprofile;
/**
 * This is the model class for table "sot2_rekap_salesmd_stock".
 *
 * @property integer $ID
 * @property string $CUST_KD
 * @property string $CUST_NM
 * @property string $KD_BARANG
 * @property string $NM_BARANG
 * @property string $TGL
 * @property string $POS
 * @property integer $SO_TYPE
 * @property string $USER_ID
 * @property string $w0
 * @property string $w1
 * @property string $w2
 * @property string $w3
 * @property string $w4
 * @property string $w5
 * @property string $w6
 * @property string $w7
 * @property string $w8
 * @property string $w9
 * @property string $w10
 * @property string $w11
 * @property string $w12
 * @property string $w13
 * @property string $w14
 * @property string $w15
 * @property string $w16
 * @property string $w17
 * @property string $w18
 * @property string $w19
 * @property string $w20
 * @property string $w21
 * @property string $w22
 * @property string $w23
 * @property string $w24
 * @property string $w25
 * @property string $w26
 * @property string $w27
 * @property string $w28
 * @property string $w29
 * @property string $w30
 * @property string $w31
 * @property string $w32
 * @property string $w33
 * @property string $w34
 * @property string $w35
 * @property string $w36
 * @property string $w37
 * @property string $w38
 * @property string $w39
 * @property string $w40
 * @property string $w41
 * @property string $w42
 * @property string $w43
 * @property string $w44
 * @property string $w45
 * @property string $w46
 * @property string $w47
 * @property string $w48
 * @property string $w49
 * @property string $w50
 * @property string $w51
 * @property string $w52
 * @property string $w53
 */
class RekapStockVisit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sot2_rekap_salesmd_stock';
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
            [['SO_TYPE'], 'integer'],
            [['w0', 'w1', 'w2', 'w3', 'w4', 'w5', 'w6', 'w7', 'w8', 'w9', 'w10', 'w11', 'w12', 'w13', 'w14', 'w15', 'w16', 'w17', 'w18', 'w19', 'w20', 'w21', 'w22', 'w23', 'w24', 'w25', 'w26', 'w27', 'w28', 'w29', 'w30', 'w31', 'w32', 'w33', 'w34', 'w35', 'w36', 'w37', 'w38', 'w39', 'w40', 'w41', 'w42', 'w43', 'w44', 'w45', 'w46', 'w47', 'w48', 'w49', 'w50', 'w51', 'w52', 'w53'], 'number'],
            [['CUST_KD', 'KD_BARANG', 'TGL', 'USER_ID'], 'string', 'max' => 50],
            [['CUST_NM', 'NM_BARANG'], 'string', 'max' => 255],
            [['POS'], 'string', 'max' => 100],
        ];
    }
	
	public function getHeaderTbl()
	{
		return $this->hasOne(Userprofile::className(), ['ID_USER' => 'USER_ID']);
	}
	
	public function fields()
	{
		return [
			'SALESMAN'=>function () {
				return $this->headerTbl->NM_FIRST;				
				//return $this->USER_ID;				
			},
			'CUSTOMER_KD'=>function () {
				return $this->CUST_KD;
			},
			'CUSTOMER'=>function () {
				return $this->CUST_NM;
			},
			'SKU_ID'=>function () {
				return $this->KD_BARANG;
			},
			'SKU'=>function () {
				return $this->NM_BARANG;
			},			
			'YEAR'=>function () {
				return \Yii::$app->formatter->asDate($this->TGL, 'php:Y');
			},
			'w0'=>function () {
				return $this->w0;
			},
			'w1'=>function () {
				return $this->w1;
			},
			'w2'=>function () {
				return $this->w2;
			},
			'w3'=>function () {
				return $this->w3;
			},
			'w4'=>function () {
				return $this->w4;
			},
			'w5'=>function () {
				return $this->w5;
			},
			'w6'=>function () {
				return $this->w6;
			},
			'w7'=>function () {
				return $this->w7;
			},
			'w8'=>function () {
				return $this->w8;
			},
			'w9'=>function () {
				return $this->w9;
			},
			'w10'=>function () {
				return $this->w10;
			},
			'w11'=>function () {
				return $this->w11;
			},
			'w12'=>function () {
				return $this->w12;
			},
			'w13'=>function () {
				return $this->w13;
			},
			'w14'=>function () {
				return $this->w14;
			},
			'w15'=>function () {
				return $this->w15;
			},
			'w16'=>function () {
				return $this->w16;
			},
			'w17'=>function () {
				return $this->w17;
			},
			'w18'=>function () {
				return $this->w18;
			},
			'w19'=>function () {
				return $this->w19;
			},
			'w20'=>function () {
				return $this->w20;
			},
			'w21'=>function () {
				return $this->w21;
			},
			'w22'=>function () {
				return $this->w22;
			},
			'w23'=>function () {
				return $this->w23;
			},
			'w24'=>function () {
				return $this->w24;
			},
			'w25'=>function () {
				return $this->w25;
			},
			'w26'=>function () {
				return $this->w26;
			},
			'w27'=>function () {
				return $this->w27;
			},
			'w28'=>function () {
				return $this->w28;
			},
			'w29'=>function () {
				return $this->w29;
			},
			'w30'=>function () {
				return $this->w30;
			},
			'w31'=>function () {
				return $this->w31;
			},
			'w32'=>function () {
				return $this->w32;
			},
			'w33'=>function () {
				return $this->w33;
			},
			'w34'=>function () {
				return $this->w34;
			},
			'w35'=>function () {
				return $this->w35;
			},
			'w36'=>function () {
				return $this->w36;
			},
			'w37'=>function () {
				return $this->w37;
			},
			'w38'=>function () {
				return $this->w38;
			},
			'w39'=>function () {
				return $this->w39;
			},
			'w40'=>function () {
				return $this->w40;
			},
			'w41'=>function () {
				return $this->w41;
			},
			'w42'=>function () {
				return $this->w42;
			},
			'w43'=>function () {
				return $this->w43;
			},
			'w44'=>function () {
				return $this->w44;
			},
			'w45'=>function () {
				return $this->w45;
			},
			'w46'=>function () {
				return $this->w46;
			},
			'w47'=>function () {
				return $this->w47;
			},
			'w48'=>function () {
				return $this->w48;
			},
			'w49'=>function () {
				return $this->w49;
			},
			'w50'=>function () {
				return $this->w50;
			},
			'w51'=>function () {
				return $this->w51;
			},
			'w52'=>function () {
				return $this->w52;
			},
			'w53'=>function () {
				return $this->w53;
			},
			
		];
	} 

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'CUST_KD' => 'Cust  Kd',
            'CUST_NM' => 'Cust  Nm',
            'KD_BARANG' => 'Kd  Barang',
            'NM_BARANG' => 'Nm  Barang',
            'TGL' => 'Tgl',
            'POS' => 'Pos',
            'SO_TYPE' => 'So  Type',
            'USER_ID' => 'User  ID',
            'w0' => 'W0',
            'w1' => 'W1',
            'w2' => 'W2',
            'w3' => 'W3',
            'w4' => 'W4',
            'w5' => 'W5',
            'w6' => 'W6',
            'w7' => 'W7',
            'w8' => 'W8',
            'w9' => 'W9',
            'w10' => 'W10',
            'w11' => 'W11',
            'w12' => 'W12',
            'w13' => 'W13',
            'w14' => 'W14',
            'w15' => 'W15',
            'w16' => 'W16',
            'w17' => 'W17',
            'w18' => 'W18',
            'w19' => 'W19',
            'w20' => 'W20',
            'w21' => 'W21',
            'w22' => 'W22',
            'w23' => 'W23',
            'w24' => 'W24',
            'w25' => 'W25',
            'w26' => 'W26',
            'w27' => 'W27',
            'w28' => 'W28',
            'w29' => 'W29',
            'w30' => 'W30',
            'w31' => 'W31',
            'w32' => 'W32',
            'w33' => 'W33',
            'w34' => 'W34',
            'w35' => 'W35',
            'w36' => 'W36',
            'w37' => 'W37',
            'w38' => 'W38',
            'w39' => 'W39',
            'w40' => 'W40',
            'w41' => 'W41',
            'w42' => 'W42',
            'w43' => 'W43',
            'w44' => 'W44',
            'w45' => 'W45',
            'w46' => 'W46',
            'w47' => 'W47',
            'w48' => 'W48',
            'w49' => 'W49',
            'w50' => 'W50',
            'w51' => 'W51',
            'w52' => 'W52',
            'w53' => 'W53',
        ];
    }
}
