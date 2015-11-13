<?php

namespace lukisongroup\models\esm\ro;

use Yii;
use lukisongroup\models\esm\ro\Rodetail;
use lukisongroup\models\hrd\Employe;

/**
 * This is the model class for table "r0001".
 *
 * @property string $ID
 * @property string $KD_RO
 * @property string $NOTE
 * @property string $ID_USER
 * @property string $KD_CORP
 * @property string $KD_CAB
 * @property string $KD_DEP
 * @property integer $STATUS
 * @property string $CREATED_AT
 * @property string $UPDATED_ALL
 * @property string $DATA_ALL
 */
class Tes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tes1';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_esm');
    }
	
	/*
	public function getEmploy()
	{
		return $this->hasOne(Employe::className(), ['EMP_ID' => 'EMP_ID']);
		//return $this->hasMany(Pendidikan::className(), ['EMP_ID' => 'EMP_ID']);
	}
	*/
	
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['KD_RO', 'NOTE', 'ID_USER', 'KD_CORP', 'KD_CAB', 'KD_DEP', 'STATUS', 'CREATED_AT', 'UPDATED_ALL', 'DATA_ALL'], 'required'],
            [['KD_RO', 'ISI'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ISI' => 'ID',
            'KD_RO' => 'Kode RO',
        ];
    }
}
