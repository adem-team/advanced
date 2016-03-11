<?php

namespace lukisongroup\master\models;


use Yii;
use yii\helpers\ArrayHelper;
use lukisongroup\master\models\Termcustomers;

/**
 * This is the model class for table "c0005".
 *
 * @property integer $ID
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
     const SCENARIO_CREATE = 'insret';
    //  const SCENARIO_UPDATE = 'update';

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

            [['BUDGET_PLAN','BUDGET_ACTUAL','PPN','PPH23'], 'number'],
            [['BUDGET_PLAN','BUDGET_ACTUAL','PPN','PPH23'], 'default','value'=>0.00],
            [['INVES_TYPE'], 'cekdata','on'=>self::SCENARIO_CREATE],
            // [['PERIODE_START','PERIODE_END'], 'date', 'format' => 'php:F d Y'],
            [['INVES_TYPE','BUDGET_PLAN','PERIODE_START','PERIODE_END'], 'required','on'=>self::SCENARIO_CREATE],
            [['PERIODE_END'], 'datevalid'],
            [['PERIODE_START', 'PERIODE_END', 'CREATE_AT', 'UPDATE_AT'], 'safe'],
            [['STATUS'], 'integer'],
            [['ID_TERM','CORP_ID','KD_COSTCENTER','PROGRAM'], 'string', 'max' => 50],
            [['INVES_TYPE', 'BUDGET_SOURCE'], 'string', 'max' => 255],
            [['CREATE_BY', 'UPDATE_BY'], 'string', 'max' => 100]
        ];
    }

//     public function scenarios()
// {
//    $scenarios = parent::scenarios();
//    $scenarios[self::SCENARIO_CREATE] = ['INVES_TYPE','BUDGET_PLAN','PERIODE_START','PERIODE_END'];
//    $scenarios[self::SCENARIO_UPDATE] = ['INVES_TYPE'];
//    return $scenarios;
// }

    public function data($data,$to,$from)
    {
      # code...
      return ArrayHelper::map($data, $to, $from);
    }

    public function cekdata($budget)
    {

      $id = $this->ID_TERM;
      $inves = $this->INVES_TYPE;
      $data = Termbudget::find()->where(['ID_TERM'=>$id,'INVES_TYPE'=>$inves])->asArray()
                                                          ->one();
      if($inves ===  $data['INVES_TYPE'])
      {
           $this->addError($budget,'Maaf Duplikat data');
      }
    }

    public function getBudget()
    {
      return $this->hasOne(Termcustomers::className(), ['ID_TERM' => 'ID_TERM']);

    }


// valid date in term-customers
    public function datevalid($model)
    {
      # code...
      $datestart = $this->PERIODE_START;
      $dateend = $this->PERIODE_END;
      $date = strtotime($datestart);
      // print_r($date);
      // die();



     if(strtotime($dateend) < strtotime($datestart))
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
            'BUDGET_PLAN' => 'Budget Plan',
            'BUDGET_ACTUAL' => 'Budget Actual',
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
