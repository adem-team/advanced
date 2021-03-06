<?php

namespace lukisongroup\widget\models;

use Yii;

/**
 * This is the model class for table "m0002".
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
class NotulenModul extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    // scenario check time
    const SCENARIOWAKTU = 'checkwaktu';

    public static function tableName()
    {
        return 'm0002';
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
            [['TIME_START','TIME_END'],'Validtime','on'=>self::SCENARIOWAKTU],
            [['MODUL_POLICY'], 'string'],
            [['STATUS'], 'integer'],
            [['CREATE_AT', 'UPDATE_AT','SCHEDULE','RESULT_SCHEDULE','NOTULEN_ID','TIME_START','TIME_END','USER_ID','KONTAK_PERSON'], 'safe'],
            [['SCHEDULE', 'RESULT_SCHEDULE'], 'string'],
            // [['USER_ID'], 'string', 'max' => 50],
            [['CREATE_BY', 'UPDATE_BY'], 'string', 'max' => 100],
        ];
    }

    public function Validtime($attribute)
    {
             $start =  strtotime($this->TIME_START);
             $end = strtotime($this->TIME_END);
        
        if ( $start > $end) {
                // whatever you have to do here
            $this->addError($attribute,'Time Start greather Time End');
        }

    }

   

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => Yii::t('app', 'ID'),
            'MODUL_NM' => Yii::t('app', 'NAMA MODUL HIRS'),
            'MODUL_DEST' => Yii::t('app', 'Modul  Dest'),
            'MODUL_POLICY' => Yii::t('app', 'Modul  Policy'),
            'USER_ID' => Yii::t('app', ' SELECT | RELATION  dbm001->EMP_ID'),
            'STATUS' => Yii::t('app', 'Status'),
            'CREATE_BY' => Yii::t('app', 'Create  By'),
            'CREATE_AT' => Yii::t('app', 'Create  At'),
            'UPDATE_BY' => Yii::t('app', 'Update  By'),
            'UPDATE_AT' => Yii::t('app', 'Update  At'),
        ];
    }
}
