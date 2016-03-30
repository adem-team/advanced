<?php

namespace lukisongroup\purchasing\models\stck;

use Yii;

/**
 * This is the model class for table "p0005".
 *
 * @property integer $ID
 * @property string $TYPE_PARENT
 * @property string $TYPE_KAT
 * @property integer $TYPE_ID
 * @property string $TYPE_NAME
 * @property string $NOTE
 */
class TipeStock extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'p0005';
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
            [['TYPE_ID'], 'integer'],
            [['NOTE'], 'string'],
            [['TYPE_PARENT'], 'string', 'max' => 1],
            [['TYPE_KAT'], 'string', 'max' => 3],
            [['TYPE_NAME'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => Yii::t('app', 'ID'),
            'TYPE_PARENT' => Yii::t('app', 'PARENT_TYPE
A=RECEVED (REVD|RJK  [IN])
B=RETURE|USAGE [OUT]
C=TABLE JUSTMENT|CLOSING [IN/OUT]
D= INVENTARIS  [HABIS DIPAKAI,PENYUSUTAN]'),
            'TYPE_KAT' => Yii::t('app', 'TYPE_KAT:[IN,OUT]'),
            'TYPE_ID' => Yii::t('app', 'TYPE = ID TYPE'),
            'TYPE_NAME' => Yii::t('app', 'NAMA DARI TYPE'),
            'NOTE' => Yii::t('app', 'KETERANGAN'),
        ];
    }
}
