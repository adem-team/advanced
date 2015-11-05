<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dbc002.a0001".
 *
 * @property integer $DBTR_ID
 * @property string $DBTR_NM
 * @property integer $DBTR_STT
 * @property string $DBTR_JOIN
 * @property string $DBTR_PIC
 * @property string $DBTR_ALMT
 * @property string $DBTR_ID_TLP
 */
class distributor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	 public static function getDb()
	{
		return \Yii::$app->db2;  // use the "db3" application component
	}
	 
    public static function tableName()
    {
        return 'a0001';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['DBTR_STT'], 'integer'],
//            [['DBTR_JOIN'], 'safe'],
            [['DBTR_ALMT'], 'string'],
            [['DBTR_ALMT'], 'required', 'message' => 'Alamat tidak boleh kosong.'],
			
            [['DBTR_NM', 'DBTR_PIC'], 'string', 'max' => 30],
            [['DBTR_NM'], 'required', 'message' => 'Nama Distributor tidak boleh kosong.'],
            [['DBTR_PIC'], 'required', 'message' => 'Nama Penanggung Jawab tidak boleh kosong.'],
			
            [['DBTR_ID_TLP'], 'string', 'max' => 20],
            [['DBTR_ID_TLP'], 'required', 'message' => 'Nomor Telephone tidak boleh kosong.'],
            [['DBTR_ID_TLP'], 'integer', 'message' => 'Nomor Telephone harus berupa angka.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'DBTR_ID' => 'Distributor Id',
            'DBTR_NM' => 'Nama Distributor',
            'DBTR_STT' => 'Distributor  Status',
            'DBTR_JOIN' => 'Tanggal Bergabung',
            'DBTR_PIC' => 'Penanggung Jawab',
            'DBTR_ALMT' => 'Alamat',
            'DBTR_ID_TLP' => 'Nomor Telephone',
        ];
    }
}
