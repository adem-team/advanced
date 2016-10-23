<?php

namespace lukisongroup\dashboard\controllers;

use Yii;
use yii\filters\AccessControl;
use app\models\dashboard\RptEsm;
use app\models\dashboard\RptEsmSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\filters\ContentNegotiator;
use yii\web\Response;

use lukisongroup\dashboard\models\RptesmGraph;

/**
 * DashboardController implements the CRUD actions for Dashboard model.
 */
class RptEsmController extends Controller
{
    public function behaviors()
    {
		return ArrayHelper::merge(parent::behaviors(),[
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
			'bootstrap'=> [
				'class' => ContentNegotiator::className(),
				'formats' => [
					'application/json' => Response::FORMAT_JSON,'charset' => 'UTF-8',
				],
				'languages' => [
					'en',
					'de',
				],
			],		
			
			
        ]);
        /*
		return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
		*/
    }

	/**
     * ACTION INDEX | Session Login
     * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
	*/
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
	
	public function getCountCustParent(){
		return Yii::$app->db_esm->createCommand("CALL ESM_GRAPH_CUSTOMER_count('count_kategory_customer_parent')")->queryAll();           
	}
	
	/**
     * CUSTOMER COUNT TOTAL KATEGORY
     * @author ptr.nov [ptr.nov@gmail.com]
	 * @since 1.2
     */
    public function actionIndex()
    {
		//print_r($this->graphEsmStockPerSku());
		
		$dataProvider_CustPrn= new ArrayDataProvider([
			'key' => 'PARENT_ID',
			'allModels'=>$this->getCountCustParent(),
			 'pagination' => [
				'pageSize' => 10,
			]
		]);
		$model_CustPrn=$dataProvider_CustPrn->getModels();
		$count_CustPrn=$dataProvider_CustPrn->getCount();
		return $this->render('index',[
			'model_CustPrn'=>$model_CustPrn,
			'count_CustPrn'=>$count_CustPrn,  // Condition  validation model_CustPrn offset array -ptr.nov-
			'dataEsmStockAll'=>$this->graphEsmStockAll(),
			'graphEsmStockPerSku'=>$this->graphEsmStockPerSku()
		]);

    }
	
	public function actionTabsData()
	{    	$html = $this->renderPartial('tabContent');
		return Json::encode($html);
	}
	/*
	public function actionIndex($id)
    {
        return $this->render('index', [
            'model' => $this->findModel($id),
        ]);
    }
	*/
    /**
     * by ptr.nov
     * Dashboard Sarana Sinar Surya
     */
    public function actionSss($id)
    {
        return $this->render('sss', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * by ptr.nov
     * Dashboard Arta Lipat ganda
     */
    public function actionAlg($id)
    {
        return $this->render('alg', [
            'model' => $this->findModel($id),
        ]);
        $this->redirect(['view', 'id' => $model->BRG_ID]);
    }

    /**
     * by ptr.nov
     * Dashboard Efembi Sukses Makmur
     */
    public function actionEsm($id)
    {
        return $this->render('esm', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * by ptr.nov
     * Dashboard Gosent
     */
    public function actionGsn($id)
    {
        return $this->render('gsn', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * by ptr.nov
     * Dashboard Accounting Dept
     */
    public function actionAcct($id)
    {
        return $this->render('acct', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * by ptr.nov
     * Dashboard HRD Dept
     */
    public function actionHrd($id)
    {
        return $this->render('hrd', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * by ptr.nov
     * Dashboard Marketing Dept
     */
    public function actionMrk($id)
    {
        return $this->render('mrk', [
            'model' => $this->findModel($id),
        ]);
    }
    /**
     * by ptr.nov
     * Dashboard General Affair Dept
     */
    public function actionGa($id)
    {
        return $this->render('ga', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * by ptr.nov
     * Dashboard IT Dept
     */
    public function actionIt($id)
    {
        return $this->render('it', [
            'model' => $this->findModel($id),
        ]);
    }
    /**
     * Displays a single Dashboard model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Dashboard model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Dashboard();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->CORP_ID]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Dashboard model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->CORP_ID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Dashboard model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Dashboard model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Dashboard the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RptEsm::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	
	/* ========== ESM-STOCK-ALL ============
	 * Chart Type LINE 
	 * @author ptr.nov [ptr.nov@gmail.com]
	 * @since 1.2
	 * =====================================
	*/
	protected function graphEsmStockAll(){
		$AryDataProvider= new ArrayDataProvider([
			//'key' => 'PARENT_ID',
			'allModels'=>Yii::$app->db_esm->createCommand("CALL ESM_GRAPH_stock_all()")->queryAll(),
			 'pagination' => [
				'pageSize' => 100,
			]
		]);
		$dataProvider=Json::encode($AryDataProvider->getModels());		
		$prn='{
			"chart": {
				"caption": "UPDATE ESM ALL STOCK",
               // "subcaption": "Last six months",
				"xAxisName": "Date",
                "yAxisName": "Qty Unit",
				"showValues": "1" , 			//MENAMPILKAN VALUE 
				"showBorder": "1", 				//Border side Out 
				"showCanvasBorder": "0",		//Border side inside
				"showAlternateHGridColor": "0",	//
				//"paletteColors": "#FF0033,#F9FB10,#0075c2,#1aaf5d",	//color line
				 //"showShadow": "1", 
                //"yaxisminvalue": "0",
                //"yaxismaxvalue": "10",
                //"anchorAlpha": "100",
               // "theme":"fint",
               // "captionFontSize": "14",
               // "subcaptionFontSize": "14",
               // "subcaptionFontBold": "0",
                "paletteColors": "#FF0033,#F9FB10,#0075c2,#1aaf5d",
                "bgcolor": "#ffffff",
                           
                //"usePlotGradientColor": "0",
                //"legendBorderAlpha": "",
               // "legendShadow": "0",
               // "showAxisLines": "0",
                
                "divlineThickness": "1",
                "divLineIsDashed": "2",
                "divLineDashLen": "1",
                //"divLineGapLen": "1"
                
                 
            },
			
			"data":'.$dataProvider.'
		}';
		return $prn;
	}
	
	/* ========== ESM-STOCK-PER-SKU =========
	 * Chart Type MSLINE
	 * @author ptr.nov [ptr.nov@gmail.com]
	 * @since 1.2
	 * =======================================
	*/
	protected function graphEsmStockPerSku(){		
		/*Category*/
		$AryDataProviderCtg= new ArrayDataProvider([
			'allModels'=>Yii::$app->db_esm->createCommand("CALL ESM_GRAPH_stock_per_sku('kategory_label','')")->queryAll(),
			 'pagination' => [
				'pageSize' => 100,
			],
		]);
		$dataProviderCtg=$AryDataProviderCtg->getModels();
		$resultCtg=Json::encode($dataProviderCtg);
		
		/*Item Value 1*/
		$AryDataProviderVal1= new ArrayDataProvider([
			//'key' => 'PARENT_ID',
			'allModels'=>Yii::$app->db_esm->createCommand("CALL ESM_GRAPH_stock_per_sku('value','BRG.ESM.2016.01.0001')")->queryAll(),
			 'pagination' => [
				'pageSize' => 100,
			]
		]);
		$dataProviderVal1=$AryDataProviderVal1->getModels();
		$resultVal1=Json::encode($dataProviderVal1); 
		
		/*Item Value 2*/
		$AryDataProviderVal2= new ArrayDataProvider([
			//'key' => 'PARENT_ID',
			'allModels'=>Yii::$app->db_esm->createCommand("CALL ESM_GRAPH_stock_per_sku('value','BRG.ESM.2016.01.0002')")->queryAll(),
			 'pagination' => [
				'pageSize' => 100,
			]
		]);
		$dataProviderVal2=$AryDataProviderVal2->getModels();
		$resultVal2=Json::encode($dataProviderVal2); 
		
		/*Item Value 3*/
		$AryDataProviderVal3= new ArrayDataProvider([
			//'key' => 'PARENT_ID',
			'allModels'=>Yii::$app->db_esm->createCommand("CALL ESM_GRAPH_stock_per_sku('value','BRG.ESM.2016.01.0003')")->queryAll(),
			 'pagination' => [
				'pageSize' => 100,
			]
		]);
		$dataProviderVal3=$AryDataProviderVal3->getModels();
		$resultVal3=Json::encode($dataProviderVal3); 
		
		/*Item Value 4*/
		$AryDataProviderVal4= new ArrayDataProvider([
			//'key' => 'PARENT_ID',
			'allModels'=>Yii::$app->db_esm->createCommand("CALL ESM_GRAPH_stock_per_sku('value','BRG.ESM.2016.01.0004')")->queryAll(),
			 'pagination' => [
				'pageSize' => 100,
			]
		]);
		$dataProviderVal4=$AryDataProviderVal4->getModels();
		$resultVal4=Json::encode($dataProviderVal4); 
		
		/*Item Value 5*/
		$AryDataProviderVal5= new ArrayDataProvider([
			//'key' => 'PARENT_ID',
			'allModels'=>Yii::$app->db_esm->createCommand("CALL ESM_GRAPH_stock_per_sku('value','BRG.ESM.2016.01.0005')")->queryAll(),
			 'pagination' => [
				'pageSize' => 100,
			]
		]);
		$dataProviderVal5=$AryDataProviderVal5->getModels();
		$resultVal5=Json::encode($dataProviderVal5); 
		
		$prn='{
			"chart": {
				"caption": "UPDATE ESM STOCK PER SKU",
				"showValues": "1" , 
                "captionFontSize": "14",
                "subcaptionFontSize": "14",
                "subcaptionFontBold": "0",
                "paletteColors": "#FF0033,#0B2536,#0075c2,#9E466B,#C5E323",
                "bgcolor": "#ffffff",
                "showBorder": "1",
                "showShadow": "0",
                "showCanvasBorder": "0",
                "usePlotGradientColor": "0",
                "legendBorderAlpha": "1",
                "legendShadow": "1",
                "showAxisLines": "0",
                "showAlternateHGridColor": "0",
                "divlineThickness": "1",
                "divLineIsDashed": "1",
                "divLineDashLen": "1",
                "divLineGapLen": "1"			
            },
			"categories": [{
				"category":'.$resultCtg.'
			}],
			"dataset": [
				 {
                    "seriesname": "MAXI Cassava Chips Balado",
                    "data": '.$resultVal1.'
                }, 
                {
                    "seriesname": "MAXI Talos Chips Black Paper",
                    "data":'.$resultVal2.'
                },
				{
                    "seriesname": "MAXI Talos Roasted Corn",
                    "data":'.$resultVal3.'
                },
				{
                    "seriesname": "MAXI Cassava Crackers Hot Spicy",
                    "data": '.$resultVal4.'
                },
				{
                    "seriesname": "MAXI mixed Roots",
                    "data": '.$resultVal5.'
                }
			]
		}';
		return $prn;
	}
	
	
	
	
	
	
}
