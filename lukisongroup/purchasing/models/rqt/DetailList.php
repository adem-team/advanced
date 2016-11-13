<?php

namespace lukisongroup\purchasing\models\rqt;

use Yii;
use lukisongroup\master\models\Terminvest;

/**
 * This is the model class for table "t000detail_list".
 *
 * @property string $ID
 * @property string $TERM_ID
 * @property string $KD_RIB
 * @property string $ID_INVEST
 * @property string $LIST_ALL
 */
class DetailList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't000detail_list';
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
            // [['ID'], 'required'],
            [['ID', 'ID_INVEST'], 'integer'],
            [['LIST_ALL'], 'safe'],
            [['TERM_ID', 'KD_RIB'], 'string', 'max' => 225],
        ];
    }

    /**
      *@author: wawan
      *before save implode USER_CC
      *@return parent beforeSave
    */
    public function beforeSave($insert)
     {
          $list = implode(",", $this->LIST_ALL);
          $this->LIST_ALL = $list;
          return parent::beforeSave($insert);
      }

       public function getInvest()
    {
        return $this->hasOne(Terminvest::className(), ['ID' => 'ID_INVEST']);
    }
    public function getNminvest()
    {
        return $this->invest->INVES_TYPE;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'TERM_ID' => 'Term  ID',
            'KD_RIB' => 'Kd  Rib',
            'ID_INVEST' => 'Id  Invest',
            'LIST_ALL' => 'List  All',
        ];
    }
}
