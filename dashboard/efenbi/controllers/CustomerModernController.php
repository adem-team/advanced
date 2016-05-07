<?php

namespace dashboard\efenbi\controllers;

use Yii;
use yii\web\Controller;
use kartik\helpers\Html;
use yii\helpers\Json;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\data\ArrayDataProvider;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;

class CustomerModernController extends Controller
{	

	public function behaviors()    {
        return ArrayHelper::merge(parent::behaviors(), [
			'corsFilter' => [
				'class' => \yii\filters\Cors::className(),
				'cors' => [
					// restrict access to
					'Origin' => ['*'],
					'Access-Control-Request-Method' => ['POST', 'PUT','GET'],
					// Allow only POST and PUT methods
					'Access-Control-Request-Headers' => ['X-Wsse'],
					// Allow only headers 'X-Wsse'
					'Access-Control-Allow-Credentials' => true,
					// Allow OPTIONS caching
					'Access-Control-Max-Age' => 3600,
					// Allow the X-Pagination-Current-Page header to be exposed to the browser.
					'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
				]		
			],
        ]);		
    }
	
	/* TOTAl CHILD OF PARENT CUSTOMER */
	public function CountChildCustomer(){		
		$countChildParen= new ArrayDataProvider([
			'key' => 'CUST_KD',
			'allModels'=>Yii::$app->db_esm->createCommand("CALL DASHBOARD_ESM_SALES_custromer_ktg('ParentChildCountCustomer')")->queryAll(),
			'pagination' => [
				'pageSize' => 50,
				]
		]);		
		//print_r(json_encode($resultCountChildParen));
		//print_r(json_decode($resultCountChildParen));
		//die(); 
		return Json::encode($countChildParen->getModels());
	}	
	
	function recursive_array_search($needle,$haystack) {
		foreach($haystack as $key=>$value) {
			$current_key=$key;
			if($needle===$value OR (is_array($value) && $this->recursive_array_search($needle,$value) !== false)) {
				return $current_key;
			}
		}
		return false;
	}
	
	function arrayfilter(array $array, callable $callback = null) {
    if ($callback == null) {
			$callback = function($key, $val) {
				return (bool) $val;
			};
		}
		$return = array();
		foreach ($array as $key => $val) {
			if ($callback($key, $val)) {
				$return[$key] = $val;
			}
		}
		return $return;
	}
	
	function multidimensional_search($parents, $searched) { 
	  if (empty($searched) || empty($parents)) { 
		return false; 
	  } 

	  foreach ($parents as $key => $value) { 
		$exists = true; 
		foreach ($searched as $skey => $svalue) { 
		  $exists = ($exists && IsSet($parents[$key][$skey]) && $parents[$key][$skey] == $svalue); 
		} 
		if($exists){ return $key; } 
	  } 

	  return false; 
	} 
		
	
	/* Value Customer Active */
	public function ValueCustomerActiveCall(){
		/*KATEGORY*/
		$dataCTG= new ArrayDataProvider([
			'key' => 'TGL_STATUS',
			'allModels'=>Yii::$app->db_esm->createCommand("CALL DASHBOARD_ESM_VISIT_detail_status('all_ctg_cust_active')")->queryAll(),
			'pagination' => [
				'pageSize' => 31,
				]
		]);	
		$modelCAC_ctg=$dataCTG->getModels();
		
		/*DATA VALUE*/
		$dataCAC= new ArrayDataProvider([
			'key' => 'TGL_STATUS',
			'allModels'=>Yii::$app->db_esm->createCommand("CALL DASHBOARD_ESM_VISIT_detail_status('all_value_parent_cust_active')")->queryAll(),
			'pagination' => [
				'pageSize' => 500,
				]
		]);		
		$modelCAC=$dataCAC->getModels();
		
		
		/*SET GROUP*/
		$modelGrp = ArrayHelper::map($modelCAC,'CUST_GRP','label');
		
		
		$dataY=[];
		foreach($modelCAC_ctg as $keyCtg => $nilai[]){
				$dataY[]=['TGL'=>$nilai[$keyCtg]['label'],'value'=>'0'];
		};
				
		foreach($modelGrp as $key1 ){								
			$dataX=[];
			//$dataY=[];
			foreach($modelCAC as $key2 =>$value[]){
				if ($key1==$value[$key2]['label']){
					$dataX[]=['TGL'=>$value[$key2]['TGL'],'value'=>$value[$key2]['value']];	
				};				
			};
			
			$dataZ[]=$dataX;
			$dataRslt1[]=['seriesname'=>$key1,'data'=> $dataZ];
			 
			/* foreach($modelCAC_ctg as $keyCtg => $nilai[]){
			$a=[$nilai[$keyCtg]['label'],$key1];
			
				$dataX=$this->multidimensional_search($dataRslt1,$a);
			}; */
			
			
			
			//foreach($modelCAC_ctg as $keyCtg => $nilai[]){
				// $x1=0;
				// if (array_key_exists("in_array",$modelCAC)){
					// $dataX=1;
				// }else{
					// $dataX=2;
					/*  foreach($modelCAC as $key2 =>$value[]){				
						if ($key1==$value[$key2]['label']){								
								// if ($x1===0){
									// $dataX=['TGL'=>$nilai[$keyCtg]['label'],'value'=>'0'];
									// $x1=1;									
								// }elseif($nilai[$keyCtg]['label']==$value[$key2]['TGL']){
									// if ($value[$key2]['TGL']!==''){
										$dataX[]=['TGL'=>$value[$key2]['TGL'],'value'=>$value[$key2]['value']];
									// }else{
										// $dataX=['TGL'=>$nilai[$keyCtg]['label'],'value'=>'0'];
									// }
								// }						
						}
					}  */
				//};
				// $X12[]=$dataX;
				//$dataX[]=NULL;			
			//}
			
			// $array = arrayfilter($dataX, function($key, $val) {
			   // return is_string($key);
			// });
		
			//$dataRslt1[]=['seriesname'=>$key1,'data'=> $dataX];
			//$dataRslt2=$this->array_splice($dataRslt1,'TGL');		
			//$dataRslt2[]=array_merge_recursive($dataRslt1,$dataY);; 
			
			
			
			//$data1[]=['seriesname'=>$key1,'data'=> $dataX]; 
			//$data[]=['seriesname'=>$key1,'data'=> $dataX]; 
			/*ctg->LABEL=$data->TGL*/
			
			/* $dataY = NULL;
			foreach($modelCAC_ctg as $keyCtg => $nilai[]){
				//$dataY=$keyCtg['label'];
				$x1=0;
				
				//$ambilNilai[]=$this->recursive_array_search($nilai[$keyCtg]['label'],$dataX);
				//if ($ambilNilai!=''){
				//	$dataY=$ambilNilai;					
				//}
				
				
				
				 foreach($X12 as $key3 => $value3[]){
					//$dataY[]=$value3[$key3]['TGL'];					
					//if ($keyCtg['label']===$value3[$key3]['TGL'] AND $value3[$key3]['value']!=0){
					if ($nilai[$keyCtg]['label']===$value3[$key3]['TGL'] & $key1==$value3[$key3]['label']){
						$dataY[]=['TGL'=>$value[$key3]['TGL'],'value'=>$value3[$key3]['value']];
					}	
					 elseif($x1===0){
						 $dataY[]=['TGL'=>$nilai[$keyCtg]['label'],'value'=>'0'];
						$x1=1;	
					};
					//$data[]=$value3[$key3];				
				}  
				
			};  */
			$valueRslt[]=['seriesname'=>$key1,'data'=>$dataZ];
			//$valueRslt[]=['seriesname'=>$key1,'data'=> $dataY];
			//$margeAry=array_merge($data);
			//$dataRslt=array_merge_recursive($data1,$data2);
			//$dataRslt=array_unique($dataRslt1);
			
			
		}
		//return  Json::encode($valueRslt);
		//return Json::encode($dataCAC->getModels());
		$valData= Json::encode($valueRslt);
		$data='{
					"chart": {
						"caption": "Customer Active Call",
						//"subCaption": "Customers Modern",
						//"subCaption": "Sales Compare",
						"captionFontSize": "14",
						"subcaptionFontSize": "14",
						"subcaptionFontBold": "0",
						"palettecolors": "#583e78,#008ee4,#f8bd19,#e44a00,#6baa01,#ff2e2e",
						"bgcolor": "#ffffff",
						"showBorder": "1",
						"showShadow": "0",
						"showCanvasBorder": "0",
						"usePlotGradientColor": "0",
						"legendBorderAlpha": "0",
						"legendShadow": "0",
						"showAxisLines": "0",
						"showAlternateHGridColor": "0",
						"divlineThickness": "1",
						"divLineIsDashed": "1",
						"divLineDashLen": "1",
						"divLineGapLen": "1",
						//"xAxisName": "Month",
						"showValues": "0", 
						"showXAxisLine": "1",
						"plotBorderAlpha": "10",
						"borderAlpha": "20"
						
						
					},
					"categories": [
						{
							"category": '.$this->CtgCustomerActiveCall().',
						}					
					],
					"dataset": '.$valData.',
			}';
		//return $data;	 
		return $data;	 
	}
	
	/* Category Customer Active */
	public function CtgCustomerActiveCall(){		
		$dataCAC= new ArrayDataProvider([
			'key' => 'TGL_STATUS',
			'allModels'=>Yii::$app->db_esm->createCommand("CALL DASHBOARD_ESM_VISIT_detail_status('all_ctg_cust_active')")->queryAll(),
			'pagination' => [
				'pageSize' => 31,
				]
		]);		
		/*SET Models*/
		$modelCAC_ctg=$dataCAC->getModels();
		return Json::encode($modelCAC_ctg);
		//return $modelCAC_ctg;
	}
	
	public function actionIndex()
    {
		print_r($this->ValueCustomerActiveCall());
		//die();
		if (\Yii::$app->user->isGuest) {
            return $this->render('../../../views/site/index_nologin'
            );
        }else{		
		
			/* CUSTOMER CATEHORI COUNT [modern,general,horeca,other]*/
			$dataProvider_CustPrn= new ArrayDataProvider([
				//'key' => 'PARENT_ID',
				'allModels'=>Yii::$app->db_esm->createCommand("CALL DASHBOARD_ESM_SALES_custromer_ktg('count_kategory_customer_parent')")->queryAll(),
				'pagination' => [
					'pageSize' => 50,
					]
			]);			
			$model_CustPrn=$dataProvider_CustPrn->getModels();
			$count_CustPrn=$dataProvider_CustPrn->getCount();		
			
			//print_r($this->CountChildCustomer());
			//die();
			return $this->render('index',[
				/* CUSTOMER CATEHORI COUNT [modern,general,horeca,other]*/
				'model_CustPrn'=>$model_CustPrn,
				'count_CustPrn'=>$count_CustPrn,  						
				/*STOCK ALL CUSTOMER*/
				'resultCountChildParen'=>$this->CountChildCustomer(),
				// 'cac_val'=>$this->ValueCustomerActiveCall(),
				// 'cac_ctg'=>$this->CtgCustomerActiveCall()
				'cac'=>$this->ValueCustomerActiveCall()
					
			]);		
		};	
    }	
}
