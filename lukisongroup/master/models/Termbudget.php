<?php

namespace lukisongroup\master\models;


use Yii;
use yii\helpers\ArrayHelper;
use lukisongroup\master\models\Termcustomers;

/**
 * This is the model class for table "c0005".
 *
 * @property integer $ID
 * @property string $CUST_KD
 * @property string $INVES_TYPE
 * @property string $BUDGET_SOURCE
 * @property string $BUDGET_VALUE
 * @property string $PERIODE_START
 * @property string $PERIODE_END
 * @property integer $STATUS
 * @property string $CREATE_BY
 * @property string $CREATE_AT
 * @property string $UPDATE_BY
 * @property string $UPDATE_AT
 */
class Termbudget extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
     public $TARGET_VALUE;
    public static function tableName()
    {
        return 'c0005';
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
            [['BUDGET_VALUE'], 'number'],
            [['INVES_TYPE'], 'cekdata'],
            [['PERIODE_END'], 'datevalid'],
            [['PERIODE_START', 'PERIODE_END', 'CREATE_AT', 'UPDATE_AT'], 'safe'],
            [['STATUS'], 'integer'],
            [['ID_TERM','CORP_ID'], 'string', 'max' => 50],
            [['INVES_TYPE', 'BUDGET_SOURCE'], 'string', 'max' => 255],
            [['CREATE_BY', 'UPDATE_BY'], 'string', 'max' => 100]
        ];
    }

    public function data($data,$to,$from)
    {
      # code...
      return ArrayHelper::map($data, $to, $from);
    }

    public function cekdata($budget)
    {

      $id = $this->ID_TERM;
      $inves = $this->INVES_TYPE;
      $data = Termbudget::find()->where(['ID_TERM'=>$id])->asArray()
                                                          ->one();
                                                          // print_r($data);
                                                          // die();
      if($inves ==  $data['INVES_TYPE'])
      {
           $this->addError($budget,'Maaf Duplikat data');
      }
    }

    public function getBudget()
    {
      return $this->hasOne(Termcustomers::className(), ['ID_TERM' => 'ID_TERM']);

    }


    public function datevalid($model)
    {
      # code...
      $datestart = $this->PERIODE_START;
      $dateend = $this->PERIODE_END;

       if( $dateend < $datestart  )
       {
           $this->addError($model, 'Tanggal harus lebih Besar'.$datestart);
       }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'CUST_KD' => 'Cust  Kd',
            'INVES_TYPE' => 'Inves  Type',
            'BUDGET_SOURCE' => 'Budget  Source',
            'BUDGET_VALUE' => 'Budget  Value',
            'PERIODE_START' => 'Periode  Start',
            'PERIODE_END' => 'Periode  End',
            'STATUS' => 'Status',
            'CREATE_BY' => 'Create  By',
            'CREATE_AT' => 'Create  At',
            'UPDATE_BY' => 'Update  By',
            'UPDATE_AT' => 'Update  At',
        ];
    }
}
