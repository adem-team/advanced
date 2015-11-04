<?php
/**
 * NOTE: Nama Class harus diawali Hurup Besar
 * Server Linux 	: hurup besar/kecil bermasalah -case sensitif-
 * Server Windows 	: hurup besar/kecil tidak bermasalah
 * Author: -ptr.nov-
*/

namespace lukisongroup\controllers\hrd;

/* VARIABLE BASE YII2 Author: -YII2- */
	use Yii;
	use yii\web\Controller;
	use yii\web\NotFoundHttpException;
	use yii\filters\VerbFilter;
/* VARIABLE PRIMARY JOIN/SEARCH/FILTER/SORT Author: -ptr.nov- */
	use lukisongroup\models\hrd\Modulhrd;			/* TABLE CLASS JOIN */
	//use lukisongroup\models\hrd\Dept;
   use lukisongroup\models\hrd\ModulhrdSearch;	/* TABLE CLASS SEARCH */
	
/**
 * HRD | CONTROLLER MODUL HRD .
 */
class ModulhrdController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(['Modulhrd']),
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
    public function actionIndex()
    {
		/*	variable content View Modul Hrd Author: -ptr.nov- */
        $searchModel_Mdlhrd = new ModulhrdSearch();
		$dataProvider_Mdlhrd = $searchModel_Mdlhrd->search(Yii::$app->request->queryParams);
		
		return $this->render('index', [
			'searchModel_Mdlhrd'=>$searchModel_Mdlhrd,
			'dataProvider_Mdlhrd'=>$dataProvider_Mdlhrd,
        ]);
    }

    /**
	 * ACTION VIEW -> $id=PrimaryKey
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);;
		if ($model->load(Yii::$app->request->post())){
			if($model->validate()){
				if($model->save()) {
					return $this->redirect(['view', 'id' => $model->MDL_ID]);	
				} 
			}
		}else {
            return $this->render('view', [
                'model' => $model,
            ]);
        }
    }

    /**
     * ACTION CREATE note | $id=PrimaryKey -> TRIGER FROM VIEW  -ptr.nov-
     */
    public function actionCreate()
    {		
        $model = new Modulhrd();
        if ($model->load(Yii::$app->request->post())){
				if($model->validate()){
				if($model->save()) {
					return $this->redirect(['view', 'id' => $model->MDL_ID]);	
				} 
			}
		}else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * ACTION UPDATE -> $id=PrimaryKey
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->MDL_ID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * ACTION DELETE -> $id=PrimaryKey | CHANGE STATUS -> lihat Standart table status | Jangan dihapus dari record
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * CLASS TABLE FIND PrimaryKey
     * Example:  Employe::find()
     */
    protected function findModel($id)
    {
        if (($model = Modulhrd::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	
}
