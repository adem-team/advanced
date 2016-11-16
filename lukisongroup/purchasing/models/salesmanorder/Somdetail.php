<?php

namespace lukisongroup\purchasing\models\salesmanorder;

use Yii;

/**
 * This is the model class for table "so_0001".
 *
 * @property string $KD_SO
 * @property string $TGL
 * @property string $USER_SIGN1
 * @property string $TGL_SIGN2
 * @property string $USER_SIGN2
 * @property string $TGL_SIGN3
 * @property string $USER_SIGN3
 */
class Somdetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'so_0001';
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
            [['KD_SO'], 'required'],
            [['TGL', 'TGL_SIGN2', 'TGL_SIGN3'], 'safe'],
            [['KD_SO', 'USER_SIGN1', 'USER_SIGN2', 'USER_SIGN3'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'KD_SO' => 'Kd  So',
            'TGL' => 'Tgl',
            'USER_SIGN1' => 'User  Sign1',
            'TGL_SIGN2' => 'Tgl  Sign2',
            'USER_SIGN2' => 'User  Sign2',
            'TGL_SIGN3' => 'Tgl  Sign3',
            'USER_SIGN3' => 'User  Sign3',
        ];
    }
}
