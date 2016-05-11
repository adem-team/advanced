<?php

namespace lukisongroup\purchasing\models\pr;

use Yii;

/* namespace models */
use lukisongroup\hrd\models\Employe;
use lukisongroup\master\models\Suplier;
use lukisongroup\master\models\Nmperusahaan;
use lukisongroup\hrd\models\Corp;
/**
 * This is the model class for table "p0001".
 *
 * @property string $ID
 * @property string $KD_PO
 * @property string $KD_SUPPLIER
 * @property string $CREATE_BY
 * @property string $CREATE_AT
 * @property string $APPROVE_BY
 * @property string $APPROVE_AT
 * @property integer $STATUS
 * @property string $NOTE
 */
class Purchaseorder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

     public $CREATE_AT1;
     public $CREATE_AT2;
    public static function tableName()
    {
        return 'p0001';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_esm');
    }

	/*
	 * Join hasOne Purchasing | Employe
	 * @author ptrnov <piter@lukison.com>
	 * @since 1.0
	*/
    public function getEmploye()
    {
        return $this->hasOne(Employe::className(), ['EMP_ID' => 'CREATE_BY']);
    }

	/*
	 * Join hasOne Purchasing | Supplier
	 * @author ptrnov <piter@lukison.com>
	 * @since 1.0
	*/
    public function getSuplier()
    {
        return $this->hasOne(Suplier::className(), ['KD_SUPPLIER' => 'KD_SUPPLIER']);
    }

	public function getNamasuplier()
    {
        return $this->suplier->NM_SUPPLIER;
    }

	/*
	 * Join hasOne NMPERUSAHAAN  | Billing | Local Group Lukison
	 * @author ptrnov <piter@lukison.com>
	 * @since 1.0
	*/
    public function getBill()
    {
        return $this->hasOne(Nmperusahaan::className(), ['ID' => 'BILLING']);
    }

	/*
	 * Join hasOne NMPERUSAHAAN  | Shipping | Local Group Lukison
	 * @author ptrnov <piter@lukison.com>
	 * @since 1.0
	*/
    public function getShip()
    {
        return $this->hasOne(Nmperusahaan::className(), ['ID' => 'SHIPPING']);
    }


	/*
	 * Attribute class getEmploye
	 * used data master not data transaction | name saved table or dirict table trans
	 * return $this->employe->Field
	 * @author ptrnov <piter@lukison>
	 * @since 1.0 |  not continous
	*/
    public function getPembuat()
    {
        return $this->employe->EMP_NM.' '.$this->employe->EMP_NM_BLK;
    }

    public function pembuat()
    {
        return $this->employe->EMP_NM.' '.$this->employe->EMP_NM_BLK;
    }

	public function getCorp()
    {
       return $this->hasOne(Corp::className(), ['CORP_ID' => 'KD_CORP']);
    }

	public function getNmcorp()
    {
        return $this->corp->CORP_NM;
    }

public function getNmcorphistory()
    {
          return $this->corp->CORP_NM;
    }

public function getNmcorpoutbox()
    {
         return $this->corp->CORP_NM;
    }

	/*
	 * Same above
	 * @author ptrnov <piter@lukison>
	 * @since 1.0 |  not continous
	*/
   /*  public function getSetujui()
    {
        return $this->hasOne(Employe::className(), ['EMP_ID' => 'APPROVE_BY']);
    } */

	/*
	 * Same above
	 * @author ptrnov <piter@lukison>
	 * @since 1.0 |  not continous
	*/
    public function getDisetujui()
    {
        if(count($this->setujui) == 0){
            return '';
        } else {
            return $this->setujui->EMP_NM.' '.$this->setujui->EMP_NM_BLK;
        }
    }

	/*
	 * Same above
	 * @author ptrnov <piter@lukison>
	 * @since 1.0 |  not continous
	*/
    public function getApprove()
    {
        return $this->hasOne(Employe::className(), ['EMP_ID' => 'APPROVE_DIR']);
    }

	/*
	 * Same above
	 * @author ptrnov <piter@lukison>
	 * @since 1.0 |  not continous
	*/
    public function getApproved()
    {
        if(count($this->approve) == 0){
            return '';
        } else {
            return $this->approve->EMP_NM.' '.$this->approve->EMP_NM_BLK;
        }
    }


    public function rules()
    {
        return [
			//['KD_SUPPLIER', 'required', 'message' => 'Please choose a username.'],
			[['KD_PO'], 'required'],
            [['KD_PO', 'CREATE_BY', 'CREATE_AT','STATUS', 'NOTE'], 'safe'],
            [['KD_CORP','nmcorp','PAJAK','DISCOUNT', 'ETD', 'ETA', 'SHIPPING', 'BILLING', 'DELIVERY_COST'], 'safe'],
            [['STATUS'], 'integer'],
            [['TOP_DURATION','TOP_TYPE','NOTE'], 'string'],
            [['KD_PO'], 'string', 'max' => 30],
            [['KD_SUPPLIER', 'CREATE_BY'], 'string', 'max' => 50],
			[['SIG1_ID','SIG2_ID','SIG3_ID','SIG4_ID'], 'string'],
			[['SIG1_NM','SIG2_NM','SIG3_NM','SIG4_NM'], 'string'],
			[['SIG1_TGL','SIG2_TGL', 'SIG3_TGL', 'SIG4_TGL'], 'safe'],
			[['SIG1_SVGBASE64','SIG2_SVGBASE64', 'SIG3_SVGBASE64', 'SIG4_SVGBASE64'], 'safe'],
			[['SIG1_SVGBASE30','SIG2_SVGBASE30', 'SIG3_SVGBASE30', 'SIG4_SVGBASE30'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'KD_PO' => 'Kd  Po',
            'KD_SUPPLIER' => 'Kd  Supplier',
            'CREATE_BY' => 'Dibuat Oleh',
            'CREATE_AT' => 'Tanggal di Buat',
            //'APPROVE_BY' => 'Approve  By',
            //'APPROVE_AT' => 'Approve  At',
            //'APPROVE_DIR' => 'Approve  Direksi',
            //'TGL_APPROVE' => 'Tanggal Disetujui',
            'STATUS' => 'Status',
            'ETA' => 'ETA',
            'ETD' => 'ETD',
            'NOTE' => 'Note',
            'pembuat' => Yii::t('app', 'Dibuat Oleh'),
            'disetujui' => Yii::t('app', 'Disetujui Oleh'),
            'approved' => Yii::t('app', 'Disetujui Oleh'),
        ];
    }
}
