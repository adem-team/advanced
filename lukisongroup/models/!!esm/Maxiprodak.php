<?php

namespace lukisongroup\models\esm;

use Yii;

/**
 * This is the model class for table "{{%maxi_b0001}}".
 *
 * @property string $BRG_ID
 * @property string $BRG_NM
 */
class Maxiprodak extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	 
	 public static function getDb()
	{
		return \Yii::$app->db_esm;  // use the "db3" application component
	}
    public static function tableName()
    {
        return '{{dbc002.b0001}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['BRG_ID'], 'required'],
            [['BRG_ID'], 'string', 'max' => 50],
            [['BRG_NM'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'BRG_ID' => Yii::t('app', 'Brg  ID'),
            'BRG_NM' => Yii::t('app', 'Brg  Nm'),
        ];
    }
}
