<?php

namespace lukisongroup\master\models;

use Yii;

/**
 * This is the model class for table "c0002scdl_plan_proses".
 *
 * @property integer $PROSES_ID
 * @property string $PROSES_NM
 * @property string $DCRIPT
 */
class DraftPlanProses extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c0002scdl_plan_proses';
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
            [['DCRIPT'], 'string'],
            [['PROSES_NM'], 'string', 'max' => 5],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PROSES_ID' => 'Proses  ID',
            'PROSES_NM' => 'Proses  Nm',
            'DCRIPT' => 'Dcript',
        ];
    }
}
