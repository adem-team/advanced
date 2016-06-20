<?php

namespace lukisongroup\master\models;
use yii\helpers\ArrayHelper;
use lukisongroup\hrd\models\Corp;

use Yii;

/**
 * This is the model class for table "c0003".
 *
 * @property integer $ID_TERM
 * @property string $NM_TERM
 * @property string $CUST_KD
 * @property string $CUST_NM
 * @property string $CUST_SIGN
 * @property string $PRINCIPAL_KD
 * @property string $PRINCIPAL_NM
 * @property string $PRINCIPAL_SIGN
 * @property string $DIST_KD
 * @property string $DIST_NM
 * @property string $DIST_SIGN
 * @property string $DCRP_SIGNARURE
 * @property string $PERIOD_START
 * @property string $PERIOD_END
 * @property string $TARGET_TEXT
 * @property string $TARGET_VALUE
 * @property string $RABATE_CNDT
 * @property string $GROWTH
 * @property string $TOP
 * @property integer $STATUS
 * @property string $CREATED_BY
 * @property string $CREATED_AT
 * @property string $UPDATE_BY
 * @property string $UPDATE_AT
 */
class Termcustomers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
     public $term;
     public $image;

    public static function tableName()
    {
        return 'c0003';
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
            [['CUST_KD', 'PRINCIPAL_KD', 'DIST_KD'], 'required'],
            [['image'], 'file'],
            [['DCRP_SIGNARURE', 'TARGET_TEXT', 'RABATE_CNDT', 'TOP','JOBGRADE_ID','JABATAN_CUS','JABATAN_DIST'], 'string'],
            [['PERIOD_START', 'PERIOD_END', 'CREATED_AT', 'UPDATE_AT','GENERAL_TERM','ID_TERM'], 'safe'],
            [['PERIOD_END'], 'cekdate'],
            [['TARGET_VALUE', 'GROWTH'], 'number'],
            [['STATUS'], 'integer'],
            [['NM_TERM', 'CREATED_BY', 'UPDATE_BY'], 'string', 'max' => 100],
            [['CUST_KD', 'PRINCIPAL_KD', 'DIST_KD','KETERANGAN','NOMER_INVOCE','NOMER_FAKTURPAJAK',], 'string', 'max' => 50],
            [['CUST_NM', 'CUST_SIGN', 'PRINCIPAL_NM', 'PRINCIPAL_SIGN', 'DIST_NM', 'DIST_SIGN'], 'string', 'max' => 255]
        ];
    }

    public function data($data,$to,$from)
    {
      # code...
      return ArrayHelper::map($data, $to, $from);
    }

    public function imagedisplay($id)
    {
      # code...
      $data = Termcustomers::find()->where(['ID_TERM'=>$id])->one();
      return $data;
    }

    public function cekdate($model)
    {
      # code...
      $datestart = $this->PERIOD_START;
      $dateend = $this->PERIOD_END;
      if(strtotime($dateend) < strtotime($datestart))
       {
           $this->addError($model, 'Tanggal harus lebih Besar'.$datestart);
       }

    }


    public function getGeneral()
    {
      # code...
      return $this->hasOne(Termgeneral::className(), ['ID' => 'GENERAL_TERM']);
    }

    public function getCus()
    {
      # code...
      return $this->hasOne(Customers::className(), ['CUST_KD' => 'CUST_KD']);
    }

    public function getDis()
    {
      # code...
      return $this->hasOne(Distributor::className(), ['KD_DISTRIBUTOR' => 'DIST_KD']);
    }
    public function getCorp()
    {
      # code...
      return $this->hasOne(Corp::className(), ['CORP_ID' => 'PRINCIPAL_KD']);
    }





    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [

          // 'JOBGRADE_ID','JABATAN_CUS','JABATAN_DIST'
           'JABATAN_CUS' => 'Jabatan Customers',
          'JABATAN_DIST' => 'Jabatan Distributor',
          'JOBGRADE_ID' => 'Jabatan Principal',
          // 'CUST_KD' => 'Cust  Kd',
            'ID_TERM' => 'Id  Term',
            'NM_TERM' => 'Nama TIPRO',
            'CUST_KD' => 'Nama Customers',
            'CUST_NM' => 'Nama Customers',
            // 'CUST_SIGN' => 'Cust  Sign',
            'PRINCIPAL_KD' => ' Nama Principal',
            'PRINCIPAL_NM' => ' Nama Principal',
            'PRINCIPAL_SIGN' => 'Principal  Sign',
            'DIST_KD' => 'Nama Distributor',
            'DIST_NM' => 'Nama Distributor',
            'DIST_SIGN' => 'Dist  Sign',
            'DCRP_SIGNARURE' => 'Dcrp  Signarure',
            'PERIOD_START' => 'Period  Start',
            'PERIOD_END' => 'Period  End',
            'TARGET_TEXT' => 'Target  Text',
            'TARGET_VALUE' => 'Target  Value',
            'RABATE_CNDT' => 'Rabate  Cndt',
            'GROWTH' => 'Growth',
            'TOP' => 'Top',
            'STATUS' => 'Status',
            'CREATED_BY' => 'Created  By',
            'CREATED_AT' => 'Created  At',
            'UPDATE_BY' => 'Update  By',
            'UPDATE_AT' => 'Update  At',
        ];
    }
}
