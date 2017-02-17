<?php

namespace lukisongroup\warehouse\models;

use Yii;

/**
 * This is the model class for table "so_0003TypeKtg".
 *
 * @property integer $ID
 * @property integer $TYPE
 * @property integer $TYPE_KTG
 * @property string $TYPE_NM
 * @property string $DSCRPT
 */
class TypeSrcDes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'so_0003TypeSrcDes';
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
            [['TYPE', 'SRC_DEST'], 'integer'],
            [['DSCRPT'], 'string'],
            [['TYPE_NM'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'TYPE' => 'Type',
            'SRC_DEST' => 'SRC_DEST',
            'TYPE_NM' => 'Type  Nm',
            'DSCRPT' => 'Dscrpt',
        ];
    }
	
	
}
