<?php

namespace lukisongroup\purchasing\models\rqt;

use Yii;

/**
 * This is the model class for table "t0000_file".
 *
 * @property integer $ID
 * @property string $IMG_BASE64
 * @property string $TERM_ID
 * @property string $KD_RIB
 * @property string $CREATED_BY
 * @property string $CREATED_AT
 */
class Arsipterm extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $file_image;
    public static function tableName()
    {
        return 't0000_file';
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
            [['CREATED_AT','IMG_BASE64'], 'safe'],
            [['TERM_ID'], 'string', 'max' => 225],
            [['KD_RIB'], 'string', 'max' => 50],
            [['CREATED_BY'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'IMG_BASE64' => 'Img  Base64',
            'TERM_ID' => 'Term  ID',
            'KD_RIB' => 'Kd  Rib',
            'CREATED_BY' => 'Created  By',
            'CREATED_AT' => 'Created  At',
        ];
    }
}
