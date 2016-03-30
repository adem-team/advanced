<?php

namespace lukisongroup\master\models;

use Yii;
use lukisongroup\sistem\models\Userlogin;

/**
 * This is the model class for table "c0002scdl_header".
 *
 * @property integer $ID
 * @property string $TGL
 * @property integer $SCDL_GROUP
 * @property string $USER_ID
 * @property string $NOTE
 * @property integer $STATUS
 * @property string $CREATE_BY
 * @property string $CREATE_AT
 * @property string $UPDATE_BY
 * @property string $UPDATE_AT
 */
class Scheduleheader extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c0002scdl_header';
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
            [['TGL1', 'CREATE_AT', 'UPDATE_AT','TGL2'], 'safe'],
            //[['CREATE_AT', 'UPDATE_AT'], 'safe'],
            [['SCDL_GROUP', 'STATUS'], 'integer'],
            [['NOTE'], 'string'],
            [['USER_ID'], 'string', 'max' => 50],
            [['CREATE_BY', 'UPDATE_BY'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'TGL' => 'Tgl',
            'SCDL_GROUP' => 'Scdl  Group',
            'USER_ID' => 'User  ID',
            'NOTE' => 'Note',
            'STATUS' => 'Status',
            'CREATE_BY' => 'Create  By',
            'CREATE_AT' => 'Create  At',
            'UPDATE_BY' => 'Update  By',
            'UPDATE_AT' => 'Update  At',
        ];
    }

    public function getScdlgroup(){
      return $this->hasOne(Schedulegroup::className(), ['ID' => 'SCDL_GROUP']);
   }

   public function getUser(){
     return $this->hasOne(Userlogin::className(), ['id' => 'USER_ID']);
  }
}
