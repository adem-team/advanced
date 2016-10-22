<?php

namespace lukisongroup\widget\controllers;

use yii;
use kartik\datecontrol\Module;
use yii\helpers\Json;
use yii\rest\ActiveController;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
//use common\models\User;
use lukisongroup\models\system\user\UserloginSearch;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\web\HttpException;


use api\modules\chart\models\Cnfweek; 
use api\modules\chart\models\Cnfmonth;
use lukisongroup\widget\models\Pilotproject;
use lukisongroup\widget\models\PilotEvent;
use lukisongroup\hrd\models\Employe;
use lukisongroup\esm\models\Kategoricus;
use lukisongroup\widget\models\PilotprojectSearch;
use lukisongroup\widget\models\PilotprojectParent;


class PilotprojectChatController extends Controller
{
	//public $modelClass = 'api\modules\chart\models\Cnfweek';
	
	 public function behaviors()    {
        return ArrayHelper::merge(parent::behaviors(), [
			'bootstrap'=> [
				'class' => ContentNegotiator::className(),
				'formats' => [
					'application/json' => Response::FORMAT_JSON,'charset' => 'UTF-8',
				],
				'languages' => [
					'en',
					'de',
				],
			]
        ]);
		
    }
   	
	/**
     * @inheritdoc
     */
	public function actions()
	{
		$actions = parent::actions();
		unset($actions['update'], $actions['create'], $actions['delete'], $actions['view']);
		//unset($actions['update'], $actions['create'], $actions['delete'], $actions['view']);
		return $actions;
	}
		
	public function actionIndex()
     {
		
		return $this->chartGanttPlanActual();
		// echo $this->gt_deptid();
		//return $this->parent6milestone();
		// return $this->parent4process_task();		
     }
	 
	/**
	* FUSIONCHAT GANTT PLAN ACTUAL 
	* Status : Fixed, Dept.
	* ========== BACA ================
	* UPDATE
	* Locate : Tab View Pilot Project.
	* 1. update Source : chart,categories
	* @since 1.1
	* author piter novian [ptr.nov@gmail.com].
	*/
	public function chartGanttPlanActual(){
		//***kategory Month
		$monthCtg= new ActiveDataProvider([
            'query' => Cnfmonth::find()->asArray(),
			'pagination' => [
					'pageSize' => 24,
				],			 
        ]);
		
		//***kategory Week
		$weekCtg= new ActiveDataProvider([
            'query' => Cnfweek::find()->asArray(),
			'pagination' => [
					'pageSize' => 200,
			],			 
        ]);	
		
		//***get Data Pilotproject
		$_modalPilot= new ActiveDataProvider([
			'query' => Pilotproject::find()->Where(['CREATED_BY'=>Yii::$app->user->identity->username])->asArray(),
			'pagination' => [
					'pageSize' => 200,
				],				 
		]);
		//***Task
		foreach($_modalPilot->getModels() as $row => $value){
			$taskCtg[]=[
				'label'=>$value['PILOT_NM'],
				'id'=>strval($value['ID']),
			];					
			$taskPIC[]=[
				'label'=>$value['CREATED_BY'],
			];	
		};
		
		//***get plan actual pilot project
		$_modalActualPlan= new ArrayDataProvider([
			'allModels' => Yii::$app->db_widget->createCommand("
					SELECT *,x1.ID as IDX
					FROM sc0001 x1 RIGHT JOIN sc0001b x2 on x1.ENABLE_ACTUAL=x2.ENABLE_ACTUAL 
					WHERE x2.ENABLE_ACTUAL=2;					
			")->queryAll(),
			'pagination' => [
					'pageSize' => 400,
			],				 
		]);
		$aryPlanActual=ArrayHelper::toArray($_modalActualPlan->getModels());
		//***Task
		foreach($aryPlanActual as $row => $value){			
			if ($value['ENABLE_NM']=='PLAN'){
				$task[]=[
					"label"=> "Planned",
					"processid"=> strval($value['IDX']),
					"start"=> Yii::$app->formatter->asDatetime($value['PLAN_DATE1'], 'php:Y-m-d'),
					"end"=> Yii::$app->formatter->asDatetime($value['PLAN_DATE2'], 'php:Y-m-d'),
					"id"=> strval($value['IDX'])."-1",
					"color"=> "#008ee4",
					"height"=> "32%",
					"toppadding"=> "12%"
				];				
			}elseif($value['ENABLE_NM']=='ACTUAL'){
				$task[]=[
					"label"=> "Actual",
					"processid"=> strval($value['IDX']),
					"start"=> Yii::$app->formatter->asDatetime($value['PLAN_DATE1'], 'php:Y-m-d'),
					"end"=> Yii::$app->formatter->asDatetime($value['PLAN_DATE2'], 'php:Y-m-d'),
					"id"=> strval($value['IDX']),
					"color"=> "#6baa01",
					"toppadding"=> "56%",
					"height"=> "32%"
				];	
			};
		};
			 
		// print_r($task);
		// die();
		$cntTask=sizeof($taskCtg);
		$maxRow=$cntTask<=26?(26-$cntTask):$cntTask;
		/* if($cntTask==0){
			$maxRow=29;
		}elseif($cntTask<=29){
			$maxRow=29-$cntTask;
		}else{
			$maxRow=$cntTask;
		} */
		
		for ($x = 0; $x <= $maxRow; $x++) {
			$taskCtgKosong[]=[
				'label'=>'',
				'id'=>''
			];	 
		}		 
		$mrgTaskCtg=ArrayHelper::merge($taskCtg,$taskCtgKosong);
		
		for ($x = 0; $x <= $maxRow; $x++) {
			$taskPICKosong[]=[
				'label'=>''
			];	 
		}
		$mrgtaskPIC=ArrayHelper::merge($taskPIC,$taskPICKosong);
		
		$rslt='{
			"chart": {
				"subcaption": "Pilot Project Planned vs Actual",                
				"dateformat": "yyyy-mm-dd",
				"outputdateformat": "ddds mns yy",
				"ganttwidthpercent": "70",
				"ganttPaneDuration": "50",
				"ganttPaneDurationUnit": "d",
				"flatScrollBars": "0",				
				"fontsize": "14",	
				"exportEnabled": "1",				
				"plottooltext": "$processName{br} $label starting date $start{br}$label ending date $end",
				"theme": "fint"
				
			},
			"categories": [							
				{
					"bgcolor": "#33bdda",
					"align": "middle",
					"fontcolor": "#ffffff",						
					"fontsize": "12",
					"category": '.Json::encode($monthCtg->getModels()).'
				},
				{
					"bgcolor": "#ffffff",
					"fontcolor": "#1288dd",
					"fontsize": "11",
					"isbold": "1",
					"align": "center",
					"category": '.Json::encode($weekCtg->getModels()).'
				}
			],
			"processes": {
				"headertext": "Pilot Task",
				"fontcolor": "#000000",
				"fontsize": "10",
				"isanimated": "1",
				"bgcolor": "#6baa01",
				"headervalign": "middle",
				"headeralign": "center",
				"headerbgcolor": "#6baa01",
				"headerfontcolor": "#ffffff",
				"headerfontsize": "12",
				"width":"200",
				"align": "left",
				"isbold": "1",
				"bgalpha": "25",
				"process": '.Json::encode($mrgTaskCtg).'
			},
			"datatable": {
                "headervalign": "bottom",
                "datacolumn": [
                    {
                        "headertext": "PIC",
                        "fontcolor": "#000000",
						"fontsize": "10",
						"isanimated": "1",
						"bgcolor": "#6baa01",
						"headervalign": "middle",
						"headeralign": "center",
						"headerbgcolor": "#6baa01",
						"headerfontcolor": "#ffffff",
						"headerfontsize": "12",
						"width":"150",
						"align": "left",
						"isbold": "1",
						"bgalpha": "25",				
                        "text": '.Json::encode($mrgtaskPIC).'
                    }
                ]
            },
			"tasks": {
				"task":'.Json::encode($task).'
			}
			
			
		}';
		
		return json::decode($rslt);
		
	}
	
	
	
	/**
	* Status : Dev test. ptr.nov
	*/
	public function actionChartGrantPilotproject(){	
		$dataParenCustomer= new ArrayDataProvider([
			'key' => 'CUST_KD',
			//'allModels'=>Yii::$app->db_esm->createCommand("CALL DASHBOARD_ESM_SALES_custromer_ktg('ParentChildCountCustomer')")->queryAll(),
			'allModels'=>Yii::$app->db_esm->cache(function ($db_esm) {
				return $db_esm->createCommand("
					SELECT x1.label,x1.value
					FROM
						(SELECT #x1.CUST_KD,x1.CUST_GRP,
								 x1.CUST_NM as label,
								(SELECT COUNT(x2.CUST_KD) FROM c0001 x2 WHERE x2.CUST_GRP=x1.CUST_KD LIMIT 1 ) as value
						FROM c0001 x1
						WHERE x1.CUST_KD=x1.CUST_GRP) x1 
					ORDER BY x1.value DESC;
				")->queryAll();
			}, 60),
			'pagination' => [
				'pageSize' => 200,
			]
		]);		
		//return  json_encode($dataParenCustomer->getModels());
		return $dataParenCustomer->getModels();
	}
	
	
	
	/**
	* Status : Dev test. ptr.nov
	*/
	public function actionChartTest1(){
		
	 $chartGrantData='{
		"chart": {
                "subcaption": "Pilot Project Planned vs Actual",                
                "dateformat": "dd/mm/yyyy",
                "outputdateformat": "ddds mns yy",
                "ganttwidthpercent": "70",
                "ganttPaneDuration": "50",
                "ganttPaneDurationUnit": "d",	
				"height":"500%",
				"fontsize": "14",				
                "plottooltext": "$processName{br} $label starting date $start{br}$label ending date $end",
                "theme": "fint"
            },
		"categories": [
			{
				"bgcolor": "#33bdda",
				"category": [
					{
						"start": "1/4/2014",
						"end": "30/6/2014",
						"label": "Months",
						"align": "middle",
						"fontcolor": "#ffffff",
						"fontsize": "14"
					}
				]
			},
			{
				"bgcolor": "#33bdda",
				"align": "middle",
				"fontcolor": "#ffffff",
				"fontsize": "12",
				"category": [
					{
						"start": "1/4/2014",
						"end": "30/4/2014",
						"label": "April"
					},
					{
						"start": "1/5/2014",
						"end": "31/5/2014",
						"label": "May"
					},
					{
						"start": "1/6/2014",
						"end": "30/6/2014",
						"label": "June"
					}
				]
			},
			{
				"bgcolor": "#ffffff",
				"fontcolor": "#1288dd",
				"fontsize": "10",
				"isbold": "1",
				"align": "center",
				"category": [
					{
						"start": "1/4/2014",
						"end": "5/4/2014",
						"label": "Week 1"
					},
					{
						"start": "6/4/2014",
						"end": "12/4/2014",
						"label": "Week 2"
					},
					{
						"start": "13/4/2014",
						"end": "19/4/2014",
						"label": "Week 3"
					},
					{
						"start": "20/4/2014",
						"end": "26/4/2014",
						"label": "Week 4"
					},
					{
						"start": "27/4/2014",
						"end": "3/5/2014",
						"label": "Week 5"
					},
					{
						"start": "4/5/2014",
						"end": "10/5/2014",
						"label": "Week 6"
					},
					{
						"start": "11/5/2014",
						"end": "17/5/2014",
						"label": "Week 7"
					},
					{
						"start": "18/5/2014",
						"end": "24/5/2014",
						"label": "Week 8"
					},
					{
						"start": "25/5/2014",
						"end": "31/5/2014",
						"label": "Week 9"
					},
					{
						"start": "1/6/2014",
						"end": "7/6/2014",
						"label": "Week 10"
					},
					{
						"start": "8/6/2014",
						"end": "14/6/2014",
						"label": "Week 11"
					},
					{
						"start": "15/6/2014",
						"end": "21/6/2014",
						"label": "Week 12"
					},
					{
						"start": "22/6/2014",
						"end": "28/6/2014",
						"label": "Week 13"
					}
				]
			}
		],
		"datatable": {
                "headervalign": "bottom",
                "datacolumn": [
                    {
                        "headertext": "PIC",
                        "fontcolor": "#000000",
						"fontsize": "10",
						"isanimated": "1",
						"bgcolor": "#6baa01",
						"headervalign": "middle",
						"headeralign": "center",
						"headerbgcolor": "#6baa01",
						"headerfontcolor": "#ffffff",
						"headerfontsize": "16",
						"width":"150",
						"align": "left",
						"isbold": "1",
						"bgalpha": "25",				
                        "text": [
                            {
                                "label": " "
                            },
                            {
                                "label": "John"
                            },
                            {
                                "label": "David"
                            },
                            {
                                "label": "Mary"
                            },
                            {
                                "label": "John"
                            },
                            {
                                "label": "Andrew & Harry"
                            },                            
                            {
                                "label": "John & Harry"
                            },
                            {
                                "label": " "
                            },
                            {
                                "label": "Neil & Harry"
                            },
                            {
                                "label": "Neil & Harry"
                            },
                            {
                                "label": "Chris"
                            },
                            {
                                "label": "John & Richard"
                            }
                        ]
                    }
                ]
            },
		"processes": {
			"headertext": "Pilot Task",
			"fontsize": "12",
			"fontcolor": "#000000",
			"fontsize": "10",
			"isanimated": "1",
			"bgcolor": "#6baa01",
			"headervalign": "middle",
			"headeralign": "center",
			"headerbgcolor": "#6baa01",
			"headerfontcolor": "#ffffff",
			"headerfontsize": "16",
			"width":"200",
			"align": "left",
			"isbold": "1",
			"bgalpha": "25",
			"process": [
				{
					"label": "Clear site",
					"id": "1"
				},
				{
					"label": "Excavate Foundation",
					"id": "2",
					"hoverbandcolor": "#e44a00",
					"hoverbandalpha": "40"
				},
				{
					"label": "Concrete Foundation",
					"id": "3",
					"hoverbandcolor": "#e44a00",
					"hoverbandalpha": "40"
				},
				{
					"label": "Footing to DPC",
					"id": "4",
					"hoverbandcolor": "#e44a00",
					"hoverbandalpha": "40"
				},
				{
					"label": "Drainage Services",
					"id": "5",
					"hoverbandcolor": "#e44a00",
					"hoverbandalpha": "40"
				},
				{
					"label": "Backfill",
					"id": "6",
					"hoverbandcolor": "#e44a00",
					"hoverbandalpha": "40"
				},
				{
					"label": "Ground Floor",
					"id": "7"
				},
				{
					"label": "Walls on First Floor",
					"id": "8"
				},
				{
					"label": "First Floor Carcass",
					"id": "9",
					"hoverbandcolor": "#e44a00",
					"hoverbandalpha": "40"
				},
				{
					"label": "First Floor Deck",
					"id": "10",
					"hoverbandcolor": "#e44a00",
					"hoverbandalpha": "40"
				},
				{
					"label": "Roof Structure",
					"id": "11"
				},
				{
					"label": "Roof Covering",
					"id": "12"
				},
				{
					"label": "Rainwater Gear",
					"id": "13"
				},
				{
					"label": "Windows",
					"id": "14"
				},
				{
					"label": "External Doors",
					"id": "15"
				},
				{
					"label": "Connect Electricity",
					"id": "16"
				},
				{
					"label": "Connect Water Supply",
					"id": "17",
					"hoverbandcolor": "#e44a00",
					"hoverbandalpha": "40"
				},
				{
					"label": "Install Air Conditioning",
					"id": "18",
					"hoverbandcolor": "#e44a00",
					"hoverbandalpha": "40"
				},
				{
					"label": "Interior Decoration",
					"id": "19",
					"hoverbandcolor": "#e44a00",
					"hoverbandalpha": "40"
				},
				{
					"label": "Fencing And signs",
					"id": "20"
				},
				{
					"label": "Exterior Decoration",
					"id": "21",
					"hoverbandcolor": "#e44a00",
					"hoverbandalpha": "40"
				},
				{
					"label": "Setup racks",
					"id": "22"
				}
			]
		},		
		"tasks": {
			"task": [
				{
					"label": "Planned",
					"processid": "1",
					"start": "9/4/2014",
					"end": "12/4/2014",
					"id": "1-1",
					"color": "#008ee4",
					"height": "32%",
					"toppadding": "12%"
				},
				{
					"label": "Actual",
					"processid": "1",
					"start": "9/4/2014",
					"end": "12/4/2014",
					"id": "1",
					"color": "#6baa01",
					"toppadding": "56%",
					"height": "32%"
				},
				{
					"label": "Planned",
					"processid": "2",
					"start": "13/4/2014",
					"end": "23/4/2014",
					"id": "2-1",
					"color": "#008ee4",
					"height": "32%",
					"toppadding": "12%"
				},
				{
					"label": "Actual",
					"processid": "2",
					"start": "13/4/2014",
					"end": "25/4/2014",
					"id": "2",
					"color": "#6baa01",
					"toppadding": "56%",
					"height": "32%"
				},
				{
					"label": "Delay",
					"processid": "2",
					"start": "23/4/2014",
					"end": "25/4/2014",
					"id": "2-2",
					"color": "#e44a00",
					"toppadding": "56%",
					"height": "32%",
					"tooltext": "Delayed by 2 days."
				},
				{
					"label": "Planned",
					"processid": "3",
					"start": "23/4/2014",
					"end": "30/4/2014",
					"id": "3-1",
					"color": "#008ee4",
					"height": "32%",
					"toppadding": "12%"
				},
				{
					"label": "Actual",
					"processid": "3",
					"start": "26/4/2014",
					"end": "4/5/2014",
					"id": "3",
					"color": "#6baa01",
					"toppadding": "56%",
					"height": "32%"
				},
				{
					"label": "Delay",
					"processid": "3",
					"start": "3/5/2014",
					"end": "4/5/2014",
					"id": "3-2",
					"color": "#e44a00",
					"toppadding": "56%",
					"height": "32%",
					"tooltext": "Delayed by 1 days."
				},
				{
					"label": "Planned",
					"processid": "4",
					"start": "3/5/2014",
					"end": "10/5/2014",
					"id": "4-1",
					"color": "#008ee4",
					"height": "32%",
					"toppadding": "12%"
				},
				{
					"label": "Actual",
					"processid": "4",
					"start": "4/5/2014",
					"end": "10/5/2014",
					"id": "4",
					"color": "#6baa01",
					"toppadding": "56%",
					"height": "32%"
				},
				{
					"label": "Planned",
					"processid": "5",
					"start": "6/5/2014",
					"end": "11/5/2014",
					"id": "5-1",
					"color": "#008ee4",
					"height": "32%",
					"toppadding": "12%"
				},
				{
					"label": "Actual",
					"processid": "5",
					"start": "6/5/2014",
					"end": "10/5/2014",
					"id": "5",
					"color": "#6baa01",
					"toppadding": "56%",
					"height": "32%"
				},
				{
					"label": "Planned",
					"processid": "6",
					"start": "4/5/2014",
					"end": "7/5/2014",
					"id": "6-1",
					"color": "#008ee4",
					"height": "32%",
					"toppadding": "12%"
				},
				{
					"label": "Actual",
					"processid": "6",
					"start": "5/5/2014",
					"end": "11/5/2014",
					"id": "6",
					"color": "#6baa01",
					"toppadding": "56%",
					"height": "32%"
				},
				{
					"label": "Delay",
					"processid": "6",
					"start": "7/5/2014",
					"end": "11/5/2014",
					"id": "6-2",
					"color": "#e44a00",
					"toppadding": "56%",
					"height": "32%",
					"tooltext": "Delayed by 4 days."
				},
				{
					"label": "Planned",
					"processid": "7",
					"start": "11/5/2014",
					"end": "14/5/2014",
					"id": "7-1",
					"color": "#008ee4",
					"height": "32%",
					"toppadding": "12%"
				},
				{
					"label": "Actual",
					"processid": "7",
					"start": "11/5/2014",
					"end": "14/5/2014",
					"id": "7",
					"color": "#6baa01",
					"toppadding": "56%",
					"height": "32%"
				},
				{
					"label": "Planned",
					"processid": "8",
					"start": "16/5/2014",
					"end": "19/5/2014",
					"id": "8-1",
					"color": "#008ee4",
					"height": "32%",
					"toppadding": "12%"
				},
				{
					"label": "Actual",
					"processid": "8",
					"start": "16/5/2014",
					"end": "19/5/2014",
					"id": "8",
					"color": "#6baa01",
					"toppadding": "56%",
					"height": "32%"
				},
				{
					"label": "Planned",
					"processid": "9",
					"start": "16/5/2014",
					"end": "18/5/2014",
					"id": "9-1",
					"color": "#008ee4",
					"height": "32%",
					"toppadding": "12%"
				},
				{
					"label": "Actual",
					"processid": "9",
					"start": "16/5/2014",
					"end": "21/5/2014",
					"id": "9",
					"color": "#6baa01",
					"toppadding": "56%",
					"height": "32%"
				},
				{
					"label": "Delay",
					"processid": "9",
					"start": "18/5/2014",
					"end": "21/5/2014",
					"id": "9-2",
					"color": "#e44a00",
					"toppadding": "56%",
					"height": "32%",
					"tooltext": "Delayed by 3 days."
				},
				{
					"label": "Planned",
					"processid": "10",
					"start": "20/5/2014",
					"end": "23/5/2014",
					"id": "10-1",
					"color": "#008ee4",
					"height": "32%",
					"toppadding": "12%"
				},
				{
					"label": "Actual",
					"processid": "10",
					"start": "21/5/2014",
					"end": "24/5/2014",
					"id": "10",
					"color": "#6baa01",
					"toppadding": "56%",
					"height": "32%"
				},
				{
					"label": "Delay",
					"processid": "10",
					"start": "23/5/2014",
					"end": "24/5/2014",
					"id": "10-2",
					"color": "#e44a00",
					"toppadding": "56%",
					"height": "32%",
					"tooltext": "Delayed by 1 days."
				},
				{
					"label": "Planned",
					"processid": "11",
					"start": "25/5/2014",
					"end": "27/5/2014",
					"id": "11-1",
					"color": "#008ee4",
					"height": "32%",
					"toppadding": "12%"
				},
				{
					"label": "Actual",
					"processid": "11",
					"start": "25/5/2014",
					"end": "27/5/2014",
					"id": "11",
					"color": "#6baa01",
					"toppadding": "56%",
					"height": "32%"
				},
				{
					"label": "Planned",
					"processid": "12",
					"start": "28/5/2014",
					"end": "1/6/2014",
					"id": "12-1",
					"color": "#008ee4",
					"height": "32%",
					"toppadding": "12%"
				},
				{
					"label": "Actual",
					"processid": "12",
					"start": "28/5/2014",
					"end": "1/6/2014",
					"id": "12",
					"color": "#6baa01",
					"toppadding": "56%",
					"height": "32%"
				},
				{
					"label": "Planned",
					"processid": "13",
					"start": "4/6/2014",
					"end": "6/6/2014",
					"id": "13-1",
					"color": "#008ee4",
					"height": "32%",
					"toppadding": "12%"
				},
				{
					"label": "Actual",
					"processid": "13",
					"start": "4/6/2014",
					"end": "6/6/2014",
					"id": "13",
					"color": "#6baa01",
					"toppadding": "56%",
					"height": "32%"
				},
				{
					"label": "Planned",
					"processid": "14",
					"start": "4/6/2014",
					"end": "4/6/2014",
					"id": "14-1",
					"color": "#008ee4",
					"height": "32%",
					"toppadding": "12%"
				},
				{
					"label": "Actual",
					"processid": "14",
					"start": "4/6/2014",
					"end": "4/6/2014",
					"id": "14",
					"color": "#6baa01",
					"toppadding": "56%",
					"height": "32%"
				},
				{
					"label": "Planned",
					"processid": "15",
					"start": "4/6/2014",
					"end": "4/6/2014",
					"id": "15-1",
					"color": "#008ee4",
					"height": "32%",
					"toppadding": "12%"
				},
				{
					"label": "Actual",
					"processid": "15",
					"start": "4/6/2014",
					"end": "4/6/2014",
					"id": "15",
					"color": "#6baa01",
					"toppadding": "56%",
					"height": "32%"
				},
				{
					"label": "Planned",
					"processid": "16",
					"start": "2/6/2014",
					"end": "7/6/2014",
					"id": "16-1",
					"color": "#008ee4",
					"height": "32%",
					"toppadding": "12%"
				},
				{
					"label": "Actual",
					"processid": "16",
					"start": "2/6/2014",
					"end": "7/6/2014",
					"id": "16",
					"color": "#6baa01",
					"toppadding": "56%",
					"height": "32%"
				},
				{
					"label": "Planned",
					"processid": "17",
					"start": "5/6/2014",
					"end": "10/6/2014",
					"id": "17-1",
					"color": "#008ee4",
					"height": "32%",
					"toppadding": "12%"
				},
				{
					"label": "Actual",
					"processid": "17",
					"start": "5/6/2014",
					"end": "17/6/2014",
					"id": "17",
					"color": "#6baa01",
					"toppadding": "56%",
					"height": "32%"
				},
				{
					"label": "Delay",
					"processid": "17",
					"start": "10/6/2014",
					"end": "17/6/2014",
					"id": "17-2",
					"color": "#e44a00",
					"toppadding": "56%",
					"height": "32%",
					"tooltext": "Delayed by 7 days."
				},
				{
					"label": "Planned",
					"processid": "18",
					"start": "10/6/2014",
					"end": "12/6/2014",
					"id": "18-1",
					"color": "#008ee4",
					"height": "32%",
					"toppadding": "12%"
				},
				{
					"label": "Delay",
					"processid": "18",
					"start": "18/6/2014",
					"end": "20/6/2014",
					"id": "18",
					"color": "#e44a00",
					"toppadding": "56%",
					"height": "32%",
					"tooltext": "Delayed by 8 days."
				},
				{
					"label": "Planned",
					"processid": "19",
					"start": "15/6/2014",
					"end": "23/6/2014",
					"id": "19-1",
					"color": "#008ee4",
					"height": "32%",
					"toppadding": "12%"
				},
				{
					"label": "Actual",
					"processid": "19",
					"start": "16/6/2014",
					"end": "23/6/2014",
					"id": "19",
					"color": "#6baa01",
					"toppadding": "56%",
					"height": "32%"
				},
				{
					"label": "Planned",
					"processid": "20",
					"start": "23/6/2014",
					"end": "23/6/2014",
					"id": "20-1",
					"color": "#008ee4",
					"height": "32%",
					"toppadding": "12%"
				},
				{
					"label": "Actual",
					"processid": "20",
					"start": "23/6/2014",
					"end": "23/6/2014",
					"id": "20",
					"color": "#6baa01",
					"toppadding": "56%",
					"height": "32%"
				},
				{
					"label": "Planned",
					"processid": "21",
					"start": "18/6/2014",
					"end": "21/6/2014",
					"id": "21-1",
					"color": "#008ee4",
					"height": "32%",
					"toppadding": "12%"
				},
				{
					"label": "Actual",
					"processid": "21",
					"start": "18/6/2014",
					"end": "23/6/2014",
					"id": "21",
					"color": "#6baa01",
					"toppadding": "56%",
					"height": "32%"
				},
				{
					"label": "Delay",
					"processid": "21",
					"start": "21/6/2014",
					"end": "23/6/2014",
					"id": "21-2",
					"color": "#e44a00",
					"toppadding": "56%",
					"height": "32%",
					"tooltext": "Delayed by 2 days."
				},
				{
					"label": "Planned",
					"processid": "22",
					"start": "24/6/2014",
					"end": "28/6/2014",
					"id": "22-1",
					"color": "#008ee4",
					"height": "32%",
					"toppadding": "12%"
				},
				{
					"label": "Actual",
					"processid": "22",
					"start": "25/6/2014",
					"end": "28/6/2014",
					"id": "22",
					"color": "#6baa01",
					"toppadding": "56%",
					"height": "32%"
				}
			]
		},
		"connectors": [
			{
				"connector": [
					{
						"fromtaskid": "1",
						"totaskid": "2",
						"color": "#008ee4",
						"thickness": "2",
						"fromtaskconnectstart_": "1"
					},
					{
						"fromtaskid": "2-2",
						"totaskid": "3",
						"color": "#008ee4",
						"thickness": "2"
					},
					{
						"fromtaskid": "3-2",
						"totaskid": "4",
						"color": "#008ee4",
						"thickness": "2"
					},
					{
						"fromtaskid": "3-2",
						"totaskid": "6",
						"color": "#008ee4",
						"thickness": "2"
					},
					{
						"fromtaskid": "7",
						"totaskid": "8",
						"color": "#008ee4",
						"thickness": "2"
					},
					{
						"fromtaskid": "7",
						"totaskid": "9",
						"color": "#008ee4",
						"thickness": "2"
					},
					{
						"fromtaskid": "12",
						"totaskid": "16",
						"color": "#008ee4",
						"thickness": "2"
					},
					{
						"fromtaskid": "12",
						"totaskid": "17",
						"color": "#008ee4",
						"thickness": "2"
					},
					{
						"fromtaskid": "17-2",
						"totaskid": "18",
						"color": "#008ee4",
						"thickness": "2"
					},
					{
						"fromtaskid": "19",
						"totaskid": "22",
						"color": "#008ee4",
						"thickness": "2"
					}
				]
			}
		],
		"milestones": {
			"milestone": [
				{
					"date": "2/6/2014",
					"taskid": "12",
					"color": "#f8bd19",
					"shape": "star",
					"tooltext": "Completion of Phase 1"
				}
			]
		},
		"legend": {
			"item": [
				{
					"label": "Planned",
					"color": "#008ee4"
				},
				{
					"label": "Actual",
					"color": "#6baa01"
				},
				{
					"label": "Slack (Delay)",
					"color": "#e44a00"
				}
			]
		}
	 }';
		return $chartGrantData;
		
	}

	/**
	* Status : Dev test.  ptr.nov
	*/
	public function actionChartTest(){	
		$dataParenCustomer1= new ArrayDataProvider([
			'key' => 'CUST_KD',
			//'allModels'=>Yii::$app->db_esm->createCommand("CALL DASHBOARD_ESM_SALES_custromer_ktg('ParentChildCountCustomer')")->queryAll(),
			'allModels'=>Yii::$app->db_esm->cache(function ($db_esm) {
				return $db_esm->createCommand("
					SELECT x1.label,x1.value
					FROM
						(SELECT #x1.CUST_KD,x1.CUST_GRP,
								 x1.CUST_NM as label,
								(SELECT COUNT(x2.CUST_KD) FROM c0001 x2 WHERE x2.CUST_GRP=x1.CUST_KD LIMIT 1 ) as value
						FROM c0001 x1
						WHERE x1.CUST_KD=x1.CUST_GRP) x1 
					ORDER BY x1.value DESC;
				")->queryAll();
			}, 60),
			'pagination' => [
				'pageSize' => 200,
			]
		]);		
			$chartdata='{
				"chart": {
				 "caption":"Summary Customers Category Detail",
				 "xAxisName":"Category Name",
				 "yAxisName":"Count ",
				 "theme":"fint",
				 "is2D":"0",
				 "showValues":"1",
				 "palettecolors":"#583e78,#008ee4,#f8bd19,#e44a00,#6baa01,#ff2e2e",
				 "bgColor":"#ffffff",
				 "showBorder":"0",
				 "showCanvasBorder":"0"
				} , 
				"data": '.json_encode($dataParenCustomer1->getModels()).'	
			}';
		
		
		//return  json_encode($dataParenCustomer1->getModels());
		return $chartdata;
	}
}
