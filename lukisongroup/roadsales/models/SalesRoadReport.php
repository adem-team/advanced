<?php

namespace lukisongroup\roadsales\models;

use Yii;

/**
 * This is the model class for table "c0022List".
 *
 */
class SalesRoadReport extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c0022Rpt';
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
            [['CASE_ID'], 'string'],
            [['STATUS'], 'integer'],
            [['TGL','CREATED_AT','CREATED_BY'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'CASE_ID' => 'Case  ID',
            'STATUS' => 'Status',
            'TGL' => 'DATE',
            'CREATED_BY' => 'Created  By',
            'CREATED_AT' => 'Created  At'
        ];
    }
}
