<?php

namespace crm\salesman\models;

use Yii;


/**
 * This is the model class for table "c0007".
 *
 * @property integer $ID
 * @property string $SCDL_GROUP_NM
 * @property string $KETERANGAN
 * @property integer $STATUS
 * @property string $CREATE_BY
 * @property string $CREATE_AT
 * @property string $UPDATE_BY
 * @property string $UPDATE_AT
 */
class Schedulegroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public static function tableName()
    {
        return 'c0007';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_esm');
    }


	// public function getCust(){
		 // return $this->hasMany(Customers::className(), ['SCDL_GROUP' => 'ID']);
	// }

	// public function getCust_nm()
    // {
        // return $this->cust->CUST_NM;
    // }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['KETERANGAN'], 'string'],
            [['STATUS'], 'integer'],
            [['CREATE_AT', 'UPDATE_AT'], 'safe'],
            [['SCDL_GROUP_NM'], 'string', 'max' => 255],
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
            'SCDL_GROUP_NM' => 'Scdl  Group  Nm',
            'KETERANGAN' => 'Keterangan',
            'STATUS' => 'Status',
            'CREATE_BY' => 'Create  By',
            'CREATE_AT' => 'Create  At',
            'UPDATE_BY' => 'Update  By',
            'UPDATE_AT' => 'Update  At',
        ];
    }
}
