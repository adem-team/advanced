<?php

namespace lukisongroup\hrd\models;

use Yii;

use lukisongroup\hrd\models\Machine;
use lukisongroup\hrd\models\MachineSearch;
use lukisongroup\hrd\models\Key_list;
use lukisongroup\hrd\models\Key_listSearch;


class Personallog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'personallog';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db2');
    }

	public function getMachines(){		
		return $this->hasOne(Machine::className(),['TerminalID'=>'TerminalID']);
	}
	
	public function getMachine_nm(){
		//return $this->machines->MESIN_NM;
		return $this->machines!=''?$this->machines->MESIN_NM:'unknown';
	}
	
	public function getKeys(){
		return $this->hasOne(Key_list::className(),['FunctionKey'=>'FunctionKey']);
	}
	
	public function getKeys_nm(){
		//return $this->keys->FunctionKeyNM;
		return $this->keys!=''?$this->keys->FunctionKeyNM:'unknown';
	}
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tgllog','tgllate','Edited', 'DateTime', 'tgl', 'waktu'], 'safe'],
            [['TerminalID', 'UserName', 'FlagAbsence'], 'string', 'max' => 100],
            [['UserID'], 'string', 'max' => 50],
            [['FunctionKey'], 'string', 'max' => 15]
        ];
    }

	
/* 	public function fields()
	{
		return [
			'tgl2'=>function($model){
							return 'DateTime';
					},
		];
	} */
	
	
	public function getTgllog(){
		return $this->DateTime;		
	}
	public function getTgllate(){
		return $this->DateTime;		
	}
	
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idno' => 'Idno',
            'TerminalID' => 'Terminal ID',
            'UserID' => 'User ID',
            'FunctionKey' => 'Function Key',
            'Edited' => 'Edited',
            'UserName' => 'User Name',
            'FlagAbsence' => 'Flag Absence',
            'DateTime' => 'Date Time',
            'tgl' => 'Tgl',
            'waktu' => 'Waktu',
        ];
    }
}
