<?php

namespace lukisongroup\widget\models;

use Yii;

/**
 * This is the model class for table "m0001".
 *
 * @property string $id
 * @property string $start
 * @property string $end
 * @property string $title
 * @property string $USER_ID
 * @property string $MODUL
 * @property integer $STATUS
 * @property string $CREATE_BY
 * @property string $CREATE_AT
 * @property string $UPDATE_BY
 * @property string $UPDATE_AT
 */
class Memo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'm0001';
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
            [['start', 'end', 'CREATE_AT', 'UPDATE_AT'], 'safe'],
            [['MODUL', 'STATUS'], 'integer'],
            [['title'], 'string', 'max' => 255],
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
            'id' => Yii::t('app', 'ID'),
            'start' => Yii::t('app', 'Start'),
            'end' => Yii::t('app', 'End'),
            'title' => Yii::t('app', 'Title'),
            'USER_ID' => Yii::t('app', 'User  ID'),
            'MODUL' => Yii::t('app', 'MODUL -> M0002'),
            'STATUS' => Yii::t('app', 'Status'),
            'CREATE_BY' => Yii::t('app', 'Create  By'),
            'CREATE_AT' => Yii::t('app', 'Create  At'),
            'UPDATE_BY' => Yii::t('app', 'Update  By'),
            'UPDATE_AT' => Yii::t('app', 'Update  At'),
        ];
    }
}
