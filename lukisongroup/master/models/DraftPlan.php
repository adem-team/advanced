<?php

namespace lukisongroup\master\models;

use Yii;

/**
 * This is the model class for table "c0002scdl_plan".
 *
 * @property string $ID
 * @property string $CUST_KD
 * @property string $GEO_ID
 * @property string $LAYER_ID
 * @property integer $DAY_ID
 * @property integer $DAY_VALUE
 * @property integer $STATUS
 * @property string $CREATED_BY
 * @property string $CREATED_AT
 * @property string $UPDATED_BY
 * @property string $UPDATED_AT
 */
class DraftPlan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c0002scdl_plan';
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
            [['CUST_KD'], 'required'],
            [['GEO_ID', 'LAYER_ID', 'DAY_ID', 'DAY_VALUE', 'STATUS'], 'integer'],
            [['CREATED_AT', 'UPDATED_AT'], 'safe'],
            [['CUST_KD'], 'string', 'max' => 50],
            [['CREATED_BY', 'UPDATED_BY'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'CUST_KD' => 'Cust  Kd',
            'GEO_ID' => 'Geo  ID',
            'LAYER_ID' => 'Layer  ID',
            'DAY_ID' => 'Day  ID',
            'DAY_VALUE' => 'Day  Value',
            'STATUS' => 'Status',
            'CREATED_BY' => 'Created  By',
            'CREATED_AT' => 'Created  At',
            'UPDATED_BY' => 'Updated  By',
            'UPDATED_AT' => 'Updated  At',
        ];
    }
}
