<?php

namespace lukisongroup\models\esm;

use Yii;

/**
 * This is the model class for table "b0002".
 *
 * @property integer $idBarang
 * @property string $kodeBarang
 * @property string $namaBarang
 */
class Barangmaxi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'b0002';
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
            [['KD_BARANG', 'NM_BARANG'], 'required'],
            [['KD_BARANG', 'NM_BARANG'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID_BARANG' => 'Id Barang',
            'KD_BARANG' => 'Kode Barang',
            'NM_BARANG' => 'Nama Barang',
        ];
    }
}
