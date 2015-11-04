<?php

namespace lukisongroup\models\it;

use Yii;

/**
 * This is the model class for table "proggresjobdetail".
 *
 * @property integer $proggresjobdetail_id
 * @property integer $progress_id
 * @property string $created_date
 * @property string $keterangan
 * @property string $pic
 */
class Proggresjobdetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    /* [1] SOURCE DB */
    public static function getDb()
    {
        /* Author -ptr.nov- : HRD */
        return \Yii::$app->db_widget;
    }

    public static function tableName()
    {
        return 'dbm005.proggresjobdetail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['progress_id'], 'integer'],
            [['created_date'], 'safe'],
            [['keterangan'], 'string', 'max' => 200],
            [['pic'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'proggresjobdetail_id' => 'Proggresjobdetail ID',
            'progress_id' => 'Progress ID',
            'created_date' => 'Created Date',
            'keterangan' => 'Keterangan',
            'pic' => 'Pic',
        ];
    }

    /**
     * @inheritdoc
     * @return ProggresjobdetailQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProggresjobdetailQuery(get_called_class());
    }
}
