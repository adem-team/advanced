<?php

namespace lukisongroup\widget\models;

use Yii;

/**
 * This is the model class for table "bt0002".
 *
 * @property string $ID
 * @property string $KD_BERITA
 * @property string $ID_USER
 * @property string $ATTACH64
 * @property integer $TYPE
 * @property integer $STATUS
 * @property string $CREATED_BY
 * @property string $CREATED_AT
 * @property string $UPDATED_AT
 */
class BeritaImage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bt0002';
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
            [['KD_BERITA', 'ID_USER'], 'required'],
            [['ATTACH64'], 'string'],
            [['TYPE', 'STATUS'], 'integer'],
            [['CREATED_AT', 'UPDATED_AT'], 'safe'],
            [['KD_BERITA'], 'string', 'max' => 20],
            [['ID_USER'], 'string', 'max' => 50],
            [['CREATED_BY'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => Yii::t('app', 'ID'),
            'KD_BERITA' => Yii::t('app', 'VALIDASI:
			KD_BERITA AND ID_USER -> inbox'),
            'ID_USER' => Yii::t('app', 'Id  User'),
            'ATTACH64' => Yii::t('app', 'Attach64'),
            'TYPE' => Yii::t('app', 'Type'),
            'STATUS' => Yii::t('app', 'Status'),
            'CREATED_BY' => Yii::t('app', 'Created  By'),
            'CREATED_AT' => Yii::t('app', 'Created  At'),
            'UPDATED_AT' => Yii::t('app', 'Updated  At'),
        ];
    }
}
