<?php

namespace lukisongroup\purchasing\models\data_term;
use yii\helpers\ArrayHelper;
use lukisongroup\hrd\models\Corp;
use lukisongroup\master\models\Customers;
use lukisongroup\master\models\Distributor;


use Yii;

/**
 * This is the model class for table "c0003".
 *
 * @property string $CUST_KD_PARENT
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
class Termheader extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
     public $term;
     public $image;

     CONST EXIST_RUNNING = 'exist_running';

    public static function tableName()
    {
        return 't0000header';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_esm');
    }

    public function dataarray($data,$to,$from)
    {
      # code...
      return ArrayHelper::map($data, $to, $from);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TERM_ID','CUST_KD_PARENT', 'PRINCIPAL_KD', 'DIST_KD'], 'required'],
            [['image'], 'file'],
            [['PERIOD_START','PERIOD_END'], 'default','value'=>date('Y-m-d')],
            [['TARGET_TEXT', 'RABATE_CNDT','BUDGET_AWAL'], 'string'],
            [['PERIOD_START', 'PERIOD_END', 'CREATED_AT', 'UPDATE_AT','GENERAL_TERM'], 'safe'],
            [['PERIOD_END'], 'cekdate'],
            [['TARGET_VALUE', 'GROWTH'], 'number'],
            [['STATUS'], 'integer'],
            [['CREATED_BY', 'UPDATE_BY'], 'string', 'max' => 100],
            [['CUST_KD_PARENT', 'PRINCIPAL_KD', 'DIST_KD','KETERANGAN','NOMER_INVOCE','NOMER_FAKTURPAJAK',], 'string', 'max' => 50]
        ];
    }

    public function data($data,$to,$from)
    {
      # code...
      return ArrayHelper::map($data, $to, $from);
    }

    // public function imagedisplay($id)
    // {
      // # code...
      // $data = Termcustomers::find()->where(['ID_TERM'=>$id])->one();
      // return $data;
    // }

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

    public function cekExistTermrunning($model)
    {
       $data = Termheader::find()->where(['CUST_KD_PARENT'=>$this->CUST_KD_PARENT,'STATUS'=>1])->one();
       if($data)
       {
         $this->addError($model, 'sorry Customer already been there');
       }
    }


    // public function getGeneral()
    // {
      // # code...
      // return $this->hasOne(Termgeneral::className(), ['ID' => 'GENERAL_TERM']);
    // }

    public function getCus()
    {
      # code...
      return $this->hasOne(Customers::className(), ['CUST_KD' => 'CUST_KD_PARENT']);
    }
    public function getNmCustomer(){
		return $this->cus->CUST_NM;
	}

    public function getDis()
    {
      # code...
      return $this->hasOne(Distributor::className(), ['KD_DISTRIBUTOR' => 'DIST_KD']);
    }
	public function getNmDis(){
		return $this->dis->NM_DISTRIBUTOR;
	}

	#principel
    public function getCorp()
    {
      # code...
      return $this->hasOne(Corp::className(), ['CORP_ID' => 'PRINCIPAL_KD']);
    }

	public function getNmprincipel(){
		return $this->corp->CORP_NM;
	}



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
			'TERM_ID' => 'Term.Id',
			'CUST_KD_PARENT' => 'Nama Customers',
            'PRINCIPAL_KD' => ' Nama Principal',
            'DIST_KD' => 'Nama Distributor',
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
