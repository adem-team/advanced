<?php

namespace lukisongroup\front\models;

use Yii;

/**
 * This is the model class for table "prc001".
 *
 * @property string $ID
 * @property string $PARENT
 * @property string $SORT_PATENT
 * @property string $PRC_BRG_ID
 * @property string $PRC_BRG_NM
 * @property string $PRC_BRG_SPEK
 * @property string $PRC_BRG_DCRP
 * @property string $KATEGORI
 * @property string $GROUP
 * @property string $TGL_START
 * @property string $TGL_END
 * @property string $CREATED_BY
 * @property string $UPDATED_BY
 * @property string $UPDATED_TIME
 */
class Procurement_item extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'prc001';
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
            [['PARENT', 'SORT_PATENT', 'PRC_BRG_ID','KATEGORI', 'GROUP'], 'integer'],
            [['SORT_PATENT', 'GROUP'], 'required'],
            [['PRC_BRG_SPEK', 'PRC_BRG_DCRP'], 'string'],
            [['TGL_START', 'TGL_END', 'UPDATED_TIME'], 'safe'],
            [['PRC_BRG_NM'], 'string', 'max' => 255],
            [['CREATED_BY', 'UPDATED_BY'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'PARENT' => 'Parent',
            'SORT_PATENT' => 'Sort  Patent',
            'PRC_BRG_ID' => 'Prc  Brg  ID',
            'PRC_BRG_NM' => 'Nama Item',
            'PRC_BRG_SPEK' => 'Spesifikasi',
            'PRC_BRG_DCRP' => 'Keterangan',
			'KATEGORI' => 'Kategori',
            'GROUP' => 'Group',
            'TGL_START' => 'Tgl  Start',
            'TGL_END' => 'Tgl  End',
            'CREATED_BY' => 'Created  By',
            'UPDATED_BY' => 'Updated  By',
            'UPDATED_TIME' => 'Updated  Time',
        ];
    }
}
