<?php

namespace lukisongroup\models\it;

use Yii;

/**
 * This is the model class for table "proggresjob".
 *
 * @property integer $proggres_id
 * @property string $user_id
 * @property string $modul
 * @property string $judul
 * @property string $keterangan
 * @property string $start_data
 * @property string $end_date
 * @property string $proggres
 * @property integer $status
 */
class Proggresjob extends \yii\db\ActiveRecord
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
        return 'dbm005.proggresjob';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['start_data', 'end_date'], 'safe'],
            [['status'], 'integer'],
            [['user_id', 'proggres'], 'string', 'max' => 10],
            [['modul'], 'string', 'max' => 20],
            [['judul'], 'string', 'max' => 30],
            [['keterangan'], 'filter', 'filter' => function($value) {
    return trim(htmlentities(strip_tags($value), ENT_QUOTES, 'UTF-8'));
}],


            [['keterangan_detail','proggres_id','start_data'], 'safe'],
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'proggres_id' => 'Proggres ID',
            'user_id' => 'User ID',
            'modul' => 'Modul',
            'judul' => 'Judul',
            'keterangan' => 'Keterangan',
            'start_data' => 'Start Data',
            'end_date' => 'End Date',
            'proggres' => 'Proggres',
            'status' => 'Status',
        ];
    }

    /**
     * @inheritdoc
     * @return ProggresjobQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProggresjobQuery(get_called_class());
    }
}
