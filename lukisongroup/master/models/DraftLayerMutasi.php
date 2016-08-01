<?php

namespace lukisongroup\master\models;

use Yii;

/**
 * This is the model class for table "c0002scdl_layer_mutasi".
 *
 * @property string $ID
 * @property string $TGL
 * @property integer $LAYER_ID
 * @property string $CUST_KD
 * @property string $NOTE
 * @property string $APPROVED_BY
 * @property integer $STATUS
 * @property string $CREATE_BY
 * @property string $CREATE_AT
 * @property string $UPDATE_BY
 * @property string $UPDATE_AT
 */
class DraftLayerMutasi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c0002scdl_layer_mutasi';
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
            [['TGL', 'CREATE_AT', 'UPDATE_AT'], 'safe'],
            [['LAYER_ID', 'STATUS'], 'integer'],
            [['NOTE'], 'string'],
            [['CUST_KD', 'APPROVED_BY', 'CREATE_BY', 'UPDATE_BY'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'TGL' => 'Tgl',
            'LAYER_ID' => 'Layer  ID',
            'CUST_KD' => 'Cust  Kd',
            'NOTE' => 'Note',
            'APPROVED_BY' => 'Approved  By',
            'STATUS' => 'Status',
            'CREATE_BY' => 'Create  By',
            'CREATE_AT' => 'Create  At',
            'UPDATE_BY' => 'Update  By',
            'UPDATE_AT' => 'Update  At',
        ];
    }
}
