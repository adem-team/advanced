<?php

namespace lukisongroup\marketing\models;
use Yii;
//use lukisongroup\master\models\Customers;

/**
 * This is the model class for table "c0023".
 *
 * @property integer $ID
 * @property string $CUST_ID
 * @property string $CUST_NM
 * @property string $PROMO
 * @property string $TGL_START
 * @property string $TGL_END
 * @property integer $OVERDUE
 * @property string $MEKANISME
 * @property string $KOMPENSASI
 * @property string $KETERANGAN
 * @property integer $STATUS
 * @property string $CREATED_BY
 * @property string $CREATED_AT
 * @property string $UPDATED_BY
 * @property string $UPDATED_AT
 */
class SalesPromo extends \yii\db\ActiveRecord
{
	public $KD_PARENT;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c0023';
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
			[['TGL_START','TGL_END','PROMO','STATUS','CUST_ID','OVERDUE'],'required','on'=>'create'],
			[['TGL_START','TGL_END'],'validasiTgl','on'=>'create'],
			[['PROMO', 'MEKANISME', 'KOMPENSASI', 'KETERANGAN'], 'string'],
            [['TGL_START', 'TGL_END', 'CREATED_AT', 'UPDATED_AT'], 'safe'],
            [['OVERDUE', 'STATUS'], 'integer'],
            [['CUST_ID'], 'string', 'max' => 50],
            [['CUST_NM'], 'string', 'max' => 255],
            [['CREATED_BY', 'UPDATED_BY'], 'string', 'max' => 100],
        ];
    }
	
	public function validasiTgl($model){
		if (!$this->hasErrors()) {
			$date1=strtotime(\Yii::$app->formatter->asDate($this->TGL_START,'Y-M-d'));
			$date2=strtotime(\Yii::$app->formatter->asDate($this->TGL_END,'Y-M-d'));
			if ($date2 < $date1) {
					$this->addError($model, 'Tanggal Start Harus lebih kecil dari Tanggal End');
							
			}else{
				return true;
			}
		}
	} 
	
	
	//Gunakan model Search
	//ptr.nov
	public function fields()
	{
		return [
			'CUST_NM'=>function () {
				return $this->CUST_NM;
			},
			'STATUS'=>function () {
				return $this->STATUS==0?'Deactive':($this->STATUS==1?'Aktif':($this->STATUS==2?'panding':''));
			},
			'TGL_START'=>function () {
				return $this->TGL_START;
			},
			'TGL_END'=>function () {
				return $this->TGL_END;
			},			
			'OVERDUE' => function () {
				if($this->STATUS==1){
					$today=date_create(\Yii::$app->formatter->asDate(date("Y-m-d"),'Y-M-d'));
					$date2=date_create(\Yii::$app->formatter->asDate($this->TGL_END,'Y-M-d'));
					$selisih=date_diff($today,$date2);
					if ($today == $date2){
						return 0;
					}elseif($today < $date2){
						return '-'.$selisih->d;
					}elseif($today > $date2){
						return '+'.$selisih->d;
					};			
					// $this->OVERDUE=0;
					// $this->save();
				}else{
					return 0;
				}		
			},
			'PROMO'=>function () {
				return $this->PROMO;
			},
			'MEKANISME'=>function () {
				return $this->MEKANISME;
			},
			'KOMPENSASI'=>function () {
				return $this->KOMPENSASI;
			},
			'KETERANGAN'=>function () {
				return $this->KETERANGAN;
			},
			'CREATED_BY'=>function () {
				return $this->CREATED_BY;
			},
			'CREATED_AT'=>function () {
				return $this->CREATED_AT;
			},
		];
	} 
	
	
	Public function getRunOverdue(){
		if($this->STATUS==1){
			$today=date_create(\Yii::$app->formatter->asDate(date("Y-m-d"),'Y-M-d'));
			$date2=date_create(\Yii::$app->formatter->asDate($this->TGL_END,'Y-M-d'));
			$selisih=date_diff($today,$date2);
			if ($today == $date2){
				return 0;
			}elseif($today < $date2){
				return '-'.$selisih->d;
			}elseif($today > $date2){
				return '+'.$selisih->d;
			};			
			// $this->OVERDUE=0;
			// $this->save();
		}else{
			return 0;
		}		
	}
	// public function getParent() {
		// return $this->hasOne(Customers::classname(),
           // ['CUST_KD'=>'CUST_GRP'])->
           // from(self::tableName() . ' AS parent');
	// }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
			'KD_PARENT'=>'Customer Parent',
            'CUST_ID' => 'Customer',
            'CUST_NM' => 'Customer',
            'PROMO' => 'Promotion',
            'TGL_START' => 'Start Periode',
            'TGL_END' => 'End Periode',
            'OVERDUE' => 'Overdue',
            'MEKANISME' => 'Mekanisme',
            'KOMPENSASI' => 'Kompensasi',
            'KETERANGAN' => 'Description',
            'STATUS' => 'Status',
            'CREATED_BY' => 'Created  By',
            'CREATED_AT' => 'Created  At',
            'UPDATED_BY' => 'Updated  By',
            'UPDATED_AT' => 'Updated  At',
        ];
    }
}
