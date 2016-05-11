<?php

namespace lukisongroup\widget\models;

use Yii;

/**
 * This is the model class for table "a1000".
 *
 * @property integer $ID
 * @property string $KD_BERITA
 * @property string $JUDUL
 * @property string $ISI
 * @property string $KD_CORP
 * @property string $KD_CAB
 * @property string $KD_DEP
 * @property string $DATA_PICT
 * @property string $DATA_FILE
 * @property integer $STATUS
 * @property string $CREATED_ATCREATED_BY
 * @property string $CREATED_BY
 * @property string $UPDATE_AT
 * @property string $DATA_ALL
 */
class BeritaNotify extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bt0001notify';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_widget');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['KD_BERITA'], 'string'],
            [['STATUS','TYPE'], 'integer'],
            [['CREATED_AT','CREATED_BY'], 'safe'],
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
          'alluser'=>'',
            'ID' => 'ID',
            'KD_BERITA' => 'Kd  Berita',
            'JUDUL' => 'Judul',
            'ISI' => 'Isi',
            'KD_CORP' => 'Kd  Corp',
            'KD_CAB' => 'Kd  Cab',
            'KD_DEP' => 'Kd  Dep',
            'DATA_PICT' => 'Data  Pict',
            'DATA_FILE' => 'Data  File',
            'STATUS' => 'Status',
            'CREATED_ATCREATED_BY' => 'Created  Atcreated  By',
            'CREATED_BY' => 'Created  By',
            'UPDATE_AT' => 'Update  At',
            'DATA_ALL' => 'Data  All',
        ];
    }
}
