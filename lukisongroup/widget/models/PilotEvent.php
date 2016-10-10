<?php

namespace lukisongroup\widget\models;

use Yii;

/**
 * This is the model class for table "sc0001a".
 *
 * @property integer $ID
 * @property string $NM_EVENT
 * @property integer $STATUS
 * @property string $COLOR
 * @property string $CREATED_BY
 * @property string $CREATED_AT
 * @property string $DEP_ID
 */
class PilotEvent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sc0001a';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_widget');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['STATUS'], 'integer'],
            [['COLOR'], 'string'],
            [['CREATED_AT'], 'safe'],
            [['NM_EVENT', 'DEP_ID'], 'string', 'max' => 225],
            [['CREATED_BY'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'NM_EVENT' => 'Nm  Event',
            'STATUS' => 'Status',
            'COLOR' => 'Color',
            'CREATED_BY' => 'Created  By',
            'CREATED_AT' => 'Created  At',
            'DEP_ID' => 'Dep  ID',
        ];
    }
}
