<?php

namespace lukisongroup\models\esm\po;

use Yii;

use lukisongroup\models\hrd\Employe;

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


    public function getEmploye()
    {
        return $this->hasOne(Employe::className(), ['EMP_ID' => 'CREATE_BY']);
    }
    
    public function getPembuat()
    {
        return $this->employe->EMP_NM.' '.$this->employe->EMP_NM_BLK;
    }


    public function getSetujui()
    {
        return $this->hasOne(Employe::className(), ['EMP_ID' => 'APPROVE_BY']);
    }
    
    public function getDisetujui()
    {
        if(count($this->setujui) == 0){ 
            return ''; 
        } else {
            return $this->setujui->EMP_NM.' '.$this->setujui->EMP_NM_BLK;
        }
    }


    public function getApprove()
    {
        return $this->hasOne(Employe::className(), ['EMP_ID' => 'APPROVE_DIR']);
    }
    
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
			['KD_SUPPLIER', 'required', 'message' => 'Please choose a username.'],
            [['KD_PO', 'CREATE_BY', 'CREATE_AT', 'APPROVE_BY', 'APPROVE_AT', 'STATUS', 'NOTE'], 'safe'],
            [['CREATE_AT', 'APPROVE_AT','PAJAK','DISC', 'ETD', 'ETA', 'SHIPPING', 'BILLING', 'DELIVERY_COST',  'APPROVE_DIR', 'TGL_APPROVE'], 'safe'],
            [['STATUS'], 'integer'],
            [['NOTE'], 'string'],
            [['KD_PO'], 'string', 'max' => 30],
            [['KD_SUPPLIER', 'CREATE_BY', 'APPROVE_BY'], 'string', 'max' => 50]
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
            'APPROVE_BY' => 'Approve  By',
            'APPROVE_AT' => 'Approve  At',
            'APPROVE_DIR' => 'Approve  Direksi',
            'TGL_APPROVE' => 'Tanggal Disetujui',
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
