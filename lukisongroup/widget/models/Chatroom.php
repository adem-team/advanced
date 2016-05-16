<?php

namespace lukisongroup\widget\models;

use Yii;

/**
 * This is the model class for table "sc0003b".
 *
 * @property integer $ID
 * @property integer $PARENT
 * @property integer $SORT
 * @property string $GROUP_ID
 * @property string $GROUP_NM
 */
class Chatroom extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sc0003b';
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
            [['PARENT', 'SORT'], 'integer'],
            [['GROUP_NM'], 'required'],
            [['GROUP_ID'], 'string', 'max' => 5],
            [['GROUP_NM'], 'string', 'max' => 30],
			[['IMAGE64'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'PARENT' => 'Parent',
            'SORT' => 'Sort',
            'GROUP_ID' => 'Group  ID',
            'GROUP_NM' => 'Group  Nm',
			'IMAGE64'=>'image'
        ];
    }
}
