<?php

namespace lukisongroup\hrd\models;

use Yii;

/**
 * This is the model class for table "p0002".
 *
 * @property string $ID
 * @property string $MODUL_NM
 * @property string $MODUL_DEST
 * @property string $MODUL_POLICY
 * @property string $USER_ID
 * @property integer $STATUS
 * @property string $CREATE_BY
 * @property string $CREATE_AT
 * @property string $UPDATE_BY
 * @property string $UPDATE_AT
 */
class ModulPersonalia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'p0002';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db2');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MODUL_POLICY'], 'string'],
            [['STATUS','MODUL_PRN'], 'integer'],
            [['CREATE_AT', 'UPDATE_AT'], 'safe'],
            [['MODUL_NM', 'MODUL_DEST'], 'string', 'max' => 255],
            [['USER_ID'], 'string', 'max' => 50],
            [['CREATE_BY', 'UPDATE_BY'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => Yii::t('app', 'ID'),
			'MODUL_PRN' => Yii::t('app', 'MODUL.PRN'),
            'MODUL_NM' => Yii::t('app', 'NAMA MODUL HIRS'),
            'MODUL_DEST' => Yii::t('app', 'Modul  Dest'),
            'MODUL_POLICY' => Yii::t('app', 'Modul  Policy'),
            'USER_ID' => Yii::t('app', ' SELECT | RELATION  dbm001->USER_ID '),
            'STATUS' => Yii::t('app', 'Status'),
            'CREATE_BY' => Yii::t('app', 'Create  By'),
            'CREATE_AT' => Yii::t('app', 'Create  At'),
            'UPDATE_BY' => Yii::t('app', 'Update  By'),
            'UPDATE_AT' => Yii::t('app', 'Update  At'),
        ];
    }
}
