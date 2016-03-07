<?php

namespace lukisongroup\hrd\models;

use Yii;

/**
 * This is the model class for table "kar_finger".
 *
 * @property string $NO_URUT
 * @property string $TerminalID
 * @property string $KAR_ID
 * @property string $FingerPrintID
 * @property string $FingerTmpl
 * @property string $UPDT
 */
class Kar_finger extends \yii\db\ActiveRecord
{
	public $userNameFinger;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kar_finger';
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
            [['FingerTmpl'], 'string'],
            [['UPDT'], 'safe'],
            [['TerminalID', 'FingerPrintID'], 'string', 'max' => 100],
            [['KAR_ID'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'NO_URUT' => 'No  Urut',
            'TerminalID' => 'Terminal ID',
            'KAR_ID' => 'Kar  ID',
            'FingerPrintID' => 'Finger Print ID',
            'FingerTmpl' => 'Finger Tmpl',
            'UPDT' => 'Updt',
        ];
    }
}
