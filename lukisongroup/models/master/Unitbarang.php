<?php

namespace lukisongroup\models\master;

use Yii;

/**
 * This is the model class for table "b1003".
 *
 * @property string $id
 * @property string $kd_unit
 * @property string $NM_UNIT
 * @property string $size
 * @property double $wight
 * @property string $color
 * @property string $NOTE
 * @property string $created_by
 * @property string $created_at
 * @property string $updated_by
 * @property string $updated_at
 * @property integer $status
 */
class Unitbarang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'b1003';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db4');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['KD_UNIT', 'NM_UNIT', 'STATUS'], 'required'],
            [['WIGHT'], 'number'],
            [['NOTE'], 'string'],
            [['CREATED_AT', 'UPDATED_AT'], 'safe'],
            [['STATUS'], 'integer'],
            [['KD_UNIT'], 'string', 'max' => 5],
            [['NM_UNIT'], 'string', 'max' => 200],
            [['SIZE', 'COLOR', 'CREATED_BY', 'UPDATED_BY'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'KD_UNIT' => 'Kode Unit',
            'NM_UNIT' => 'Nama Unit',
            'SIZE' => 'Size',
            'WIGHT' => 'Wight',
            'COLOR' => 'Color',
            'NOTE' => 'NOTE',
            'CREATED_BY' => 'Created By',
            'CREATED_AT' => 'Created At',
            'UPDATED_BY' => 'Updated By',
            'UPDATED_AT' => 'Updated At',
            'STATUS' => 'STATUS',
        ];
    }
}
