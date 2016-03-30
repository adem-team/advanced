<?php

namespace lukisongroup\purchasing\models\stck;

use Yii;

/**
 * This is the model class for table "p0008".
 *
 * @property string $ID
 * @property string $TGL
 * @property integer $TYPE
 * @property string $KD_JUST
 * @property string $KD_DEPT
 * @property string $PIC
 * @property string $ID_BARANG
 * @property string $NM_BARANG
 * @property string $UNIT
 * @property string $UNIT_NM
 * @property string $UNIT_QTY
 * @property string $UNIT_WIGHT
 * @property string $QTY
 * @property string $NOTE
 * @property integer $STATUS
 * @property string $CREATE_BY
 * @property string $CREATE_AT
 * @property string $UPDATE_BY
 * @property string $UPDATE_AT
 */
class StockClosing extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'p0008';
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
            [['TYPE', 'STATUS'], 'integer'],
            [['UNIT_QTY', 'UNIT_WIGHT', 'QTY'], 'number'],
            [['NOTE'], 'string'],
            [['KD_JUST'], 'string', 'max' => 50],
            [['KD_DEPT'], 'string', 'max' => 5],
            [['PIC', 'ID_BARANG', 'UNIT', 'CREATE_BY', 'UPDATE_BY'], 'string', 'max' => 100],
            [['NM_BARANG', 'UNIT_NM'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => Yii::t('app', 'ID'),
            'TGL' => Yii::t('app', 'Tgl'),
            'TYPE' => Yii::t('app', 'TABLE TYPE p0005'),
            'KD_JUST' => Yii::t('app', 'CREATE KD_REF [USAGE|RETURE]'),
            'KD_DEPT' => Yii::t('app', 'REF TABLE dbm002.u0002a'),
            'PIC' => Yii::t('app', 'USER YANG AMBI: BARANG'),
            'ID_BARANG' => Yii::t('app', 'BASE ON PO -> p0001'),
            'NM_BARANG' => Yii::t('app', 'BASE ON PO -> p0001'),
            'UNIT' => Yii::t('app', 'REF TABLE ub0001'),
            'UNIT_NM' => Yii::t('app', 'REF TABLE ub0001'),
            'UNIT_QTY' => Yii::t('app', 'REF TABLE ub0001'),
            'UNIT_WIGHT' => Yii::t('app', 'REF TABLE ub0001'),
            'QTY' => Yii::t('app', 'QUANTITY INPUT'),
            'NOTE' => Yii::t('app', 'CATATAN'),
            'STATUS' => Yii::t('app', 'STATUS DELETE =3'),
            'CREATE_BY' => Yii::t('app', 'Create  By'),
            'CREATE_AT' => Yii::t('app', 'Create  At'),
            'UPDATE_BY' => Yii::t('app', 'Update  By'),
            'UPDATE_AT' => Yii::t('app', 'Update  At'),
        ];
    }
}
