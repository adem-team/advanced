<?php
namespace lukisongroup\widget\models;
use Yii;
use lukisongroup\hrd\models\Employe;

class Pilotproject extends \yii\db\ActiveRecord
{
    /*checkvalidation */
    const SCENARIO_PARENT = 'parent';
    /*checkvalidation */
    const SCENARIO_CHILD = 'child';



    /*checkvalidation */
    const SCENARIO_PARENT_ROOMS = 'parentrooms';
    /*checkvalidation */
    const SCENARIO_CHILD_ROOMS = 'childrooms';

     public $Sendto;
     public $parentpilot;

    public static function tableName()
    {
        return 'sc0001';
    }
  
    public static function getDb()
    {
        return Yii::$app->get('db_widget');
    }


    public function rules()
    {
        return [
             [['PILOT_NM','PLAN_DATE2','PLAN_DATE1','DESTINATION_TO'], 'required','on'=>self::SCENARIO_PARENT_ROOMS],
             [['PILOT_NM','PARENT','PLAN_DATE2','PLAN_DATE1','DESTINATION_TO'], 'required','on'=>self::SCENARIO_CHILD_ROOMS],
            // [['PILOT_NM','STATUS','PLAN_DATE1','PLAN_DATE2'], 'required'],
            [['PILOT_NM','DSCRP','TYPE'], 'required','on'=>self::SCENARIO_PARENT],
             [['PILOT_NM','PARENT','DSCRP','TYPE'], 'required','on'=>self::SCENARIO_CHILD],
            [['PARENT', 'STATUS','SORT','BOBOT','TYPE'], 'integer'],
            [['PLAN_DATE1','PLAN_DATE2','ACTUAL_DATE1', 'ACTUAL_DATE2','UPDATED_TIME','DESTINATION_TO','USER_CC','DESTINATION_TO_DEP','DEP_SUB_ID','COLOR','TEMP_EVENT'], 'safe'],
            [['PILOT_NM'], 'string', 'max' => 255],
			[['DSCRP'], 'string'],
            [['CORP_ID', 'DEP_ID'], 'string', 'max' => 6],
			[['CREATED_BY','UPDATED_BY'], 'string', 'max' => 50]			
        ];
    }

    

    public function attributeLabels()
    {
        return [
            'parentpilot'=>'IsParent',
            'ID' => 'ID',
            'PARENT' => 'Parent Name',
			'SORT'=>'Sort',
			'PILOT_ID' => 'Pilot.ID',
            'PILOT_NM' => 'Schedule.Nm',
			'DSCRP' => 'Description',
            'PLAN_DATE1' => 'Start.Planned',
            'PLAN_DATE2' => 'End.Planned',            
            'ACTUAL_DATE1' => 'Actual.Opening',
            'ACTUAL_DATE2' => 'Actual.Closing',
			'DESTINATION_TO'=>'Send-To',
			'BOBOT'=>'Lavel',
            'CORP_ID' => 'Corp.ID',
            'DEP_ID' => 'Dept.ID',
            'CREATED_BY'=> 'Created',
			'UPDATED_BY'=> 'Updated',
			'UPDATED_TIME'=> 'DateTime',
			'STATUS' => 'Status',
            'DEP_SUB_ID'=>'DEP_SUB'
        ];
    }

    // get parent query : author wawan
public function getParent() {
    return $this->hasOne(self::classname(),
           ['PARENT'=>'SORT'])->
           from(self::tableName() . ' AS PARENT');
}

/* Getter for parent name */
public function getParentName() {
    return $this->parent->PILOT_NM;
}


    /* Join Class Employe */
        public function getEmploye()
        {
            return $this->hasOne(Employe::className(), ['EMP_ID' => 'DESTINATION_TO']);
        }

         /* Join Class Employe */
        public function getEmployecc()
        {
            return $this->hasOne(Employe::className(), ['EMP_ID' => 'USER_CC']);
        }

           /* Join Class Employe */
        public function getEmployenmcc()
        {
            return $this->employecc->EMP_NM != ''?$this->employecc->EMP_NM : 'none';
        }

          /* Join Class Employe */
        public function getEmployenm()
        {
            return $this->employe->EMP_NM != ''?$this->employe->EMP_NM : 'none';
        }

        public function getDateplan(){
             return $this->PLAN_DATE1.' - '.$this->PLAN_DATE2; 
        }

 
}
