<?php

namespace lukisongroup\sistem\models;

use Yii;

/**
 * This is the model class for table "personallog_inout".
 *
 * @property string $idno
 * @property string $TerminalID
 * @property string $UserID
 * @property string $FunctionKey
 * @property string $Edited
 * @property string $UserName
 * @property string $FlagAbsence
 * @property string $DateTime
 * @property string $tgl
 * @property string $waktu
 */
class Absensi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'personallog_inout';
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
            [['Edited', 'DateTime', 'tgl', 'waktu'], 'safe'],
            [['TerminalID', 'UserName', 'FlagAbsence'], 'string', 'max' => 100],
            [['UserID'], 'string', 'max' => 50],
            [['FunctionKey'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idno' => 'Idno',
            'TerminalID' => 'Terminal ID',
            'UserID' => 'User ID',
            'FunctionKey' => 'Function Key',
            'Edited' => 'Edited',
            'UserName' => 'User Name',
            'FlagAbsence' => 'Flag Absence',
            'DateTime' => 'Date Time',
            'tgl' => 'Tgl',
            'waktu' => 'Waktu',
        ];
    }
}
