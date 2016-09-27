<?php
namespace lukisongroup\widget\models;
use Yii;

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

    public $parentpilot;
    public $srcparent;
    public $title;
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
            [['PILOT_NM','DESTINATION_TO','DSCRP','TYPE'], 'required','on'=>self::SCENARIO_PARENT],
             [['PILOT_NM','PARENT','DESTINATION_TO','DSCRP','TYPE'], 'required','on'=>self::SCENARIO_CHILD],
            [['PARENT', 'STATUS','SORT','BOBOT','TYPE'], 'integer'],
            [['PLAN_DATE1','PLAN_DATE2','ACTUAL_DATE1', 'ACTUAL_DATE2','UPDATED_TIME','DESTINATION_TO','USER_CC','DESTINATION_TO_DEP','DEP_SUB_ID'], 'safe'],
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

 
}
