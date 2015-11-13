<?php

namespace lukisongroup\controllers\dashboard\rpt;

use Yii;
use yii\filters\AccessControl;
use app\models\dashboard\Rptalg;
use app\models\dashboard\RptalgSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DashboardController implements the CRUD actions for Dashboard model.
 */
class AlgController extends Controller
{
    public function behaviors()
    {
		return [
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
        ];
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
     * Lists all Dashboard models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');

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
        if (($model = Rptalg::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
