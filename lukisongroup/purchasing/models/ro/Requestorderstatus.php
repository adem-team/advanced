<?php

namespace lukisongroup\purchasing\models\ro;

use Yii;

/**
 * This is the model class for table "r0002".
 *
 * @property string $ID
 * @property string $KD_RO
 * @property string $ID_USER
 * @property string $TYPE
 * @property integer $STATUS
 * @property string $UPDATED_AT
 * @property string $tes
 */
class Requestorderstatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'r0002';
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
            [['KD_RO', 'ID_USER', 'TYPE', 'STATUS', 'UPDATED_AT'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'KD_RO' => 'Kd.Ro',
            'ID_USER' => 'Id.Emp',
            'TYPE' => 'Type',
            'STATUS' => 'Status', /*Status For Notification 1=Send 2=checked 3=approved = 23/32=checked&approved (close)*/
            'UPDATED_AT' => 'Updated  At',
        ];
    }
}
