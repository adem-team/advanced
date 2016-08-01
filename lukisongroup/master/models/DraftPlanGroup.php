<?php

namespace lukisongroup\master\models;

use Yii;

/**
 * This is the model class for table "c0002scdl_plan_group".
 *
 * @property string $SCDL_GROUP
 * @property string $TGL_START
 * @property string $SCL_NM
 * @property string $GEO_ID
 * @property string $LAYER_ID
 * @property integer $DAY_ID
 * @property integer $DAY_VALUE
 * @property string $USER_ID
 * @property integer $STATUS
 * @property string $CREATED_BY
 * @property string $CREATED_AT
 * @property string $UPDATED_BY
 * @property string $UPDATED_AT
 */
class DraftPlanGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c0002scdl_plan_group';
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
            [['TGL_START', 'CREATED_AT', 'UPDATED_AT'], 'safe'],
            [['SCL_NM'], 'required'],
            [['GEO_ID', 'LAYER_ID', 'DAY_ID', 'DAY_VALUE', 'STATUS'], 'integer'],
            [['SCL_NM', 'USER_ID'], 'string', 'max' => 50],
            [['CREATED_BY', 'UPDATED_BY'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SCDL_GROUP' => 'Scdl  Group',
            'TGL_START' => 'Tgl  Start',
            'SCL_NM' => 'Scl  Nm',
            'GEO_ID' => 'Geo  ID',
            'LAYER_ID' => 'Layer  ID',
            'DAY_ID' => 'Day  ID',
            'DAY_VALUE' => 'Day  Value',
            'USER_ID' => 'User  ID',
            'STATUS' => 'Status',
            'CREATED_BY' => 'Created  By',
            'CREATED_AT' => 'Created  At',
            'UPDATED_BY' => 'Updated  By',
            'UPDATED_AT' => 'Updated  At',
        ];
    }
}
