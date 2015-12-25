<?php

namespace lukisongroup\purchasing\models;

use Yii;
use lukisongroup\hrd\models\Employe;
use lukisongroup\hrd\models\Dept;
use lukisongroup\purchasing\models\Rodetail;
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
	//const STATUS_PROCESS = 0;
	//const STATUS_APPROVED = 10;
	//const STATUS_DELETE = 3;
	//const STATUS_REJECT = 4;
	
   
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
	
	/**
	 * @return array
	 */
	/* public static function getStatusesList()
	{
		return [
			self::STATUS_PROCESS => 'PROCESS',
			self::STATUS_APPROVED => 'APPROVED',	
			self::STATUS_REJECT => 'REJECT',
			self::STATUS_DELETE => 'DELETE',
		];
	} */
	/**
	 * @return string
	 */
	/* public function getStatusLabel()
	{
		return static::getStatusesList()[$this->STATUS];
	} */
	
    public function getDetro()
    {
        return $this->hasMany(Rodetail::className(), ['KD_RO' => 'KD_RO']);
    }
	
	public function getCunit()
    {
        return $this->hasOne(Unitbarang::className(), ['KD_UNIT' => 'detro.UNIT']);
    }
	
    public function getEmploye()
    {
        return $this->hasOne(Employe::className(), ['EMP_ID' => 'ID_USER']);
    } 
	
	public function getDept()
    {
        return $this->hasOne(Dept::className(), ['DEP_ID' => 'KD_DEP']);
    } 
   /*  public function getNmemp()
    {
        return $this->employe->EMP_NM;
    } */
	
    /* public function getTess()
    {
        return $this->hasOne(Tes::className(), ['KD_RO' => 'KD_RO']);
    } */
	
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//          [['KD_RO', 'NOTE', 'ID_USER', 'KD_CORP', 'KD_CAB', 'KD_DEP', 'STATUS', 'CREATED_AT', 'UPDATED_ALL', 'DATA_ALL'], 'required'],
			[['KD_RO'], 'required'],          
            [['NOTE', 'DATA_ALL'], 'string'],
            [['STATUS'], 'integer'],
            [['CREATED_AT'], 'safe'],
            [['KD_RO'], 'safe'],
            [['KD_RO', 'KD_CORP', 'KD_CAB', 'KD_DEP'], 'string', 'max' => 50],
            [['UPDATED_ALL', 'ID_USER','SIG2_NM'], 'string', 'max' => 255],
			[['SIG1_SVGBASE64','SIG1_SVGBASE30','SIG2_SVGBASE64','SIG2_SVGBASE30','SIG2_TGL'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'KD_RO' => 'Kode RO',
			'TGL'  => 'Tanggal',
            'NOTE' => 'Note',
            'ID_USER' => 'Id.User',
            'KD_CORP' => 'Kd.Corp',
            'KD_CAB' => 'Kd.Cab',
            'KD_DEP' => 'Kd.Dep',
            'STATUS' => 'Status',
            'CREATED_AT' => 'Created.At',
            'UPDATED_ALL' => 'Updated.All',
            'DATA_ALL' => 'Data.All',
			
			//'nmemp' => Yii::t('app', 'Pembuat'),
        ];
    }
}
