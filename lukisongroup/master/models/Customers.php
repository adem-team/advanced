<?php

namespace lukisongroup\master\models;

use Yii;

use lukisongroup\master\models\Schedulegroup;


/**
 * This is the model class for table "c0001".
 *
 * @property string $CUST_KD
 * @property string $CUST_KD_ALIAS
 * @property string $CUST_NM
 * @property string $CUST_GRP
 * @property integer $CUST_KTG
 * @property string $JOIN_DATE
 * @property string $MAP_LAT
 * @property string $MAP_LNG
 * @property string $KD_DISTRIBUTOR
 * @property string $PIC
 * @property string $ALAMAT
 * @property integer $TLP1
 * @property integer $TLP2
 * @property integer $FAX
 * @property string $EMAIL
 * @property string $WEBSITE
 * @property string $NOTE
 * @property string $NPWP
 * @property integer $STT_TOKO
 * @property string $DATA_ALL
 * @property string $CAB_ID
 * @property string $CORP_ID
 * @property string $CREATED_BY
 * @property string $CREATED_AT
 * @property string $UPDATED_BY
 * @property string $UPDATED_AT
 * @property integer $STATUS
 */
class Customers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	// public $tipenm;
    public $cus_Type;
    public $cust_ktg;
    public $parentnama;
    public $CusNm;
    public $CusT; // model manipulate form_scdl and contrroler create-scdl
    public $GruPCusT; // model manipulate form_scdl and contrroler create-scdl
    public static function tableName()
    {
        return 'c0001';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    //
    public static function getDb()
    {
        return Yii::$app->get('db3');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			      //  [['CUST_NM','STT_TOKO','KD_DISTRIBUTOR','PROVINCE_ID','CITY_ID'], 'required'],
              [['CUST_GRP'], 'required','on'=>'export'], //export validasi
              [['CUST_NM'],'required','on'=>'create'],
               // ['CUST_NM', 'unique', 'targetAttribute' => 'CUST_NM'], // uniqe name
               [['CUST_GRP','CUST_NM'], 'required','on'=>'parentcreate'],

              [['CUST_NM'],'validasi','on'=>'create'],
              [['CUST_NM'],'validasi','on'=>'parentcreate'],
              // [['CUST_GRP'], 'required','when' => function ($model) {
              //     return $model->parentnama == 1; },
              //     'whenClient' => "function (attribute, value) {
              //         return $('#customers-parentnama:checked').val() == '1';
              //     }"
              //     ],
              [['PROVINCE_ID','CITY_ID'], 'required','on'=>'detail'],
              [['CUST_TYPE','CUST_KTG'], 'required','on'=>'updatekat'],// for action updatekat scenario
            // [['CUST_NM','CUST_KTG','JOIN_DATE','KD_DISTRIBUTOR','PROVINCE_ID','CITY_ID','NPWP', 'TLP1','STT_TOKO'], 'required'],
            [['CUST_TYPE','CUST_KTG','STT_TOKO', 'STATUS','PROVINCE_ID','SCDL_GROUP','CITY_ID','LAYER','GEO'], 'integer'],
			[['TLP1', 'TLP2', 'FAX','CUST_GRP'],'safe'],
            [['JOIN_DATE', 'CREATED_AT', 'UPDATED_AT'], 'safe'],
            [['ALAMAT', 'NOTE'], 'string'],
            [['CUST_KD', 'CUST_KD_ALIAS', 'MAP_LAT', 'MAP_LNG', 'NPWP','KD_DISTRIBUTOR'], 'string', 'max' => 50],
            [['CUST_NM', 'PIC', 'EMAIL', 'WEBSITE', 'DATA_ALL'], 'string', 'max' => 255],
            [['CAB_ID', 'CORP_ID'], 'string', 'max' => 6],
            [['CREATED_BY', 'UPDATED_BY'], 'string', 'max' => 100]
        ];
    }

    // get parent query : author wawan
public function getParent() {
    return $this->hasOne(self::classname(),
           ['CUST_KD'=>'CUST_GRP'])->
           from(self::tableName() . ' AS parent');
}

 public function validasi($model)
    {
      
      $data_customers = Yii::$app->db_esm->createCommand("SELECT DISTINCT CUST_NM FROM `c0001` where CUST_NM='".$this->CUST_NM."' and STATUS <>2")->queryScalar();


      if($data_customers === $this->CUST_NM)
      {
        $this->addError($model, 'duplicate name');
      }

    }



public function getNameColumn()
{

 $data_column = new Customers();
 return $dbSchema = $data_column->getTableSchema()->getColumnNames();

}


/* Getter for parent name */
public function getParentName() {
    return $this->parent->CUST_NM;
}

	public function getCus()
	{
		return $this->hasOne(Kategoricus::className(), ['CUST_KTG' => 'CUST_KTG']);

	}

	public function getCustype()
	{
		return $this->hasOne(Kategoricus::className(), ['CUST_KTG' => 'CUST_TYPE']);

	}

	public function getCustgrp(){
		return $this->hasOne(Schedulegroup::className(), ['ID'=>'SCDL_GROUP']);
	}

  public function getCustprov(){
    return $this->hasOne(Province::className(), ['PROVINCE_ID'=>'PROVINCE_ID']);
  }
  public function getCustkota(){
    return $this->hasOne(Kota::className(), ['POSTAL_CODE'=>'CITY_ID']);
  }

  public function getCustdis(){
    return $this->hasOne(Distributor::className(), ['KD_DISTRIBUTOR'=>'KD_DISTRIBUTOR']);
  }



	// public function getGrp_nm()
  //   {
  //       return $this->custgrp->SCDL_GROUP_NM;
  //   }



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CusT' =>'Group',
            'GruPCusT'=>'Customers',
            'CUST_KTG_NM' => 'Kategori Customers',
            'parentnama' => 'Is Parent',
            'CITY_ID' => 'KOTA',
            'PROVINCE_ID' => 'PROVINCE',
            'CUST_KD' => 'Kode Customers',
            'CUST_KD_ALIAS' => 'Kode Customers Alias',
            'CUST_NM' => 'Nama Customer',
            'CUST_GRP' => 'Customers Group',
            'CUST_KTG' => 'Category',
            'cus.CUST_KTG_NM' => 'Category',
            'CUST_TYPE' => 'Type',
            'JOIN_DATE' => 'Tanggal Gabung',
            'MAP_LAT' => 'Map  Lat',
            'MAP_LNG' => 'Map  Lng',
            'KD_DISTRIBUTOR' => 'Nama Distributor',
            'PIC' => 'PIC Customer',
            'ALAMAT' => 'Alamat',
            'TLP1' => ' Nomer Telepon 1',
            'TLP2' => 'Nomer Telepon 2',
            'FAX' => 'Fax',
            'EMAIL' => 'Email',
            'WEBSITE' => 'Website',
            'NOTE' => 'Note',
            'NPWP' => 'NPWP',
            'STT_TOKO' => 'Status Toko',
            'DATA_ALL' => 'Data  All',
            'CAB_ID' => 'Cab  ID',
            'CORP_ID' => 'Corp  ID',
            'CREATED_BY' => 'Created  By',
            'CREATED_AT' => 'Created  At',
            'UPDATED_BY' => 'Updated  By',
            'UPDATED_AT' => 'Updated  At',
            'STATUS' => 'Status',
        ];
    }
}
