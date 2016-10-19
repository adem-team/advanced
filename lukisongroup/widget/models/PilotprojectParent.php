<?php
namespace lukisongroup\widget\models;

use Yii;
use yii\base\Model;
use lukisongroup\widget\models\Pilotproject;


/**
 * BACA 
 * CREATE/UPDATE Parent Utama.
 * Locate : button rooms.
 * 1. Parent Utama tidak bisa diubah ke child, karena parent sudah atau akan ada pengkut/flowed child.
 * 2. Ditampilkan pada menu select untuk child sesuai tanggal (lebih kecil atau sama dengan) / tgllebih besar probidden.
 * 3. Parent Utama bisa untuk Public atau Private.
 * 4. Show day, akan ditampilkan semua detail sesuai date plan1 dan plan2 dari parent utama.
 * 5. Closing untuk actual harus lebih besar dari tgl plan1, dan bisa lebih besar atau lebih kecil dari tglplan2.
 * @author ptrnov  <piter@lukison.com>
 * @since 1.1
 */
class PilotprojectParent extends Model
{
    public $pARENT_ID;				//ID parent Auto Increment.
    public $pARENT_NM;				//Nama parent	value (Nama parent ditambah tgl).
	public $pARENT_TGLPLAN1;		//TGL PLAN1. default current date atau customize +  TIME PLAN1 default value 00:00:01.
	public $pARENT_TGLPLAN2;		//TGL PLAN2. customize. validate( pARENT_TGLPLAN2>pARENT_TGLPLAN1) + TIME PLAN2 default value 23:59:00.
	public $pARENT_TGLACTUAL1;		//TGL ACTUAL1 (jika kosong maka value pARENT_TGLPLAN1, pARENT_TGLACTUAL1>=pARENT_TGLPLAN1 ).
	public $pARENT_TIMEACTUAL1;		//TIME ACTUAL1 customize.
	public $pARENT_TGLACTUAL2;		//TGL ACTUAL2 (pARENT_TGLACTUAL2 current datetime, until closing).
	public $pARENT_TIMEACTUAL2;		//TIME ACTUAL2 customize.
	public $pARENT_TYPE;			//1 = private and 0 = public.
	public $pARENT_STATE;			//0=child; 1=Parent Utama ; 2=Patent sub1; 2=Patent sub2, dst.
	public $DESTINATION_TO;			//receved atau penerima, personal atau department.
	const SCENARIO_PARENT = 'create';

	public function rules()
    {
        return [
			['pARENT_NM', 'required'],
			[['pARENT_NM','DESTINATION_TO'], 'string'],
			[['pARENT_TGLPLAN1','pARENT_TGLPLAN2','DESTINATION_TO'], 'required','on'=>self::SCENARIO_PARENT],
			//[['pARENT_TGLPLAN2','validateTglPlan2']],
			//[['pARENT_TGLACTUAL1','validateTglActual1']],
			//[['pARENT_TGLACTUAL2','validateTglActual2']],
			[['pARENT_TGLPLAN1','pARENT_TGLPLAN2','pARENT_TGLACTUAL1','pARENT_TGLACTUAL2'], 'safe'],
			[['pARENT_TIMEACTUAL1','pARENT_TIMEACTUAL2'], 'safe'],
			//[['pARENT_TYPE','pARENT_STATE'], 'required'],
			[['pARENT_STATE','pARENT_TYPE'], 'integer']
			
        ];
    }

	/**
     * Validation pARENT_TGLPLAN2
	 * pARENT_TGLPLAN2 >= pARENT_TGLPLAN1
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1.0
     */
	public function validateTglPlan2($attribute, $params)
    {
		
    }

	/**
     * Validation pARENT_TGLACTUAL1.
	 * if pARENT_TGLACTUAL1=0, then pARENT_TGLPLAN1.
	 * pARENT_TGLACTUAL1 >= pARENT_TGLPLAN1.
	 * @author ptrnov  <piter@lukison.com>.
	 * @since 1.1.0
     */
	public function validateTglActual1($attribute, $params)
    {
		
    }
	
	/**
     * Validation pARENT_TGLACTUAL1.
	 * if pARENT_TGLACTUAL2=0, then Current datetime sampai closing.
	 * pARENT_TGLACTUAL2 >= pARENT_TGLACTUAL1.
	 * @author ptrnov  <piter@lukison.com>.
	 * @since 1.1.0
     */
	public function validateTglActual2($attribute, $params)
    {
		
    }
	
	/*
	 * Check validation
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
	*/
	public function auth_saved(){
		if ($this->validate()) {	
			$model = new Pilotproject();		
			//$model->PARENT = $id;
			//$model->SORT = $id;
			$model->PILOT_NM =  $this->pARENT_NM;
			
				// print_r($model->PILOT_NM);
			// die();
			
			$model->PLAN_DATE1 = Yii::$app->formatter->asDatetime($this->pARENT_TGLPLAN1 .' 00:00:01', 'php:Y-m-d H:i:s');
			$model->PLAN_DATE2 = Yii::$app->formatter->asDatetime($this->pARENT_TGLPLAN2 .' 00:00:01', 'php:Y-m-d H:i:s');
			$model->DEP_ID =  Yii::$app->getUserOpt->Profile_user()->emp->DEP_ID;		
			$model->DESTINATION_TO = $this->DESTINATION_TO;		
			$model->CREATED_BY= Yii::$app->user->identity->username;		
			$model->UPDATED_TIME = date('Y-m-d h:i:s'); 
			if($model->save()){
				return false;
			};			
			//$model->save();
			/* print_r($model->getErrors());
			die(); */
			//return true; 
		}
		return true;
	}
	
	    public function attributeLabels()
    {
        return [
            'pARENT_NM'=>'Paren.Name',
            'pARENT_TGLPLAN1' => 'Start Date.Plan',
            'pARENT_TGLPLAN2' => 'End Date.Plan',    
        ];
    }


}
