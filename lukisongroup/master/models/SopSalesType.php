<?php

namespace lukisongroup\master\models;

use Yii;

/**
 * This is the model class for table "c0021type".
 *
 * @property integer $ID
 * @property integer $SOP_TYPE
 * @property string $SOP_NM
 * @property string $DESCRIPTION
 * @property integer $STATUS
 * @property string $CREATE_AT
 * @property integer $CREATE_BY
 * @property string $UPDATE_AT
 * @property integer $UPDATE_BY
 */
class SopSalesType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c0021type';
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
            [['SOP_TYPE', 'STATUS', 'CREATE_BY', 'UPDATE_BY'], 'integer'],
            [['DESCRIPTION'], 'string'],
            [['CREATE_AT', 'UPDATE_AT'], 'safe'],
            [['SOP_NM'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'SOP_TYPE' => 'Sop  Type',
            'SOP_NM' => 'Sop  Nm',
            'DESCRIPTION' => 'Description',
            'STATUS' => 'Status',
            'CREATE_AT' => 'Create  At',
            'CREATE_BY' => 'Create  By',
            'UPDATE_AT' => 'Update  At',
            'UPDATE_BY' => 'Update  By',
        ];
    }
}
