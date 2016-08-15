<?php

namespace lukisongroup\master\models;

use Yii;

/**
 * This is the model class for table "c0002scdl_layer".
 *
 * @property integer $LAYER_ID
 * @property string $LAYER_NM
 * @property integer $JEDA_PEKAN
 * @property string $DCRIPT
 */
class DraftLayer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c0002scdl_layer';
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
            [['JEDA_PEKAN'], 'integer'],
            [['DCRIPT'], 'string'],
            [['LAYER_NM'], 'string', 'max' => 5],
        ];
    }

    public function getCuslayer(){
      return $this->hasOne(Customers::className(), ['LAYER' => 'LAYER_ID']);
  }

  public function getCus_kd() 
  {
  return $this->cuslayer->CUST_KD;
  }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'LAYER_ID' => 'Layer  ID',
            'LAYER_NM' => 'Layer  Nm',
            'JEDA_PEKAN' => 'Jeda  Pekan',
            'DCRIPT' => 'Dcript',
        ];
    }
}
