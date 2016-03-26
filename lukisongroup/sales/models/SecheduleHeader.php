<?php

namespace lukisongroup\sales\models;

use Yii;

/**
 * This is the model class for table "{{%c0002scdl_header}}".
 *
 * @property string $ID
 * @property string $TGL1
 * @property string $TGL2
 * @property string $SCDL_GROUP
 * @property string $USER_ID
 * @property string $NOTE
 * @property integer $STATUS
 * @property string $CREATE_BY
 * @property string $CREATE_AT
 * @property string $UPDATE_BY
 * @property string $UPDATE_AT
 */
class SecheduleHeader extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%c0002scdl_header}}';
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
            [['TGL1', 'TGL2', 'CREATE_AT', 'UPDATE_AT'], 'safe'],
            [['SCDL_GROUP', 'STATUS'], 'integer'],
            [['NOTE'], 'string'],
            [['USER_ID'], 'string', 'max' => 50],
            [['CREATE_BY', 'UPDATE_BY'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => Yii::t('app', 'ID'),
            'TGL1' => Yii::t('app', 'Tgl1'),
            'TGL2' => Yii::t('app', 'Tgl2'),
            'SCDL_GROUP' => Yii::t('app', 'SELECT RELATION  dbc002->c007'),
            'USER_ID' => Yii::t('app', ' SELECT | RELATION  dbm001->USER_ID '),
            'NOTE' => Yii::t('app', 'Note'),
            'STATUS' => Yii::t('app', 'Status'),
            'CREATE_BY' => Yii::t('app', 'Create  By'),
            'CREATE_AT' => Yii::t('app', 'Create  At'),
            'UPDATE_BY' => Yii::t('app', 'Update  By'),
            'UPDATE_AT' => Yii::t('app', 'Update  At'),
        ];
    }
}
