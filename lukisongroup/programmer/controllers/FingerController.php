<?php
/**
 * NOTE: Nama Class harus diawali Hurup Besar
 * Server Linux 	: hurup besar/kecil bermasalah -case sensitif-
 * Server Windows 	: hurup besar/kecil tidak bermasalah
 * Author: -ptr.nov-
*/

namespace lukisongroup\programmer\controllers;

/* VARIABLE BASE YII2 Author: -YII2- */
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter; 
use yii\base\DynamicModel;	
/* VARIABLE PRIMARY JOIN/SEARCH/FILTER/SORT Author: -ptr.nov- */
//use app\models\hrd\Dept;			/* TABLE CLASS JOIN */
//use app\models\hrd\DeptSearch;		/* TABLE CLASS SEARCH */
	
/**
 * HRD | CONTROLLER EMPLOYE .
 */
class FingerController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(['chart']),
                'actions' => [
                    //'delete' => ['post'],
					'save' => ['post'],
                ],
            ],
        ];
    }

    /**
     * ACTION INDEX
     */
	 public function beforeAction($action) { 
		$this->enableCsrfValidation = false; 
		return parent::beforeAction($action); 
	} 
    public function actionIndex()
    {
		/*	variable content View Employe Author: -ptr.nov- */
       // $searchModel_Dept = new DeptSearch();
		//$dataProvider_Dept = $searchModel_Dept->search(Yii::$app->request->queryParams);
		
		//return $this->render('index');
		
		$field = [
            'fileImport' => 'File Import',
        ];
        $modelImport = DynamicModel::validateData($field, [
            [['fileImport'], 'required'],
            [['fileImport'], 'file', 'extensions'=>'xls,xlsx','maxSize'=>1024*1024],
        ]);
        
        return $this->render('index', [
            //'searchModel' => $searchModel,
           // 'dataProvider' => $dataProvider,
            'modelImport' => $modelImport,
        ]);
    }
	
	
	/*
	IMPORT WITH PHPEXCEL
	*/ 	
    public function actionImport()
    {
        $field = [
            'fileImport' => 'File Import',
        ];
        
        $modelImport = DynamicModel::validateData($field, [
            [['fileImport'], 'required'],
            [['fileImport'], 'file', 'extensions'=>'xls,xlsx','maxSize'=>1024*1024],
        ]);

        if (Yii::$app->request->post()) {
            $modelImport->fileImport = \yii\web\UploadedFile::getInstance($modelImport, 'fileImport');
            if ($modelImport->fileImport && $modelImport->validate()) {                                
                $inputFileType = \PHPExcel_IOFactory::identify($modelImport->fileImport->tempName );
                $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($modelImport->fileImport->tempName);
                $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
                $baseRow = 2;
                while(!empty($sheetData[$baseRow]['A'])){
                    $model = new Mahasiswa();
                    $model->nama = (string)$sheetData[$baseRow]['B'];
                    $model->nim = (string)$sheetData[$baseRow]['C'];
                    $model->save(); 
                    //die(print_r($model->errors));
                    $baseRow++;
                }
                Yii::$app->getSession()->setFlash('success', 'Success');
            }
            else{
                Yii::$app->getSession()->setFlash('error', 'Error');
            }
        }
        
        return $this->redirect(['index']);
    }
	
	/*
	EXPORT WITH OPENTBS
	*/
    public function actionExportWord()
    {
        //$searchModel = new MahasiswaSearch();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        // Initalize the TBS instance
        $OpenTBS = new \hscstudio\export\OpenTBS; // new instance of TBS
        // Change with Your template kaka
		$template = Yii::$app->basePath.'/web/upload/hrd/form/'.'2016-02 PKWTT.docx';
		//$template = Yii::getAlias('@hscstudio/export').'/templates/opentbs/ms-word.docx';
        $OpenTBS->LoadTemplate($template); // Also merge some [onload] automatic fields (depends of the type of document).
        //$OpenTBS->VarRef['modelName']= "Mahasiswa";				
        $data = [];
        $no=1;
        // foreach($dataProvider->getModels() as $mahasiswa){
            // $data[] = [
                // 'no'=>$no++,
                // 'nama'=>$mahasiswa->nama,
                // 'nim'=>$mahasiswa->nim,
            // ];
        // }
		$data1[]=['no'=>'1','nama'=>'piter','nim'=>'10'];
		
		
		
		
        $OpenTBS->MergeBlock('data', $data1);
        // Output the result as a file on the server. You can change output file
        $OpenTBS->Show(OPENTBS_DOWNLOAD, 'export.docx'); // Also merges all [onshow] automatic fields.			
        exit;
    } 
}
