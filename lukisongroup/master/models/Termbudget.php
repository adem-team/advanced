<?php

namespace lukisongroup\master\models;


use Yii;
use yii\helpers\ArrayHelper;

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

      $inves = $this->INVES_TYPE;
      $data = Termbudget::find()->where(['INVES_TYPE'=>$inves])->asArray()
                                                          ->one();
      if($inves ==  $data['INVES_TYPE'])
      {
           $this->addError($budget,'Maaf Duplikat data');
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
