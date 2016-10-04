<?php

namespace crm\export\controllers;

use Yii;

/*extensions*/
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use scotthuangzl\export2excel\Export2ExcelBehavior;
use yii\data\ArrayDataProvider;
use yii\web\Response;
use ptrnov\postman4excel\Postman4ExcelBehavior;

use crm\mastercrm\models\Customers;


 /**
     * Lists all Export.
     *@author wawan
     * @return mixed
   */

class ExportController extends Controller
{
     public function behaviors()
    {
        return [
            'export2excel' => [
                'class' => Export2ExcelBehavior::className(),
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ]
        ];
    }

    public function actions()
    {
        return [
            'download' => [
                'class' => 'scotthuangzl\export2excel\DownloadAction',
            ],
        ];
    }


   
	 
	 public function beforeAction($action){
			if (Yii::$app->user->isGuest)  {
				 Yii::$app->user->logout();
                   $this->redirect(array('/site/login'));  //
			}
            // Check only when the user is logged in
            if (!Yii::$app->user->isGuest)  {
               if (Yii::$app->session['userSessionTimeout']< time() ) {
                   // timeout
                   Yii::$app->user->logout();
                   $this->redirect(array('/site/login'));  //
               } else {
                   //Yii::$app->user->setState('userSessionTimeout', time() + Yii::app()->params['sessionTimeoutSeconds']) ;
				   Yii::$app->session->set('userSessionTimeout', time() + Yii::$app->params['sessionTimeoutSeconds']);
                   return true; 
               }
            } else {
                return true;
            }
    }

     public function actionIndex()
    {
        return $this->render('index');
    }

    /*
     * EXPORT SCHEDULE PLAN TO EXCEL
     * export_data
    */
    public function actionSchedulePlan(){
        // $tglIn='2016-08-01';
        $request = Yii::$app->request->post();

        $tgl_post = $request['DraftPlanDetail']['TGL'];

        $tglIn = $tgl_post != ''? $tgl_post: date('Y-m-d');

       
        /* HEADER/FIELD MONTHLY SCHADULE*/
        $tanggalOfMonth= new ArrayDataProvider([
            'allModels'=>Yii::$app->db_esm->createCommand("Call ERP_CUSTOMER_VISIT_PLAN_SchaduleReportHeader('".$tglIn."')")->queryAll(),
        ]);         
        //FIELD TGL & PEKAN
        $attributeHeader=$tanggalOfMonth->allModels; 
        
        
        foreach($attributeHeader as $key=>$value){
            $cntArray[]=$value['Pekan'];
        }       
        $counts = array_count_values($cntArray); //get count of value array
            
        
        //headeStyle1   
        $attHeaderName=['Sales','Bulan'];
        $headerStyleDinamik1a[] =[  
                        'Sales'=>[
                            'align'=>'center','color-font'=>'FFFFFF','color-background'=>'519CC6','merge'=>'0,2','width'=>'20'
                        ],
                        'Bulan'=>[
                            'align'=>'center','color-font'=>'FFFFFF','color-background'=>'519CC6','merge'=>'0,2','width'=>'20'
                        ]]; 
        
        //SPLIT TGL BY PRKAN
        $checkPekan='';                 
        foreach($attributeHeader as $key=>$value){          
            if ($checkPekan!=$value['Pekan']){
                $mergeVal=($counts[$value['Pekan']]-1).',1';
                $attHeader1Dinamik[]= 'Pekan-'.$value['Pekan']; 
                //Color Backgroud - week genap/ganjil
                if($value['Pekan'] % 2==0){
                    $warnaBelakang='FFFF99';
                }elseif($value['Pekan'] % 2!=0){
                    $warnaBelakang='CCFF99';
                }
                //headeStyle1 Row1              
                $headerStyleDinamik1b[] =[
                    'Pekan-'.$value['Pekan']=>[
                        'align'=>'center','color-font'=>'000000','color-background'=>$warnaBelakang,'merge'=>$mergeVal,'width'=>'20'
                        //'align'=>'center','color-font'=>'FFFFFF','color-background'=>'519CC6','merge'=>$mergeVal,'width'=>'20'
                    ]
                ];
                $checkPekan=$value['Pekan'];
            }else{
                $attHeader1Dinamik[]= $value['Pekan'].'-'.$key;
            }
            $val=explode(".",$value['TGL']);
            $attHeader2[]= $val[1]." ".$val[0]."";
            //headeStyle2 Row2
            $headerStyleDinamik2[] =[
                $val[1]." ".$val[0]=>[
                    'align'=>'center','color-font'=>'FFFFFF','color-background'=>'519CC6','width'=>'20'
                ]
            ];
            //Content Style - Array
            $contentStyleDinamik[]=[
                $val[1]." ".$val[0]=>[
                    'align'=>'center','color-font'=>'0000FF'
                ]
            ];
        };
        //PUT HRADAER ROW1 & ROW2
        $titleHeader1=array_merge($attHeaderName,$attHeader1Dinamik);
        $titleHeader2=array_merge($attHeaderName,$attHeader2);
        
        //headeStyle1-  Array Position parent from chaild array
        foreach($headerStyleDinamik1b as $key=>$val){
            $headerStyleDinamik1a[0]=array_merge($headerStyleDinamik1a[0],$headerStyleDinamik1b[$key]);         
        }
                
        //headeStyle2   
        $headerStyleDinamik2a[]=[];
        foreach($headerStyleDinamik2 as $key=>$val){
            $headerStyleDinamik2a=array_merge($headerStyleDinamik2a,$headerStyleDinamik2[$key]);            
        }       
        //HeadeStyle - Marge Array
        $headerStyleMarge=array_merge($headerStyleDinamik1a,[$headerStyleDinamik2a]);
        
        //Content Style Array Postition
        $contentStyleDinamikA[]=[];
        foreach($contentStyleDinamik as $key=>$val){
            $contentStyleDinamikA=array_merge($contentStyleDinamikA,$contentStyleDinamik[$key]);            
        }   
        
        // print_r($contentStyleDinamikA);
        // die();
        
        //row Data
        $dataScdlOfMonth= new ArrayDataProvider([
            'allModels'=>Yii::$app->db_esm->createCommand("Call ERP_CUSTOMER_VISIT_PLAN_SchaduleReport('".$tglIn."')")->queryAll()
        ]);
        $schaduleProvider=$dataScdlOfMonth->allModels;
        $excelScdlData = Postman4ExcelBehavior::excelDataFormat($schaduleProvider);
        $excel_ceilsScdl = $excelScdlData['excel_ceils'];
            
        /* GROUP SCHADULE*/
        $schaduleGrpData= new ArrayDataProvider([
            //'key' => 'ID',
            //SELECT a.USER_ID,a.SCDL_GROUP AS GRP_ID, b.SCDL_GROUP_NM as GRP_NM,a.CUST_ID,c.CUST_NM,a.LAT,a.LAG 
            'allModels'=>Yii::$app->db_esm->createCommand("call ERP_CUSTOMER_VISIT_PLAN_SchaduleReportList('')")->queryAll(),
        ]); 
        $schaduleGrpProvider=$schaduleGrpData->allModels;
        $excelScdlGrpData = Postman4ExcelBehavior::excelDataFormat($schaduleGrpProvider);
        $excel_ceilsScdlGrp = $excelScdlGrpData['excel_ceils'];
                
        
        /* USER SALESMAN */
        $userData= new ArrayDataProvider([
            //'key' => 'ID',    
            //SELECT b.ID,a.username,b.NM_FIRST, b.NM_MIDDLE, b.KTP,ALAMAT, b.GENDER, b.EMAIL, b.HP, b.TLP_HOME 
                
            'allModels'=>Yii::$app->db_esm->createCommand("             
                SELECT b.ID_USER,a.username,b.NM_FIRST, b.NM_MIDDLE, b.KTP,ALAMAT, b.GENDER, b.EMAIL, b.HP, b.TLP_HOME 
                FROM dbm001.user a LEFT JOIN dbm_086.user_profile b on b.ID_USER=a.id
                WHERE a.POSITION_SITE='CRM' AND a.POSITION_LOGIN=1 AND a.POSITION_ACCESS=2 AND a.status=10
            ")->queryAll(),
        ]); 
        $usrProvider=$userData->allModels;
        $excelUserData = Postman4ExcelBehavior::excelDataFormat($usrProvider);
        $excel_ceilsUser = $excelUserData['excel_ceils'];       
        
        $excel_content = [          
            /* USER */
            [
                'sheet_name' => 'SALES MD',
                'sheet_title' => ['ID','USERNAME','NAMA DEPAN','NAMA BELAKANG','KTP','ALAMAT','GENDER','EMAIL','HP','TLP_HOME'], 
                'ceils' => $excel_ceilsUser,
                //'freezePane' => 'E2',
                'headerColor' => Postman4ExcelBehavior::getCssClass("header"),
                'headerColumnCssClass' => [
                    'ID' => Postman4ExcelBehavior::getCssClass('header'),
                    'username' => Postman4ExcelBehavior::getCssClass('header'),
                    'NM_FIRST' => Postman4ExcelBehavior::getCssClass('header'),
                    'NM_MIDDLE' => Postman4ExcelBehavior::getCssClass('header'),
                    'KTP' => Postman4ExcelBehavior::getCssClass('header'),
                    'ALAMAT' => Postman4ExcelBehavior::getCssClass('header'),              
                    'GENDER' => Postman4ExcelBehavior::getCssClass('header'),              
                    'EMAIL' => Postman4ExcelBehavior::getCssClass('header'),              
                    'HP' => Postman4ExcelBehavior::getCssClass('header'),              
                    'TLP_HOME' => Postman4ExcelBehavior::getCssClass('header')              
                ], //define each column's cssClass for header line only.  You can set as blank.
               'oddCssClass' => Postman4ExcelBehavior::getCssClass("odd"),
               'evenCssClass' => Postman4ExcelBehavior::getCssClass("even"),
            ],
            /* LIST SCHADULE GROUP*/
            [
                'sheet_name' => 'LIST SCHADULE GROUP', 
                'sheet_title' => [
                    ['USER_NM','TGL','HARI','LAYER','PEKAN','GRP_NM ','GRP_DCRP','CUST_ID','CUST_NM','PROVINSI','KOTA','KODE POS','LAT','LAG'],
                ], 
                'ceils' => $excel_ceilsScdlGrp,
                'freezePane' => 'B2',
                'headerColor' => Postman4ExcelBehavior::getCssClass("header"),
                'headerStyle'=>[                    
                    [
                        'USER_NM' =>['align'=>'center'],
                        'TGL' =>['align'=>'center'],
                        'LAYER' =>['align'=>'center'],
                    ]
                    
                ],
                'contentStyle'=>[
                    [                       
                        'TGL' =>['align'=>'center'],
                        'LAYER' =>['align'=>'center'],
                        'GRP_DCRP' =>['align'=>'center'],
                        'CUST_ID' =>['align'=>'center'],
                        'KODE POS' =>['align'=>'center'],                       
                    ]
                ], 
               'oddCssClass' => Postman4ExcelBehavior::getCssClass("odd"),
               'evenCssClass' => Postman4ExcelBehavior::getCssClass("even"),
            ],
            /* MONTHLY SCHADULE*/           
            [ 
                'sheet_name' => 'WEEKLY SCHEDULE OF THE MONTH',
                'sheet_title' => [
                            $titleHeader1,
                            $titleHeader2,      
                ],
                'ceils' => $excel_ceilsScdl,
                'freezePane' => 'C3',
                'headerStyle'=>$headerStyleMarge,
                'contentStyle'=>[$contentStyleDinamikA],
                'oddCssClass' => Postman4ExcelBehavior::getCssClass("odd"),
                'evenCssClass' => Postman4ExcelBehavior::getCssClass("even"),
            ],
            
        ];      
        $excel_file = "PostmanSalesSchedulePlan";
        $this->export4excel($excel_content, $excel_file,0);
    }
    
    /*
     * EXPORT SCHEDULE ACTUAL TO EXCEL
     * export_data
    */
    public function actionScheduleActual(){
        // $tglIn='2016-08-01';

        $request = Yii::$app->request->post();

        $tgl_post = $request['DraftPlanDetail']['tglactual'];

        $tglIn = $tgl_post != ''? $tgl_post: date('Y-m-d');
       
        /* HEADER/FIELD MONTHLY SCHADULE*/
        $tanggalOfMonth= new ArrayDataProvider([
            'allModels'=>Yii::$app->db_esm->createCommand("Call ERP_CUSTOMER_VISIT_ACTUAL_SchaduleReportHeader('".$tglIn."')")->queryAll(),
        ]);         
        //FIELD TGL & PEKAN
        $attributeHeader=$tanggalOfMonth->allModels; 
        
        
        foreach($attributeHeader as $key=>$value){
            $cntArray[]=$value['Pekan'];
        }       
        $counts = array_count_values($cntArray); //get count of value array
            
        
        //headeStyle1   
        $attHeaderName=['Sales','Bulan'];
        $headerStyleDinamik1a[] =[  
                        'Sales'=>[
                            'align'=>'center','color-font'=>'FFFFFF','color-background'=>'519CC6','merge'=>'0,2','width'=>'20'
                        ],
                        'Bulan'=>[
                            'align'=>'center','color-font'=>'FFFFFF','color-background'=>'519CC6','merge'=>'0,2','width'=>'20'
                        ]]; 
        
        //SPLIT TGL BY PRKAN
        $checkPekan='';                 
        foreach($attributeHeader as $key=>$value){          
            if ($checkPekan!=$value['Pekan']){
                $mergeVal=($counts[$value['Pekan']]-1).',1';
                $attHeader1Dinamik[]= 'Pekan-'.$value['Pekan']; 
                //Color Backgroud - week genap/ganjil
                if($value['Pekan'] % 2==0){
                    $warnaBelakang='FFFF99';
                }elseif($value['Pekan'] % 2!=0){
                    $warnaBelakang='CCFF99';
                }
                //headeStyle1 Row1              
                $headerStyleDinamik1b[] =[
                    'Pekan-'.$value['Pekan']=>[
                        'align'=>'center','color-font'=>'000000','color-background'=>$warnaBelakang,'merge'=>$mergeVal,'width'=>'20'
                        //'align'=>'center','color-font'=>'FFFFFF','color-background'=>'519CC6','merge'=>$mergeVal,'width'=>'20'
                    ]
                ];
                $checkPekan=$value['Pekan'];
            }else{
                $attHeader1Dinamik[]= $value['Pekan'].'-'.$key;
            }
            $val=explode(".",$value['TGL']);
            $attHeader2[]= $val[1]." ".$val[0]."";
            //headeStyle2 Row2
            $headerStyleDinamik2[] =[
                $val[1]." ".$val[0]=>[
                    'align'=>'center','color-font'=>'FFFFFF','color-background'=>'519CC6','width'=>'20'
                ]
            ];
            //Content Style - Array
            $contentStyleDinamik[]=[
                $val[1]." ".$val[0]=>[
                    'align'=>'center','color-font'=>'0000FF'
                ]
            ];
        };
        //PUT HRADAER ROW1 & ROW2
        $titleHeader1=array_merge($attHeaderName,$attHeader1Dinamik);
        $titleHeader2=array_merge($attHeaderName,$attHeader2);
        
        //headeStyle1-  Array Position parent from chaild array
        foreach($headerStyleDinamik1b as $key=>$val){
            $headerStyleDinamik1a[0]=array_merge($headerStyleDinamik1a[0],$headerStyleDinamik1b[$key]);         
        }
                
        //headeStyle2   
        $headerStyleDinamik2a[]=[];
        foreach($headerStyleDinamik2 as $key=>$val){
            $headerStyleDinamik2a=array_merge($headerStyleDinamik2a,$headerStyleDinamik2[$key]);            
        }       
        //HeadeStyle - Marge Array
        $headerStyleMarge=array_merge($headerStyleDinamik1a,[$headerStyleDinamik2a]);
        
        //Content Style Array Postition
        $contentStyleDinamikA[]=[];
        foreach($contentStyleDinamik as $key=>$val){
            $contentStyleDinamikA=array_merge($contentStyleDinamikA,$contentStyleDinamik[$key]);            
        }   
        
        // print_r($contentStyleDinamikA);
        // die();
        
        //row Data
        $dataScdlOfMonth= new ArrayDataProvider([
            'allModels'=>Yii::$app->db_esm->createCommand("Call ERP_CUSTOMER_VISIT_ACTUAL_SchaduleReport('".$tglIn."')")->queryAll()
        ]);
        $schaduleProvider=$dataScdlOfMonth->allModels;
        $excelScdlData = Postman4ExcelBehavior::excelDataFormat($schaduleProvider);
        $excel_ceilsScdl = $excelScdlData['excel_ceils'];
            
        /* GROUP SCHADULE*/
        $schaduleGrpData= new ArrayDataProvider([
            //'key' => 'ID',
            //SELECT a.USER_ID,a.SCDL_GROUP AS GRP_ID, b.SCDL_GROUP_NM as GRP_NM,a.CUST_ID,c.CUST_NM,a.LAT,a.LAG 
            'allModels'=>Yii::$app->db_esm->createCommand("call ERP_CUSTOMER_VISIT_ACTUAL_SchaduleReportList('')")->queryAll(),
        ]); 
        $schaduleGrpProvider=$schaduleGrpData->allModels;
        $excelScdlGrpData = Postman4ExcelBehavior::excelDataFormat($schaduleGrpProvider);
        $excel_ceilsScdlGrp = $excelScdlGrpData['excel_ceils'];
                
        
        /* USER SALESMAN */
        $userData= new ArrayDataProvider([
            //'key' => 'ID',    
            //SELECT b.ID,a.username,b.NM_FIRST, b.NM_MIDDLE, b.KTP,ALAMAT, b.GENDER, b.EMAIL, b.HP, b.TLP_HOME 
                
            'allModels'=>Yii::$app->db_esm->createCommand("             
                SELECT b.ID_USER,a.username,b.NM_FIRST, b.NM_MIDDLE, b.KTP,ALAMAT, b.GENDER, b.EMAIL, b.HP, b.TLP_HOME 
                FROM dbm001.user a LEFT JOIN dbm_086.user_profile b on b.ID_USER=a.id
                WHERE a.POSITION_SITE='CRM' AND a.POSITION_LOGIN=1 AND a.POSITION_ACCESS=2 AND a.status=10
            ")->queryAll(),
        ]); 
        $usrProvider=$userData->allModels;
        $excelUserData = Postman4ExcelBehavior::excelDataFormat($usrProvider);
        $excel_ceilsUser = $excelUserData['excel_ceils'];       
        
        $excel_content = [          
            /* USER */
            [
                'sheet_name' => 'SALES MD',
                'sheet_title' => ['ID','USERNAME','NAMA DEPAN','NAMA BELAKANG','KTP','ALAMAT','GENDER','EMAIL','HP','TLP_HOME'], 
                'ceils' => $excel_ceilsUser,
                //'freezePane' => 'E2',
                'headerColor' => Postman4ExcelBehavior::getCssClass("header"),
                'headerColumnCssClass' => [
                    'ID' => Postman4ExcelBehavior::getCssClass('header'),
                    'username' => Postman4ExcelBehavior::getCssClass('header'),
                    'NM_FIRST' => Postman4ExcelBehavior::getCssClass('header'),
                    'NM_MIDDLE' => Postman4ExcelBehavior::getCssClass('header'),
                    'KTP' => Postman4ExcelBehavior::getCssClass('header'),
                    'ALAMAT' => Postman4ExcelBehavior::getCssClass('header'),              
                    'GENDER' => Postman4ExcelBehavior::getCssClass('header'),              
                    'EMAIL' => Postman4ExcelBehavior::getCssClass('header'),              
                    'HP' => Postman4ExcelBehavior::getCssClass('header'),              
                    'TLP_HOME' => Postman4ExcelBehavior::getCssClass('header')              
                ], //define each column's cssClass for header line only.  You can set as blank.
               'oddCssClass' => Postman4ExcelBehavior::getCssClass("odd"),
               'evenCssClass' => Postman4ExcelBehavior::getCssClass("even"),
            ],
            /* LIST SCHADULE GROUP*/
            [
                'sheet_name' => 'LIST SCHADULE GROUP', 
                'sheet_title' => [
                    ['USER_NM','TGL','HARI','LAYER','PEKAN','GRP_NM ','GRP_DCRP','CUST_ID','CUST_NM','PROVINSI','KOTA','KODE POS','LAT','LAG'],
                ], 
                'ceils' => $excel_ceilsScdlGrp,
                'freezePane' => 'B2',
                'headerColor' => Postman4ExcelBehavior::getCssClass("header"),
                'headerStyle'=>[                    
                    [
                        'USER_NM' =>['align'=>'center'],
                        'TGL' =>['align'=>'center'],
                        'LAYER' =>['align'=>'center'],
                    ]
                    
                ],
                'contentStyle'=>[
                    [                       
                        'TGL' =>['align'=>'center'],
                        'LAYER' =>['align'=>'center'],
                        'PEKAN' =>['align'=>'center'],
                        'GRP_DCRP' =>['align'=>'center'],
                        'CUST_ID' =>['align'=>'center'],
                        'KODE POS' =>['align'=>'center'],                       
                    ]
                ], 
               'oddCssClass' => Postman4ExcelBehavior::getCssClass("odd"),
               'evenCssClass' => Postman4ExcelBehavior::getCssClass("even"),
            ],
            /* MONTHLY SCHADULE*/           
            [ 
                'sheet_name' => 'WEEKLY SCHEDULE OF THE MONTH',
                'sheet_title' => [
                            $titleHeader1,
                            $titleHeader2,      
                ],
                'ceils' => $excel_ceilsScdl,
                'freezePane' => 'C3',
                'headerStyle'=>$headerStyleMarge,
                'contentStyle'=>[$contentStyleDinamikA],
                'oddCssClass' => Postman4ExcelBehavior::getCssClass("odd"),
                'evenCssClass' => Postman4ExcelBehavior::getCssClass("even"),
            ],
            
        ];      
        $excel_file = "PostmanSalesSchedulePlan";
        $this->export4excel($excel_content, $excel_file,0);
        
    }

    /**
     * EXPORT DATA CUSTOMER TO EXCEL USING AJAX
     * export_data
     * @author wawan
    */

    public function actionPilihExportData(){

            $model = new Customers();

            $model->scenario = "export";

        if ($model->load(Yii::$app->request->post()) ) {

             $data_cus = Customers::find()->select('CUST_KD,CUST_NM,(SELECT CUST_KTG_NM FROM c0001k WHERE CUST_KTG=CUST_TYPE limit 1) AS TYPE_NM, ALAMAT,TLP1,PIC')->orderBy('CUST_NM ASC')->where(['CUST_GRP'=>$model->CUST_GRP])->asArray()->all();

          

            $cusDataProviderMTI = new ArrayDataProvider([
            'key' => 'CUST_KD',
            'allModels'=>$data_cus,
        ]);

       
        $aryCusDataProviderMTI=$cusDataProviderMTI->allModels;
       

        $excel_data = Export2ExcelBehavior::excelDataFormat($aryCusDataProviderMTI);
        
        $excel_title = $excel_data['excel_title'];

        $excel_ceils = $excel_data['excel_ceils'];
        $excel_content = [
             [
                'sheet_name' => 'MTI CUSTOMER',
          // 'sheet_title' => ['CUST_ID','CUST_NM','TYPE','ALAMAT','TLP','PIC'], //$excel_ceils,//'sad',//[$excel_title],
                'sheet_title' => $excel_title,
          'ceils' => $excel_ceils,
                //'freezePane' => 'E2',
                'headerColor' => Export2ExcelBehavior::getCssClass("header"),
                'headerColumnCssClass' => [
                               'CUST_KD' => Export2ExcelBehavior::getCssClass('header'),
                     'CUST_NM' => Export2ExcelBehavior::getCssClass('header'),
                     'TYPE_NM' => Export2ExcelBehavior::getCssClass('header'),
                     'ALAMAT' => Export2ExcelBehavior::getCssClass('header'),
                     'TLP1' => Export2ExcelBehavior::getCssClass('header'),
                     'PIC' => Export2ExcelBehavior::getCssClass('header')
                ], //define each column's cssClass for header line only.  You can set as blank.
               'oddCssClass' => Export2ExcelBehavior::getCssClass("odd"),
               'evenCssClass' => Export2ExcelBehavior::getCssClass("even"),
            ],

            ];

        $excel_file = "CustomerDataCRMPilih".'-'.date('Ymd-his');
        $this->export2excel($excel_content, $excel_file,1);
         
         // return $this->redirect('esm-index');

      }else{
          return $this->renderAjax('_pilih_export', [
            'model' => $model,
           ]);
      }
           
    }


    /*
     * EXPORT DATA CUSTOMER TO EXCEL
     * export_data
    */
    public function actionExportData(){

        //$custDataMTI=Yii::$app->db_esm->createCommand("CALL ERP_MASTER_CUSTOMER_export('CUSTOMER_MTI')")->queryAll();

        $cusDataProviderMTI = new ArrayDataProvider([
            'key' => 'ID',
            'allModels'=>Yii::$app->db_esm->createCommand("CALL ERP_MASTER_CUSTOMER_export('CUSTOMER_MTI')")->queryAll(),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);
        //print_r($cusDataProvider->allModels);
        $aryCusDataProviderMTI=$cusDataProviderMTI->allModels;

        $excel_data = Export2ExcelBehavior::excelDataFormat($aryCusDataProviderMTI);
        $excel_title = $excel_data['excel_title'];
        $excel_ceils = $excel_data['excel_ceils'];
        $excel_content = [
             [
                'sheet_name' => 'MTI CUSTOMER',
          // 'sheet_title' => ['CUST_ID','CUST_NM','TYPE','ALAMAT','TLP','PIC'], //$excel_ceils,//'sad',//[$excel_title],
                'sheet_title' => $excel_data['excel_title'],
          'ceils' => $excel_ceils,
                //'freezePane' => 'E2',
                'headerColor' => Export2ExcelBehavior::getCssClass("header"),
                'headerColumnCssClass' => [
                               'CUST_KD' => Export2ExcelBehavior::getCssClass('header'),
                     'CUST_NM' => Export2ExcelBehavior::getCssClass('header'),
                     'TYPE_NM' => Export2ExcelBehavior::getCssClass('header'),
                     'ALAMAT' => Export2ExcelBehavior::getCssClass('header'),
                     'TLP1' => Export2ExcelBehavior::getCssClass('header'),
                     'PIC' => Export2ExcelBehavior::getCssClass('header')
                ], //define each column's cssClass for header line only.  You can set as blank.
               'oddCssClass' => Export2ExcelBehavior::getCssClass("odd"),
               'evenCssClass' => Export2ExcelBehavior::getCssClass("even"),
            ],
            /* [
                'sheet_name' => 'IMPORTANT NOTE ',
                'sheet_title' => ["Important Note For Import Stock Customer"],
                'ceils' => [
                    ["1.pastikan tidak merubah format hanya menambahkan data, karena import versi 1.2 masih butuhkan pengembangan validasi"],
                    ["2.Berikut beberapa format nama yang tidak di anjurkan di ganti:"],
                    ["  A. Nama dari Sheet1: IMPORT FORMAT STOCK "],
                    ["  B. Nama Header seperti column : DATE,CUST_KD,CUST_NM,SKU_ID,SKU_NM,QTY_PCS,DIS_REF"],
                    ["3.Refrensi."],
                    ["  'IMPORT FORMAT STOCK'= Nama dari Sheet1 yang aktif untuk di import "],
                    ["  'DATE'= Tanggal dari data stok yang akan di import "],
                    ["  'CUST_KD'= Kode dari customer, dimana setiap customer memiliki kode sendiri sendiri sesuai yang mereka miliki "],
                    ["  'CUST_NM'= Nama dari customer "],
                    ["  'SKU_ID'=  Kode dari Item yang mana customer memiliku kode items yang berbeda beda "],
                    ["  'SKU_NM'=  Nama dari Item, sebaiknya disamakan dengan nama yang dimiliki lukisongroup"],
                    ["  'QTY_PCS'= Quantity dalam unit PCS "],
                    ["  'DIS_REF'= Kode dari pendistribusian, contoh pendistribusian ke Distributor, Subdisk, Agen dan lain-lain"],
                ],
            ],
            [
                'sheet_name' => 'IMPORTANT NOTE ',
                'sheet_title' => ["Important Note For Import Stock Customer"],
                'ceils' => [
                    ["1.pastikan tidak merubah format hanya menambahkan data, karena import versi 1.2 masih butuhkan pengembangan validasi"],
                    ["2.Berikut beberapa format nama yang tidak di anjurkan di ganti:"],
                    ["  A. Nama dari Sheet1: IMPORT FORMAT STOCK "],
                    ["  B. Nama Header seperti column : DATE,CUST_KD,CUST_NM,SKU_ID,SKU_NM,QTY_PCS,DIS_REF"],
                    ["3.Refrensi."],
                    ["  'IMPORT FORMAT STOCK'= Nama dari Sheet1 yang aktif untuk di import "],
                    ["  'DATE'= Tanggal dari data stok yang akan di import "],
                    ["  'CUST_KD'= Kode dari customer, dimana setiap customer memiliki kode sendiri sendiri sesuai yang mereka miliki "],
                    ["  'CUST_NM'= Nama dari customer "],
                    ["  'SKU_ID'=  Kode dari Item yang mana customer memiliku kode items yang berbeda beda "],
                    ["  'SKU_NM'=  Nama dari Item, sebaiknya disamakan dengan nama yang dimiliki lukisongroup"],
                    ["  'QTY_PCS'= Quantity dalam unit PCS "],
                    ["  'DIS_REF'= Kode dari pendistribusian, contoh pendistribusian ke Distributor, Subdisk, Agen dan lain-lain"],
                ],
            ], */
        ];

        $excel_file = "CustomerDataCrmAll".'-'.date('Ymd-his');
        $this->export2excel($excel_content, $excel_file,1);
    }
    



    /**
     * EXPORT DATA CUSTOMER TO EXCEL USING AJAX
     * export_data
     * @author wawan
    */
    public function actionExportDataCrm(){

            if (Yii::$app->request->isAjax) {

                Yii::$app->response->format = Response::FORMAT_JSON;
                $request= Yii::$app->request;
                $dataKeySelect=$request->post('keysSelect');
                foreach ($dataKeySelect as $key => $value) {
              
                 $array[] = $value;               
             }
         }
             $data_cus = Customers::find()->select('CUST_KD,CUST_NM,(SELECT CUST_KTG_NM FROM c0001k WHERE CUST_KTG=CUST_TYPE limit 1) AS TYPE_NM, ALAMAT,TLP1,PIC')->orderBy('CUST_NM ASC')->where(['CUST_KD'=>$array])->asArray()->all();

          

            $cusDataProviderMTI = new ArrayDataProvider([
            'key' => 'CUST_KD',
            'allModels'=>$data_cus,
        ]);

       
        $aryCusDataProviderMTI=$cusDataProviderMTI->allModels;
       

        $excel_data = Export2ExcelBehavior::excelDataFormat($aryCusDataProviderMTI);
        
        $excel_title = $excel_data['excel_title'];

        $excel_ceils = $excel_data['excel_ceils'];
        $excel_content = [
             [
                'sheet_name' => 'MTI CUSTOMER',
          // 'sheet_title' => ['CUST_ID','CUST_NM','TYPE','ALAMAT','TLP','PIC'], //$excel_ceils,//'sad',//[$excel_title],
                'sheet_title' => $excel_title,
          'ceils' => $excel_ceils,
                //'freezePane' => 'E2',
                'headerColor' => Export2ExcelBehavior::getCssClass("header"),
                'headerColumnCssClass' => [
                               'CUST_KD' => Export2ExcelBehavior::getCssClass('header'),
                     'CUST_NM' => Export2ExcelBehavior::getCssClass('header'),
                     'TYPE_NM' => Export2ExcelBehavior::getCssClass('header'),
                     'ALAMAT' => Export2ExcelBehavior::getCssClass('header'),
                     'TLP1' => Export2ExcelBehavior::getCssClass('header'),
                     'PIC' => Export2ExcelBehavior::getCssClass('header')
                ], //define each column's cssClass for header line only.  You can set as blank.
               'oddCssClass' => Export2ExcelBehavior::getCssClass("odd"),
               'evenCssClass' => Export2ExcelBehavior::getCssClass("even"),
            ],

            ];

        $excel_file = "CustomerDataCrm".'-'.date('Ymd-his');
        $this->export2excel($excel_content, $excel_file,1);


          return true;
           
    }
  
	
    
}
