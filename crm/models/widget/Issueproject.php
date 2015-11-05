<?php

namespace lukisongroup\models\widget;

use Yii;

/**
 * This is the model class for table "sc0002".
 *
 * @property string $ID
 * @property string $PARENT
 * @property string $ISSUE_NM
 * @property string $ISSUE_DESC
 * @property integer $PRIORITY
 * @property string $CLOSE_DATETIME
 * @property string $USER_CREATED
 * @property integer $STATUS
 * @property string $CORP_ID
 * @property string $DEP_ID
 * @property string $OPEN_DATETIME
 */
class Issueproject extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sc0002';
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
            [['PARENT', 'PRIORITY', 'USER_CREATED', 'STATUS'], 'integer'],
            [['ISSUE_DESC'], 'string'],
            [['CLOSE_DATETIME', 'OPEN_DATETIME'], 'safe'],
            [['ISSUE_NM'], 'string', 'max' => 100],
            [['CORP_ID', 'DEP_ID'], 'string', 'max' => 5]
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
            'ISSUE_NM' => 'Issue  Nm',
            'ISSUE_DESC' => 'Issue  Desc',
            'PRIORITY' => 'Priority',
            'CLOSE_DATETIME' => 'Close  Datetime',
            'USER_CREATED' => 'User  Created',
            'STATUS' => 'Status',
            'CORP_ID' => 'Corp  ID',
            'DEP_ID' => 'Dep  ID',
            'OPEN_DATETIME' => 'Open  Datetime',
        ];
    }
}
