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
	use lukisongroup\models\hrd\Jabatan;			/* TABLE CLASS JOIN */
	use lukisongroup\models\hrd\JabatanSearch;	/* TABLE CLASS SEARCH */
	
/**
 * HRD | CONTROLLER EMPLOYE .
 */
class JabatanController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(['Jabatan']),
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
		/*	variable content View Employe Author: -ptr.nov- */
        $searchModel_Jab = new JabatanSearch();
		$dataProvider_Jab = $searchModel_Jab->search(Yii::$app->request->queryParams);
		
		return $this->render('index', [
			'searchModel_Jab'=>$searchModel_Jab,
			'dataProvider_Jab'=>$dataProvider_Jab,
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
					return $this->redirect(['view', 'id' => $model->JAB_ID]);	
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
        $model = new Jabatan();
        if ($model->load(Yii::$app->request->post())){
			var_dump($model->validate());
			if($model->validate()){
				if($model->save()) {
					return $this->redirect(['view', 'id' => $model->JAB_ID]);	
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
            return $this->redirect(['view', 'id' => $model->JAB_ID]);
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
        if (($model = Jabatan::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	
}
