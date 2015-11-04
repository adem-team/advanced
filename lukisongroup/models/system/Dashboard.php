<?php

namespace app\models\system;

use Yii;

/**
 * This is the model class for table "{{%sa0001}}".
 *
 * @property string $CORP_ID
 * @property string $CORP_NM
 */
class Dashboard extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sa0001}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CORP_ID'], 'string', 'max' => 5],
            [['CORP_NM'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CORP_ID' => Yii::t('app', 'Corp  ID'),
            'CORP_NM' => Yii::t('app', 'Corp  Nm'),
        ];
    }
}
