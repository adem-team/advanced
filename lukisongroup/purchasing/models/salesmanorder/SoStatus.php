<?php

namespace lukisongroup\purchasing\models\salesmanorder;

use Yii;

/**
 * This is the model class for table "so_0002".
 *
 * @property integer $ID
 * @property string $KD_SO
 * @property string $ID_USER
 * @property integer $STT_PROCESS
 * @property string $UPDATE_AT
 */
class SoStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'so_0002';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_esm');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['STT_PROCESS'], 'integer'],
            [['UPDATE_AT'], 'safe'],
            [['KD_SO', 'ID_USER'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'KD_SO' => 'Kd  So',
            'ID_USER' => 'Id  User',
            'STT_PROCESS' => 'Stt  Process',
            'UPDATE_AT' => 'Update  At',
        ];
    }
}
