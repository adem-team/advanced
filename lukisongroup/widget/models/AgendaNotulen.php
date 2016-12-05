<?php

namespace lukisongroup\widget\models;

use Yii;
use lukisongroup\hrd\models\Employe;

/**
 * This is the model class for table "M0003".
 *
 * @property integer $ID
 * @property integer $NOTULEN_ID
 * @property string $DESCRIPTION
 * @property string $DATE_LINE
 * @property string $PIC
 * @property integer $CREATE_BY
 * @property string $CREATE_AT
 * @property integer $UPDATE_BY
 * @property string $UPDATE_AT
 */
class AgendaNotulen extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'm0003';
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
            [['NOTULEN_ID', 'CREATE_BY', 'UPDATE_BY'], 'integer'],
            [['DESCRIPTION'], 'string'],
            [['DATE_LINE', 'CREATE_AT', 'UPDATE_AT'], 'safe'],
            [['PIC'], 'string', 'max' => 225],
        ];
    }

     public function getAgendaTbl2(){
        return $this->hasOne(Employe::className(), ['EMP_ID' => 'PIC']);
    }

    public function getNamePic(){
        return $this->agendaTbl2 != ''? $this->agendaTbl2->EMP_NM.' '.$this->agendaTbl2->EMP_NM_BLK : 'none';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'NOTULEN_ID' => 'Notulen  ID',
            'DESCRIPTION' => 'Description',
            'DATE_LINE' => 'Date  Line',
            'PIC' => 'Pic',
            'CREATE_BY' => 'Create  By',
            'CREATE_AT' => 'Create  At',
            'UPDATE_BY' => 'Update  By',
            'UPDATE_AT' => 'Update  At',
        ];
    }
}
