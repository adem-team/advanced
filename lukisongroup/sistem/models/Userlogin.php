<?php

namespace lukisongroup\sistem\models;
use lukisongroup\hrd\models\Employe;
use lukisongroup\sistem\models\Mdlpermission;
use crm\sistem\models\Userprofile;
use kartik\builder\Form;
use Yii;

class Userlogin extends \yii\db\ActiveRecord
{
	 const SCENARIO_USER = 'createuser';



	 public static function getDb()
	{
		/* Author -ptr.nov- : HRD | Dashboard I */
		return \Yii::$app->db1;
	}
	 public $new_pass;
    public static function tableName()
    {
        return '{{dbm001.user}}';
    }

    public function rules()
    {
        return [
      [['username','auth_key','password_hash','POSITION_ACCESS'], 'required','on' => self::SCENARIO_USER],
			[['new_pass','username','status'], 'required','on' =>'updateuser'],
			[['username','auth_key','password_hash','password_reset_token','EMP_ID'], 'string'],
      [['email','avatar','avatarImage'], 'string'],
      [['USER_ALIAS'],'unique','on'=>'updateuseralias'],
			[['id','status','created_at','updated_at'],'integer'],
			[['POSITION_SITE','POSITION_LOGIN','USER_ALIAS'], 'safe'],
		];
    }

		// public function scenarios()
  //   {
  //       $scenarios = parent::scenarios();
  //       $scenarios[self::SCENARIO_USER] = ['username', 'password_hash'];
  //       return $scenarios;
  //   }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'User.ID'),
            'username' => Yii::t('app', 'User Name'),
			'auth_key' => Yii::t('app', 'Access Token'),
			'password_hash' => Yii::t('app', 'Password Hash'),
			'password_reset_token' => Yii::t('app', 'Reset Password'),
			'email' => Yii::t('app', 'Email'),
			'EMP_ID' => Yii::t('app', 'Employe.ID'),
			'created_at' => Yii::t('app', 'Created'),
			'updated_at' => Yii::t('app', 'Update'),
			'avatar' => Yii::t('app', 'Avatar'),
			'avatarImage' => Yii::t('app', 'Avatar Image'),
        ];
    }
	public function getEmp()
	{
		return $this->hasOne(Employe::className(), ['EMP_ID' => 'EMP_ID']);
	}

	public function getMdlpermission()
	{
		return $this->hasOne(Mdlpermission::className(), ['USER_ID' => 'id']);
	}

	public function getUserprofile()
	{
		return $this->hasOne(Userprofile::className(), ['ID' => 'id']);
	}

	/* JOIN Model CrmUserprofile | CRM PROFILE */
	public function getCrmUserprofileTbl()
    {
        return $this->hasOne(CrmUserprofile::className(), ['ID_USER' => 'id']);
    }
	public function getSalesNm() 
    {
        return $this->crmUserprofileTbl!=''?$this->crmUserprofileTbl->NM_FIRST:'none';
    }
    public function getSalesHp() 
    {
        return $this->crmUserprofileTbl!=''?$this->crmUserprofileTbl->HP:'none';
    }

  

	/**
     * Generates password hash from password signature
     *
     * @param string $SIGPASSWORD
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
    public function setPassword_login($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

	/**
     * return Password Signature
     *
     * @param string $SIGPASSWORD
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	public function validateOldPassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);

    }

}
