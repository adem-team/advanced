<?php

namespace lukisongroup\hrd\models;

use Yii;

/**
 * This is the model class for table "machine".
 *
 * @property string $TerminalID
 * @property string $MESIN_NM
 * @property string $MESIN_SN
 * @property string $CAB_ID
 */
class Machine extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'machine';
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
            [['TerminalID'], 'required'],
            [['TerminalID'], 'string', 'max' => 100],
            [['MESIN_NM'], 'string', 'max' => 20],
            [['MESIN_SN'], 'string', 'max' => 50],
            [['CAB_ID'], 'string', 'max' => 5]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'TerminalID' => 'Terminal ID',
            'MESIN_NM' => 'Mesin  Nm',
            'MESIN_SN' => 'Mesin  Sn',
            'CAB_ID' => 'Cab  ID',
        ];
    }
}
