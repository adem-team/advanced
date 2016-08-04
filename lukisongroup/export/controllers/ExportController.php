<?php

namespace lukisongroup\export\controllers;

use Yii;

/*extensions*/
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use scotthuangzl\export2excel\Export2ExcelBehavior;
use yii\data\ArrayDataProvider;
use yii\web\Response;

/*namespace models*/
use lukisongroup\master\models\Customers;


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


   
	 
	 public function beforeAction(){
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

    



    /*
     * EXPORT DATA CUSTOMER TO EXCEL
     * export_data
    */
    public function actionExportData(){

        //$custDataMTI=Yii::$app->db_esm->createCommand("CALL ERP_MASTER_CUSTOMER_export('CUSTOMER_MTI')")->queryAll();
        $query = "select c.CUST_KD,c.CUST_NM,ck.CUST_KTG_NM,c.ALAMAT from c0001 c left join c0001k ck on c.CUST_TYPE = ck.CUST_KTG where c.STATUS<>3";

        $cusDataProviderMTI = new ArrayDataProvider([
            'key' => 'ID',
            // 'allModels'=>Yii::$app->db_esm->createCommand("SELECT CUST_KD,CUST_NM,TYPE_NM ")->queryAll(),
             'allModels'=>Yii::$app->db_esm->createCommand($query)->queryAll(),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);
        
        $aryCusDataProviderMTI=$cusDataProviderMTI->allModels;

        $excel_data = Export2ExcelBehavior::excelDataFormat($aryCusDataProviderMTI);
        $excel_title = $excel_data['excel_title'];
        $excel_ceils = $excel_data['excel_ceils'];
        $excel_content = [
             [
                'sheet_name' => 'CUSTOMER',
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

        $excel_file = "CustomerDataERPAll".'-'.date('Ymd-his');
        $this->export2excel($excel_content, $excel_file,1);
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

        $excel_file = "CustomerDataERPPilih".'-'.date('Ymd-his');
        $this->export2excel($excel_content, $excel_file,1);
         
         // return $this->redirect('esm-index');

      }else{
          return $this->renderAjax('_pilih_export', [
            'model' => $model,
           ]);
      }
           
    }



       


      /**
     * EXPORT DATA CUSTOMER TO EXCEL USING AJAX
     * export_data
     * @author wawan
    */
    public function actionExportDataErp(){

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

        $excel_file = "CustomerDataERPSelected".'-'.date('Ymd-his');
        $this->export2excel($excel_content, $excel_file,1);


          return true;
           
    }
  
	
    
}
