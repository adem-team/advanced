<?php

namespace lukisongroup\widget\models;

use Yii;

/**
 * This is the model class for table "a1001".
 *
 * @property integer $ID
 * @property string $KD_BERITA
 * @property integer $ID_USER
 * @property integer $TYPE
 * @property integer $STATUS
 * @property string $CREATED_BY
 * @property string $CREATED_AT
 * @property string $UPDATED_AT
 */
class Detailberita extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'a1001';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_sss');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['KD_BERITA', 'ID_USER'], 'required'],
            [['ID_USER', 'TYPE', 'STATUS'], 'integer'],
            [['CREATED_AT', 'UPDATED_AT'], 'safe'],
            [['KD_BERITA'], 'string', 'max' => 20],
            [['CREATED_BY'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'KD_BERITA' => 'Kd  Berita',
            'ID_USER' => 'Id  User',
            'TYPE' => 'Type',
            'STATUS' => 'Status',
            'CREATED_BY' => 'Created  By',
            'CREATED_AT' => 'Created  At',
            'UPDATED_AT' => 'Updated  At',
        ];
    }
}
