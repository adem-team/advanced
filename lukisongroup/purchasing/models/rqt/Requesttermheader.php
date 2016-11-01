<?php

namespace lukisongroup\purchasing\models\rqt;

use Yii;
use lukisongroup\hrd\models\Employe;
use lukisongroup\master\models\Customers;
use lukisongroup\hrd\models\Dept;
use lukisongroup\purchasing\models\rqt\Rtdetail;
use lukisongroup\hrd\models\Corp;

/**
 * This is the model class for table "t0001header".
 *
 * @property string $KD_RIB
 * @property string $TGL
 * @property string $CUST_ID_PARENT
 * @property string $KD_CORP
 * @property string $KD_COSTCENTER
 * @property string $PPN
 * @property string $PPH23
 * @property string $NOTE
 * @property string $ID_USER
 * @property string $KD_CAB
 * @property string $KD_DEP
 * @property integer $STATUS
 * @property string $CREATED_AT
 * @property string $UPDATED_ALL
 * @property string $DATA_ALL
 * @property string $EMP_NM
 * @property string $USER_CC
 * @property string $SIG1_ID
 * @property string $SIG1_NM
 * @property string $SIG1_TGL
 * @property string $SIG1_SVGBASE64
 * @property string $SIG1_SVGBASE30
 * @property string $SIG2_ID
 * @property string $SIG2_NM
 * @property string $SIG2_TGL
 * @property string $SIG2_SVGBASE64
 * @property string $SIG2_SVGBASE30
 * @property string $SIG3_ID
 * @property string $SIG3_NM
 * @property string $SIG3_TGL
 * @property string $SIG3_SVGBASE64
 * @property string $SIG3_SVGBASE30
 */
class Requesttermheader extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
     public $NEW;
    public static function tableName()
    {
        return 't0001header';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_esm');
    }

    public function getDetro()
    {
        return $this->hasMany(Rtdetail::className(), ['KD_RIB' => 'KD_RIB']);
    }

    public function getCus()
    {
         return $this->hasOne(Customers::className(), ['CUST_KD' => 'CUST_ID_PARENT']);
    }

    public function Nmcus()
    {
            return $this->cus->CUST_NM;
    }

    public function getEmploye()
    {
        return $this->hasOne(Employe::className(), ['EMP_ID' => 'ID_USER']);
    }

	   public function getDept()
    {
        return $this->hasOne(Dept::className(), ['DEP_ID' => 'KD_DEP']);
    }
    public function getCorp()
    {
       return $this->hasOne(Corp::className(), ['CORP_ID' => 'KD_CORP']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NEW','CUST_ID_PARENT','NOTE'], 'required','on'=>'simpan'],
            [['TGL', 'CREATED_AT', 'SIG1_TGL', 'SIG2_TGL', 'SIG3_TGL','SIG1_SVGBASE64','SIG1_SVGBASE30','TERM_ID','PERIODE_START','PERIODE_END'], 'safe'],
            [['PPN', 'PPH23'], 'number'],
            [['NOTE', 'DATA_ALL', 'SIG2_SVGBASE64', 'SIG2_SVGBASE30', 'SIG3_SVGBASE64', 'SIG3_SVGBASE30','TERM_ID'], 'string'],
            [['STATUS'], 'integer'],
            [['KD_RIB', 'CUST_ID_PARENT', 'KD_CORP', 'KD_COSTCENTER', 'KD_CAB', 'KD_DEP', 'EMP_NM', 'USER_CC', 'SIG1_ID', 'SIG1_NM', 'SIG2_ID', 'SIG2_NM', 'SIG3_ID', 'SIG3_NM'], 'string', 'max' => 50],
            [['ID_USER', 'UPDATED_ALL','KD_CAB', 'KD_DEP',  'CREATED_AT'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'KD_RIB' => 'Kd  Rib',
            'TGL' => 'Tgl',
            'CUST_ID_PARENT' => 'Cust  Id  Parent',
            'KD_CORP' => 'Kd  Corp',
            'KD_COSTCENTER' => 'Kd  Costcenter',
            'PPN' => 'Ppn',
            'PPH23' => 'Pph23',
            'NOTE' => 'Note',
            'ID_USER' => 'Id  User',
            'KD_CAB' => 'Kd  Cab',
            'KD_DEP' => 'Kd  Dep',
            'STATUS' => 'Status',
            'CREATED_AT' => 'Created  At',
            'UPDATED_ALL' => 'Updated  All',
            'DATA_ALL' => 'Data  All',
            'EMP_NM' => 'Emp  Nm',
            'USER_CC' => 'User  Cc',
            'SIG1_ID' => 'Sig1  ID',
            'SIG1_NM' => 'Sig1  Nm',
            'SIG1_TGL' => 'Sig1  Tgl',
            'SIG1_SVGBASE64' => 'Sig1  Svgbase64',
            'SIG1_SVGBASE30' => 'Sig1  Svgbase30',
            'SIG2_ID' => 'Sig2  ID',
            'SIG2_NM' => 'Sig2  Nm',
            'SIG2_TGL' => 'Sig2  Tgl',
            'SIG2_SVGBASE64' => 'Sig2  Svgbase64',
            'SIG2_SVGBASE30' => 'Sig2  Svgbase30',
            'SIG3_ID' => 'Sig3  ID',
            'SIG3_NM' => 'Sig3  Nm',
            'SIG3_TGL' => 'Sig3  Tgl',
            'SIG3_SVGBASE64' => 'Sig3  Svgbase64',
            'SIG3_SVGBASE30' => 'Sig3  Svgbase30',
        ];
    }
}
