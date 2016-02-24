<?php

namespace lukisongroup\hrd\models;

use Yii;

/**
 * This is the model class for table "personallog_usb".
 *
 * @property integer $TerminalID
 * @property string $FingerPrintID
 * @property string $FunctionKey
 * @property string $DateTime
 * @property string $FlagAbsence
 */
class Personallog_usb extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'personallog_usb';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db2');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TerminalID'], 'integer'],
            [['DateTime'], 'safe'],
            [['FingerPrintID', 'FunctionKey', 'FlagAbsence'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'TerminalID' => 'Terminal ID',
            'FingerPrintID' => 'Finger Print ID',
            'FunctionKey' => 'Function Key',
            'DateTime' => 'Date Time',
            'FlagAbsence' => 'Flag Absence',
        ];
    }
}
