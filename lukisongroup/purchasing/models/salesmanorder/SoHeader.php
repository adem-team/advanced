<?php

namespace lukisongroup\purchasing\models\salesmanorder;

use Yii;
use lukisongroup\purchasing\models\salesmanorder\Userprofile;
use lukisongroup\master\models\Customers;

/**
 * This is the model class for table "so_0001".
 *
 * @property string $KD_SO
 * @property string $TGL
 * @property string $USER_SIGN1
 * @property string $TGL_SIGN2
 * @property string $USER_SIGN2
 * @property string $TGL_SIGN3
 * @property string $USER_SIGN3
 */
class SoHeader extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $parent_cusid;
	 public $ISI_MESSAGES;
	
    public static function tableName()
    {
        return 'so_0001';
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
            [['KD_SO'], 'required'],
            [['CUST_ID','USER_SIGN1','parent_cusid'], 'required','on'=>'create'],
            [['STT_PROCESS','ID'], 'integer'],
            [['TGL', 'TGL_SIGN2', 'TGL_SIGN3', 'TGL_SIGN4', 'TGL_SIGN5','CUST_ID','NOTE','TOP_DURATION','TOP_TYPE','TGL_KIRIM','USER_SIGN2','USER_SIGN1', 'USER_SIGN3', 'USER_SIGN4', 'USER_SIGN5'], 'safe'],
            [['KD_SO'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'KD_SO' => 'Kd  So',
            'TGL' => 'TGL.SALES.MD',
            'USER_SIGN1' => 'SALES.MD',
            'TGL_SIGN2' => 'TGL.ADMIN',
            'USER_SIGN2' => 'ESM ADMIN',
            'TGL_SIGN3' => 'TGL.CAM',
            'USER_SIGN3' => 'SALES CAM',
			'TGL_SIGN4' => 'TGL.ACCT',
            'USER_SIGN4' => 'ACCOUNTING',
			'TGL_SIGN5' => 'TGL.WH',
            'USER_SIGN5' => 'WAREHOUSE',
        ];
    }

      public function getCust(){
    return $this->hasOne(Customers::className(), ['CUST_KD'=>'CUST_ID']);
  }


  public function getCustmemoTbl(){
  	return $this->hasOne(CustomercallMemo::className(), ['CUST_ID' => 'KD_CUSTOMER']);
  	
  }
	
	//Sign1- SALES MD
	public function getUserProfileSign1Tbl(){
		return $this->hasOne(Userprofile::className(), ['ID_USER' => 'USER_SIGN1']);
	}	
	public function getSign1(){
		 return $this->userProfileSign1Tbl!=''?$this->userProfileSign1Tbl->IMG_SIGNATURE:'';
	}	
	public function getSign1Nm(){
		 return $this->userProfileSign1Tbl!=''?$this->userProfileSign1Tbl->NM_FIRST:'None';
	}
	public function getSign1Tgl(){
		 return $this->TGL;
	}
	public function getSign1SelisihWaktu(){
		$kini1 = strtotime('now');								//mendapatkan waktu sekarang  
		$kemarin1 = $this->TGL;									//strtotime('yesterday');//mendapatkan waktu kemarin
		$selisih1=$kini1-$kemarin1;								//mendapatkan selisih waktu  
		$jam1 = round((($selisih1 % 604800)%86400)/3600);	//contoh selisih dalam jam  
		return $this->TGL!=''?$jam1:0;
	}
	
	//Sign2- ADMIN
	// public function getUserProfileSign2Tbl(){
		// return $this->hasOne(Userprofile::className(), ['ID_USER' => 'USER_SIGN2']);
	// }	
	public function getUserTbl()
    {
        return $this->hasOne(Userlogin::className(), ['id' => 'USER_SIGN2']);
    }
	public function getUserProfileSign2Tbl(){
		return $this->hasOne(Employe::className(), ['EMP_ID' => 'EMP_ID'])->viatable('dbm001.user',['id' => 'USER_SIGN2']);
	}	
	public function getSign2(){
		 return $this->userProfileSign2Tbl!=''?$this->userProfileSign2Tbl->SIGSVGBASE64:'';
	}	
	public function getSign2Nm(){
		 return $this->userProfileSign2Tbl!=''?$this->userProfileSign2Tbl->EMP_NM.' '.$this->userProfileSign2Tbl->EMP_NM_BLK:'None';
	}
	public function getSign2Tgl(){
		 return $this->TGL_SIGN2;
	}
	public function getSign2SelisihWaktu(){
		$kini2 = strtotime('now');							//mendapatkan waktu sekarang  
		$kemarin2 = $this->TGL_SIGN2;						//strtotime('yesterday');//mendapatkan waktu kemarin
		$selisih2=$kini2-$kemarin2;							//mendapatkan selisih waktu  
		$jam2 = round((($selisih2 % 604800)%86400)/3600);	//contoh selisih dalam jam  
		return $this->TGL_SIGN2!=''?$jam2:0;
	}
	
	//Sign3- CAM
	public function getUserProfileSign3Tbl(){
		return $this->hasOne(Userprofile::className(), ['ID_USER' => 'USER_SIGN3']);
	}	
	public function getSign3(){
		 return $this->userProfileSign3Tbl!=''?$this->userProfileSign3Tbl->IMG_SIGNATURE:'';
	}
	public function getSign3Nm(){
		 return $this->userProfileSign3Tbl!=''?$this->userProfileSign3Tbl->NM_FIRST.' '.$this->userProfileSign2Tbl->EMP_NM_BLK:'None';
	}
	public function getSign3Tgl(){
		 return $this->TGL_SIGN3;
	}
	public function getSign3SelisihWaktu(){
		$kini3 = strtotime('now');							//mendapatkan waktu sekarang  
		$kemarin3 = $this->TGL_SIGN3;						//strtotime('yesterday');//mendapatkan waktu kemarin
		$selisih3=$kini3-$kemarin3;							//mendapatkan selisih waktu  
		$jam3 = round((($selisih2 % 604800)%86400)/3600);	//contoh selisih dalam jam  
		return $this->TGL_SIGN3!=''?$jam3:0;
	}
	
	//Sign43- ACCOUNTING
	public function getUserProfileSign4Tbl(){
		return $this->hasOne(Userprofile::className(), ['ID_USER' => 'USER_SIGN4']);
	}	
	public function getSign4(){
		 return $this->userProfileSign4Tbl!=''?$this->userProfileSign4Tbl->IMG_SIGNATURE:'';
	}
	public function getSign4Nm(){
		 return $this->userProfileSign4Tbl!=''?$this->userProfileSign4Tbl->NM_FIRST:'None';
	}
	public function getSign4Tgl(){
		 return $this->TGL_SIGN4;
	}
	public function getSign4SelisihWaktu(){
		$kini4 = strtotime('now');							//mendapatkan waktu sekarang  
		$kemarin4 = $this->TGL_SIGN4;						//strtotime('yesterday');//mendapatkan waktu kemarin
		$selisih4=$kini4-$kemarin4;							//mendapatkan selisih waktu  
		$jam4 = round((($selisih2 % 604800)%86400)/4600);	//contoh selisih dalam jam  
		return $this->TGL_SIGN4!=''?$jam4:0;
	}
	
	//Sign5- WAREHOUSE
	public function getUserProfileSign5Tbl(){
		return $this->hasOne(Userprofile::className(), ['ID_USER' => 'USER_SIGN5']);
	}	
	public function getSign5(){
		 return $this->userProfileSign5Tbl!=''?$this->userProfileSign5Tbl->IMG_SIGNATURE:'';
	}
	public function getSign5Nm(){
		 return $this->userProfileSign5Tbl!=''?$this->userProfileSign5Tbl->NM_FIRST:'None';
	}
	public function getSign5Tgl(){
		 return $this->TGL_SIGN5;
	}
	public function getSign5SelisihWaktu(){
		$kini5 = strtotime('now');							//mendapatkan waktu sekarang  
		$kemarin5 = $this->TGL_SIGN5;						//strtotime('yesterday');//mendapatkan waktu kemarin
		$selisih5=$kini5-$kemarin5;							//mendapatkan selisih waktu  
		$jam5 = round((($selisih2 % 605800)%86500)/5600);	//contoh selisih dalam jam  
		return $this->TGL_SIGN5!=''?$jam5:0;
	}
}
