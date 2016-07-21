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
use yii\data\ArrayDataProvider;
/* VARIABLE PRIMARY JOIN/SEARCH/FILTER/SORT Author: -ptr.nov- */
//use app\models\hrd\Dept;			/* TABLE CLASS JOIN */
//use app\models\hrd\DeptSearch;		/* TABLE CLASS SEARCH */
	
/**
 * HRD | CONTROLLER EMPLOYE .
 */
class FoursquareController extends Controller
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
		$tanggalOfMonth= new ArrayDataProvider([
			//'key' => 'ID',
			//SELECT a.USER_ID,a.SCDL_GROUP AS GRP_ID, b.SCDL_GROUP_NM as GRP_NM,a.CUST_ID,c.CUST_NM,a.LAT,a.LAG 
			'allModels'=>Yii::$app->db_esm->createCommand("				
				SELECT DATE_FORMAT( a.Date,'%Y-%m-%d') as TGL
				FROM (
						select LAST_DAY(DATE_ADD(CURDATE(), INTERVAL 0 month)) - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY as Date
						from (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as a
						cross join (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as b
						cross join (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as c
				) a
				WHERE a.Date between DATE_FORMAT((DATE_SUB(CURDATE(), INTERVAL DAYOFMONTH(CURRENT_DATE)-1 DAY)), '%Y-%m-01') and LAST_DAY(DATE_ADD(CURDATE(), INTERVAL 0 month))
				ORDER BY a.Date	
			")->queryAll(),
		]);			
		$attributeField=$tanggalOfMonth->allModels;
		//$attDinamik=[];
		foreach($attributeField as $key =>$value){
			$attDinamik[]= $value['TGL'];
			//$attDinamik[]=$value[$key];
		};
		$attDinamik0=['nama','alamat'];
		$jn=array_merge($attDinamik0,$attDinamik);
		//print_r($attributeField);
		print_r($jn);
    }
	
	
}
