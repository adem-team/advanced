<?php

namespace lukisongroup\widget\models;

use Yii;
use lukisongroup\hrd\models\Employe;

/**
 * This is the model class for table "sc0003a".
 *
 * @property integer $ID
 * @property string $MESSAGE
 * @property integer $MESSAGE_STS
 * @property integer $MESSAGE_SHOW
 * @property string $MESSAGE_ATTACH
 * @property string $GROUP
 * @property integer $CREATED_BY
 * @property string $UPDATED_TIME
 */
class Chat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sc0003a';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_widget');
    }
	public function getChat()
    {
        return $this->hasOne(Chatroom::className(), ['GROUP_ID' => 'GROUP_ID']);
    }

	public function getEmployee()
    {
        return $this->hasOne(Employe::className(), ['EMP_ID' => 'CREATED_BY']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			  // [['MESSAGE'], 'required'],
            [['MESSAGE','CREATED_BY'], 'string'],
            [['MESSAGE_STS', 'MESSAGE_SHOW','ID'], 'integer'],
            [['UPDATED_TIME'], 'safe'],
            [['MESSAGE_ATTACH'], 'string', 'max' => 100],
            [['GROUP_ID'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'MESSAGE' => 'Message',
            'MESSAGE_STS' => 'Message  Sts',
            'MESSAGE_SHOW' => 'Message  Show',
            'MESSAGE_ATTACH' => 'Message  Attach',
            'GROUP' => 'Group',
            'CREATED_BY' => 'Created  By',
            'UPDATED_TIME' => 'Updated  Time',
        ];
    }
}
