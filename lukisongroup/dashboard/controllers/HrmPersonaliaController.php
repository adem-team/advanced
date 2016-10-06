<?php
/**
 * NOTE: Nama Class harus diawali Hurup Besar
 * Server Linux 	: hurup besar/kecil bermasalah -case sensitif-
 * Server Windows 	: hurup besar/kecil tidak bermasalah
 * Author: -ptr.nov-
*/

namespace lukisongroup\dashboard\controllers;

/* VARIABLE BASE YII2 Author: -YII2- */
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use lukisongroup\widget\models\Chat;
use lukisongroup\widget\models\ChatSearch;
use lukisongroup\widget\models\ChatroomSearch;
use lukisongroup\hrd\models\Employe;
	

class HrmPersonaliaController extends Controller
{
    
	public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(['dashboard']),
                'actions' => [
                    //'delete' => ['post'],
					'save' => ['post'],
                ],
            ],
        ];
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
	
    /**
     * ACTION INDEX
     */
    public function actionIndex()
    {
		/*CNT Active Employe*/
		$cntAktifEmploye="SELECT COUNT(EMP_ID) as EMP_ID FROM a0001 WHERE STATUS <> 3 AND EMP_STS<>3";
		$cntAktifEmp=Employe::findBySql($cntAktifEmploye)->one();
		
		/*CNT Probation Employe*/
		$cntProbationEmploye="SELECT COUNT(EMP_ID) as EMP_ID FROM a0001 WHERE STATUS <>3 AND EMP_STS=0";
		$cntProbaEmp=Employe::findBySql($cntProbationEmploye)->one();
		
		/*CNT Kontrak Employe*/
		$cntContrakEmploye="SELECT COUNT(EMP_ID) as EMP_ID FROM a0001 WHERE STATUS <>3 AND EMP_STS=2";
		$cntContrak=Employe::findBySql($cntContrakEmploye)->one();
		
		/*CNT Tetap Employe*/
		$cntTetapEmploye="SELECT COUNT(EMP_ID) as EMP_ID FROM a0001 WHERE STATUS <>3 AND EMP_STS=1";
		$cntTetapEmp=Employe::findBySql($cntTetapEmploye)->one();
		
		/*CNT Support Employe*/
		$cntSupportEmploye="SELECT COUNT(EMP_ID) as EMP_ID FROM a0001 WHERE STATUS <>3 AND EMP_STS<>3 AND SEQ_ID=1";
		$cntSptEmp=Employe::findBySql($cntSupportEmploye)->one();
		
		/*CNT Bisnis Employe*/
		$cntBisnisEmploye="SELECT COUNT(EMP_ID) as EMP_ID FROM a0001 WHERE STATUS <>3 AND EMP_STS<>3 AND SEQ_ID=2";
		$cntBisnisEmp=Employe::findBySql($cntBisnisEmploye)->one();
		
		/*CNT GenderM Employe*/
		$cntGenderMEmploye="SELECT COUNT(EMP_ID) as EMP_ID FROM a0001 WHERE STATUS <>3 AND EMP_STS<>3 AND EMP_GENDER='Male'";
		$cntGenderMEmp=Employe::findBySql($cntGenderMEmploye)->one();
		
		/*CNT GenderF Employe*/
		$cntGenderFmploye="SELECT COUNT(EMP_ID) as EMP_ID FROM a0001 WHERE STATUS <>3 AND EMP_STS<>3 AND EMP_GENDER='Female'";
		$cntGenderFEmp=Employe::findBySql($cntGenderFmploye)->one();
		
		/*CNT Resign Employe*/
		$cntResignEmploye="SELECT COUNT(EMP_ID) as EMP_ID FROM a0001 WHERE EMP_STS=3";
		$cntResignEmp=Employe::findBySql($cntResignEmploye)->one();
		
		return $this->render('index',[
			'cntAktifEmp'=>$cntAktifEmp->EMP_ID,
			'cntProbaEmp'=>$cntProbaEmp->EMP_ID,
			'cntContrak'=>$cntContrak->EMP_ID,
			'cntTetapEmp'=>$cntTetapEmp->EMP_ID,
			'cntSptEmp'=>$cntSptEmp->EMP_ID,
			'cntBisnisEmp'=>$cntBisnisEmp->EMP_ID, 
			'cntGenderMEmp'=>$cntGenderMEmp->EMP_ID, 
			'cntGenderFEmp'=>$cntGenderFEmp->EMP_ID, 
			'cntResignEmp'=>$cntResignEmp->EMP_ID, 
		]);
    }
	
	public function actionChat()
    {		
		$searchmodel1 = new ChatroomSearch();
        $dataprovider1 = $searchmodel1->search(Yii::$app->request->queryParams);
        $dataprovider1->pagination->pageSize=2;
         
        $searchModel1 = new ChatSearch();
        $dataProvider1 = $searchModel1->searchonline(Yii::$app->request->queryParams);
        $dataProvider1->pagination->pageSize=2;
        
        $searchModel = new ChatSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize=5;

		return $this->render('@lukisongroup/widget/views/chat/index',[
			//'model' => $model,
			'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchmodel1' => $searchmodel1,
            'dataprovider1' => $dataprovider1,
            'searchModel1' => $searchModel1,
            'dataProvider1' => $dataProvider1,
			'ctrl_chat'=>'hrd_personalia',
		]);
       
    }
}
