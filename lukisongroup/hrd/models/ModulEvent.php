<?php

namespace lukisongroup\hrd\models;
use lukisongroup\hrd\models\ModulPersonalia;
use Yii;

/**
 * This is the model class for table "p0001".
 *
 * @property string $ID
 * @property string $TGL_START
 * @property string $TGL_END
 * @property string $TITLE
 * @property string $USER_ID
 * @property string $MODUL_HIRS
 * @property integer $STATUS
 * @property string $CREATE_BY
 * @property string $CREATE_AT
 * @property string $UPDATE_BY
 * @property string $UPDATE_AT
 */
class ModulEvent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'p0001';
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
            [['id','USER_ID','start', 'end', 'CREATE_AT', 'UPDATE_AT'], 'safe'],
            [['MODUL_ID','MODUL_PRN', 'STATUS'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['CREATE_BY', 'UPDATE_BY'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'start' => Yii::t('app', 'Tgl  Start'),
            'end' => Yii::t('app', 'Tgl  End'),
            'title' => Yii::t('app', 'Title'),
            'USER_ID' => Yii::t('app', 'User  ID'),
            'MODUL_PRN' => Yii::t('app', 'MODUL.PRN'),
            'MODUL_ID' => Yii::t('app', 'MODUL.ID'),
            'STATUS' => Yii::t('app', 'Status'),
            'CREATE_BY' => Yii::t('app', 'Create  By'),
            'CREATE_AT' => Yii::t('app', 'Create  At'),
            'UPDATE_BY' => Yii::t('app', 'Update  By'),
            'UPDATE_AT' => Yii::t('app', 'Update  At'),
        ];
    }

	public function getModulPesonalia()
    {
        return $this->hasOne(ModulPersonalia::className(), ['id' => 'MODUL_ID']);
    }
    // public function getModul_nm()
    // {
    //     return $this->modulPesonalia->MODUL_NM;
    // }
}
