<?php

namespace lukisongroup\purchasing\models\pr;

use Yii;

/**
 * This is the model class for table "p0004".
 *
 * @property string $KD_COSTCENTER
 * @property string $NM_COSTCENTER
 * @property string $KETERANGAN
 * @property integer $STATUS
 * @property string $CREATE_BY
 * @property string $CREATE_AT
 * @property string $UPDATE_BY
 * @property string $UPDATE_AT
 */
class Costcenter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'p0004';
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
            [['KD_COSTCENTER'], 'required'],
            [['KETERANGAN'], 'string'],
            [['STATUS'], 'integer'],
            [['CREATE_AT', 'UPDATE_AT'], 'safe'],
            [['KD_COSTCENTER', 'CREATE_BY', 'UPDATE_BY'], 'string', 'max' => 100],
            [['NM_COSTCENTER'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'KD_COSTCENTER' => 'Kd  Costcenter',
            'NM_COSTCENTER' => 'Nm  Costcenter',
            'KETERANGAN' => 'Keterangan',
            'STATUS' => 'Status',
            'CREATE_BY' => 'Create  By',
            'CREATE_AT' => 'Create  At',
            'UPDATE_BY' => 'Update  By',
            'UPDATE_AT' => 'Update  At',
        ];
    }
}
