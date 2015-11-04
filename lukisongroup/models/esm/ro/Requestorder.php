<?php

namespace lukisongroup\models\esm\ro;

use Yii;
use lukisongroup\models\esm\ro\Rodetail;
use lukisongroup\models\esm\ro\Tes;
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
class Requestorder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'r0001';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_esm');
    }
	
    public function getDetro()
    {
        return $this->hasMany(Rodetail::className(), ['KD_RO' => 'KD_RO']);
    }
	
    public function getEmploye()
    {
        return $this->hasOne(Employe::className(), ['EMP_ID' => 'ID_USER']);
    }
	
    public function getNmemp()
    {
        return $this->employe->EMP_NM;
    }
	
    public function getTess()
    {
        return $this->hasOne(Tes::className(), ['KD_RO' => 'KD_RO']);
    }
	
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['KD_RO', 'NOTE', 'ID_USER', 'KD_CORP', 'KD_CAB', 'KD_DEP', 'STATUS', 'CREATED_AT', 'UPDATED_ALL', 'DATA_ALL'], 'required'],
            [['NOTE', 'DATA_ALL'], 'string'],
            [['STATUS'], 'integer'],
            [['CREATED_AT'], 'safe'],
            [['KD_RO'], 'safe'],
            [['KD_RO', 'KD_CORP', 'KD_CAB', 'KD_DEP'], 'string', 'max' => 50],
            [['UPDATED_ALL', 'ID_USER'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'KD_RO' => 'Kode RO',
            'NOTE' => 'Note',
            'ID_USER' => 'Id  User',
            'KD_CORP' => 'Kd  Corp',
            'KD_CAB' => 'Kd  Cab',
            'KD_DEP' => 'Kd  Dep',
            'STATUS' => 'Status',
            'CREATED_AT' => 'Created  At',
            'UPDATED_ALL' => 'Updated  All',
            'DATA_ALL' => 'Data  All',
			'nmemp' => Yii::t('app', 'Pembuat'),
        ];
    }
}
