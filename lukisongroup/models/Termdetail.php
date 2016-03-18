<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "c0003a".
 *
 * @property integer $ID
 * @property string $ID_TERM
 * @property string $ID_USER
 * @property integer $STATUS
 * @property string $UPDATE_AT
 */
class Termdetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c0003a';
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
            [['ID_TERM', 'ID_USER', 'STATUS'], 'required'],
            [['STATUS'], 'integer'],
            [['UPDATE_AT'], 'safe'],
            [['ID_TERM'], 'string', 'max' => 50],
            [['ID_USER'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'ID_TERM' => 'Id  Term',
            'ID_USER' => 'Id  User',
            'STATUS' => 'Status',
            'UPDATE_AT' => 'Update  At',
        ];
    }
}
