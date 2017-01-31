<?php

namespace lukisongroup\dashboard\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\filters\ContentNegotiator;
use yii\web\Response;

use lukisongroup\dashboard\models\Foodtown;
use lukisongroup\dashboard\models\FoodtownSearch;

/**
 * FoodtownController implements the CRUD actions for Foodtown model.
 */
class FoodtownController extends Controller
{
	public function behaviors(){
        return ArrayHelper::merge(parent::behaviors(), [
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
			'corsFilter' => [
				'class' => \yii\filters\Cors::className(),
				'cors' => [
					// restrict access to
					'Origin' => ['http://lukisongroup.com','http://www.lukisongroup.com','http://labtest1-erp.int'],
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
    /**
     * @inheritdoc
     */
   /*  public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    } */

    /**
     * Lists all Foodtown models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FoodtownSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	public function actionTransYearsAll(){
		$searchModel = new FoodtownSearch(['Val_Nm'=>'Trans_Years_All']);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataModel= $dataProvider->getModels();
		//Array PaletteColors dari component.
		$lineColor = ArrayHelper::toArray(Yii::$app->arrayBantuan->ArrayRowPaletteColors());
		//ambil field Val_Json dengan data format Json. 
		$aryDataModel= $dataModel[0]['Val_Json'];
		// case karena ada tanda koma dan sepasi di belakang
		// ingat untuk bisa di decode Json, harus format array yang sempurna.
		$aryDataModelFixFormatArray= str_replace(', }','}',$aryDataModel); 
		$arrayFromJason = json_decode($aryDataModelFixFormatArray);
		//category
		foreach($arrayFromJason as $row => $value){
			 $ctg[]=["label"=>$value->month];	
		}	
		//value per year
		//$thn=2012;
		foreach($arrayFromJason as $row => $value){
			 $tahun2012[]=["value"=>(string)$value->{'2012'},"anchorBgColor"=> $lineColor[0]];	
			 $tahun2013[]=["value"=>(string)$value->{'2013'},"anchorBgColor"=> $lineColor[1]];	
			 $tahun2014[]=["value"=>(string)$value->{'2014'},"anchorBgColor"=> $lineColor[2]];	
			 $tahun2015[]=["value"=>(string)$value->{'2015'},"anchorBgColor"=> $lineColor[3]];	
			 $tahun2016[]=["value"=>(string)$value->{'2016'},"anchorBgColor"=> $lineColor[4]];	
			 $tahun2017[]=["value"=>(string)$value->{'2017'},"anchorBgColor"=> $lineColor[5]];	
		}		
		//return  $tahun2012;
			
		//foreach($dataModel->Val_Json as $row => $value){			
			//$hari[]=["label"=>$value];					
			// $cc[]=["value"=> strval($value['CCval']),"anchorBgColor"=> $lineColor[0]];					
			// $ac[]=["value"=>strval($value['ACval']),"anchorBgColor"=> $lineColor[1]];					
			// $ec[]=["value"=> strval($value['ECval']),"anchorBgColor"=> $lineColor[2]];					
			// $case[]=["value"=> strval($value['CCval']+$value['CASEval']),"anchorBgColor"=> $lineColor[3]];
			// $acSum[] =$value['ACval'];
			// $ecSum[] =$value['ECval'];
		//};
		//return ArrayHelper::decode($dataModel);
		//return json::encode($dataModel);
		
		 //return  $aryDataModel;
		// foreach($aryDataModel{} as $row => $value){
			 // $bulan[]=$value;	
		 // }
		// $someArray =  JSON.stringify($aryDataModel[]); 
		// print_r($someArray);
		
		// $test=str_replace(':','=>',$aryDataModel);
		// $test1=str_replace('[','',$test);
		// $test2=str_replace(']','',$test1);
		// $test3=str_replace('}','',$test2);
		// $test4=str_replace(',{','',$test3);
		// $test5=ArrayHelper::toArray($test4);
		// print_r($test3);
		 //return json::encode($aryDataModel);
		 //$someArray = json_decode($aryDataModel, true);
		 //$xdata = is_array($aryDataModel);
		 //$json = '[{"number": 12345678},{"number": 12345678901234567890}]';
		 //$someArray = json_decode( $json, true);
		// $someArray = json_decode($aryDataModel1);
		//print_r($someArray);
		// $str = 2017;
		//print_r($someArray[1]->month);    
		// print_r($someArray[1]->$str);    
		//print_r($someArray[1]->2012);    
		//print_r($someArray);
		
		//print_r('<br>'.$aryDataModel1);
		/**
		 * Maping Chart 
		 * Type : msline
		 * 
		*/
		$rsltSrc='{
			"chart": {
				"caption": " History Total Sales",
				"subCaption": "All The Year",
				"captionFontSize": "12",
				"subcaptionFontSize": "10",
				"subcaptionFontBold": "0",
				"paletteColors": '.'"'.Yii::$app->arrayBantuan->ArrayPaletteColors().'"'.',
				"bgcolor": "#ffffff",
				"showBorder": "0",
				"showShadow": "0",				
				"usePlotGradientColor": "0",
				"legendBorderAlpha": "0",
				"legendShadow": "0",
				"showAxisLines": "1",
				"showAlternateHGridColor": "0",
				"divlineThickness": "1",
				"divLineIsDashed": "0",				
				"divLineDashLen": "1",				
				"divLineGapLen": "1",
				"vDivLineDashed": "0",
				"numVDivLines": "11",
				"vDivLineThickness": "1",
				"xAxisName": "Year",
				"yAxisName": "IDR",				
				"anchorradius": "6",
				"plotHighlightEffect": "fadeout|color=#f6f5fd, alpha=60",
				"showValues": "0",
				"rotateValues": "0",
				"placeValuesInside": "0",
				"formatNumberScale": "0",
				"decimalSeparator": ",",
				"thousandSeparator": ".",
				"numberPrefix": "",
				"ValuePadding": "0",
				"yAxisValuesStep":"1",
				"xAxisValuesStep":"0",
				"yAxisMaxvalue": "1800000000",
				"yAxisMinValue": "0",
				"numDivLines": "8",
				"xAxisNamePadding": "30",
				"showHoverEffect":"1",
				"animation": "1",
				"exportEnabled": "1",
				"exportFileName":"FT-SalesYears",
				"exportAtClientSide":"1"
							
			},
			"categories": [
				{
					"category": '.Json::encode($ctg).'
				}
			],
			"dataset": [
				{
					"seriesname": "2012",
					"data":'.Json::encode($tahun2012).'
				},
				{
					"seriesname": "2013",
					"data":'.Json::encode($tahun2013).'
				},
				{
					"seriesname": "2014",
					"data":'.Json::encode($tahun2014).'
				},
				{
					"seriesname": "2015",
					"data":'.Json::encode($tahun2015).'
				},
				{
					"seriesname": "2016",
					"data":'.Json::encode($tahun2016).'
				},
				{
					"seriesname": "2017",
					"data":'.Json::encode($tahun2017).'
				}
			]
		}';	
		return json::decode($rsltSrc);
		
		
	}
	
	public function action3dailyHour(){
		$searchModel = new FoodtownSearch(['Val_Nm'=>'Total_Hour_Hari']);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataModel= $dataProvider->getModels();
		//Array PaletteColors dari component.
		$lineColor = ArrayHelper::toArray(Yii::$app->arrayBantuan->ArrayRowPaletteColors());
		//ambil field Val_Json dengan data format Json. 
		$aryDataModel= $dataModel[0]['Val_Json'];
		// case karena ada tanda koma dan sepasi di belakang
		// ingat untuk bisa di decode Json, harus format array yang sempurna.
		//$aryDataModelFixFormatArray= str_replace(', }','}',$aryDataModel); 
		//$arrayFromJason = json_decode($aryDataModelFixFormatArray);
		$arrayFromJason =Yii::$app->arrayBantuan->fix_json_format_value($aryDataModel);
		//category
		for ($i = 10; $i <= 22; $i++){
			 $ctg[]=["label"=>(string)$i];	
		}
		foreach($arrayFromJason as $row => $value){
			$dataTgl[]=["tgl"=>(string)$value->{'tgl'}];
		}				
		$groupTgl=Yii::$app->arrayBantuan->array_group_by($dataTgl, 'tgl');
		foreach ($groupTgl as $key => $nilai){
				$dataTglKey[]=$key;
		}
		//$tanggal=$dataTglKey[0];
		
		foreach($arrayFromJason as $row => $value){
			if ((string)$value->{'tgl'}==$dataTglKey[2]){
				$day1[]=["label"=>(string)$value->{'jam'},"value"=>(string)$value->{'1'},"anchorBgColor"=> $lineColor[0]];	
			};
			if ((string)$value->{'tgl'}==$dataTglKey[1]){
				$day2[]=["label"=>(string)$value->{'jam'},"value"=>(string)$value->{'2'},"anchorBgColor"=> $lineColor[1]];	
			};
			if ((string)$value->{'tgl'}==$dataTglKey[0]){
				$day3[]=["label"=>(string)$value->{'jam'},"value"=>(string)$value->{'3'},"anchorBgColor"=> $lineColor[2]];	
			};
		}		
		
		/**
		 * Maping Chart 
		 * Type : msline
		 * 
		*/
		$rsltSrc3DayHour='{
			"chart": {
				"caption": " Hourly Transaction",
				"subCaption": "3 Days",
				"captionFontSize": "12",
				"subcaptionFontSize": "10",
				"subcaptionFontBold": "0",
				"paletteColors": '.'"'.Yii::$app->arrayBantuan->ArrayPaletteColors().'"'.',
				"bgcolor": "#ffffff",
				"showBorder": "0",
				"showShadow": "0",				
				"usePlotGradientColor": "0",
				"legendBorderAlpha": "0",
				"legendShadow": "0",
				"showAxisLines": "1",
				"showAlternateHGridColor": "0",
				"divlineThickness": "1",
				"divLineIsDashed": "0",				
				"divLineDashLen": "1",				
				"divLineGapLen": "1",
				"vDivLineDashed": "0",
				"numVDivLines": "6",
				"vDivLineThickness": "1",
				"xAxisName": "Hour",
				"yAxisName": "Total Transaction",				
				"anchorradius": "3",
				"plotHighlightEffect": "fadeout|color=#f6f5fd, alpha=60",
				"showValues": "0",
				"rotateValues": "0",
				"placeValuesInside": "0",
				"formatNumberScale": "0",
				"decimalSeparator": ",",
				"thousandSeparator": ".",
				"numberPrefix": "",
				"ValuePadding": "0",
				"yAxisValuesStep":"1",
				"xAxisValuesStep":"0",
				"yAxisMaxvalue": "200",
				"yAxisMinValue": "0",
				"numDivLines": "10",
				"xAxisNamePadding": "30",
				"showHoverEffect":"1",
				"animation": "1"							
			},
			"categories": [
				{
					"category": '.Json::encode($ctg).'
				}
			],
			"dataset": [
				{
					"seriesname": "Today",
					"data":'.Json::encode($day1).'
				},
				{
					"seriesname": "Yesterday",
					"data":'.Json::encode($day2).'
				},
				{
					"seriesname": "2 Day ago",
					"data":'.Json::encode($day3).'
				}
			]
		}';	
		//$datatest=Yii::$app->arrayBantuan->array_group_by($tanggal, 'tgl');
		//return json::decode($arrayFromJason->{'tgl'});
		return json::decode($rsltSrc3DayHour);
	}
	
	public function action8dailyHour(){
		$searchModel = new FoodtownSearch(['Val_Nm'=>'Total_Hour_Hari_7']);
		//$searchModel = new FoodtownSearch(['Val_Nm'=>'Total_Hour_Hari']);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataModel= $dataProvider->getModels();
		//Array PaletteColors dari component.
		$lineColor = ArrayHelper::toArray(Yii::$app->arrayBantuan->ArrayRowPaletteColors());
		//ambil field Val_Json dengan data format Json. 
		$aryDataModel= $dataModel[0]->Val_Json;
		//FIX JSON FORMAT/VALUE INVALID TO DECODE.
		$jsonDecode= Yii::$app->arrayBantuan->fix_json_format_value($aryDataModel);
		//return $jsonDecode;
						
		//category
		for ($i = 10; $i <= 22; $i++){
			 $ctg[]=["label"=>(string)$i];	
		}
		foreach($jsonDecode as $row => $value){
			$dataTgl[]=["tgl"=>(string)$value->{'tgl'}];
		}		
		//GET GROUPING VALUE INDEX.
		$groupTgl=Yii::$app->arrayBantuan->array_group_by($dataTgl, 'tgl');
		foreach ($groupTgl as $key => $nilai){
				$dataTglKey[]=$key;
		} 
		$tanggal=$dataTglKey[0];
		
		foreach($jsonDecode as $row => $value){
			if ((string)$value->{'tgl'}==$dataTglKey[8]){ //today
				$day0[]=["label"=>(string)$value->{'jam'},"value"=>(string)$value->{'1'},"anchorBgColor"=> $lineColor[9]];	
			};
			if ((string)$value->{'tgl'}==$dataTglKey[7]){ //yesterday
				$day1[]=["label"=>(string)$value->{'jam'},"value"=>(string)$value->{'2'},"anchorBgColor"=> $lineColor[8]];	
			};
			if ((string)$value->{'tgl'}==$dataTglKey[6]){
				$day2[]=["label"=>(string)$value->{'jam'},"value"=>(string)$value->{'3'},"anchorBgColor"=> $lineColor[7]];	
			};
			if ((string)$value->{'tgl'}==$dataTglKey[5]){
				$day3[]=["label"=>(string)$value->{'jam'},"value"=>(string)$value->{'4'},"anchorBgColor"=> $lineColor[6]];	
			};
			if ((string)$value->{'tgl'}==$dataTglKey[4]){
				$day4[]=["label"=>(string)$value->{'jam'},"value"=>(string)$value->{'5'},"anchorBgColor"=> $lineColor[5]];	
			};
			if ((string)$value->{'tgl'}==$dataTglKey[3]){
				$day5[]=["label"=>(string)$value->{'jam'},"value"=>(string)$value->{'6'},"anchorBgColor"=> $lineColor[4]];	
			};
			if ((string)$value->{'tgl'}==$dataTglKey[2]){
				$day6[]=["label"=>(string)$value->{'jam'},"value"=>(string)$value->{'7'},"anchorBgColor"=> $lineColor[3]];	
			};
			if ((string)$value->{'tgl'}==$dataTglKey[1]){
				$day7[]=["label"=>(string)$value->{'jam'},"value"=>(string)$value->{'8'},"anchorBgColor"=> $lineColor[2]];	
			};
			if ((string)$value->{'tgl'}==$dataTglKey[0]){ //old
				$day8[]=["label"=>(string)$value->{'jam'},"value"=>(string)$value->{'9'},"anchorBgColor"=> $lineColor[1]];	
			};
		}		 		
		//return $day1
		
		/**
		 * Maping Chart 
		 * Type : msline
		 * 
		*/
		$rsltSrc8DayHour='{
			"chart": {
				"caption": "Hourly Transaction",
				"subCaption": "Current 8 days",
				"captionFontSize": "12",
				"subcaptionFontSize": "10",
				"subcaptionFontBold": "0",
				"paletteColors": '.'"'.Yii::$app->arrayBantuan->ArrayPaletteColors().'"'.',
				"bgcolor": "#ffffff",
				"showBorder": "0",
				"showShadow": "0",				
				"usePlotGradientColor": "0",
				"legendBorderAlpha": "0",
				"legendShadow": "0",
				"showAxisLines": "1",
				"showAlternateHGridColor": "0",
				"divlineThickness": "1",
				"divLineIsDashed": "0",				
				"divLineDashLen": "1",				
				"divLineGapLen": "1",
				"vDivLineDashed": "0",
				"numVDivLines": "6",
				"vDivLineThickness": "1",
				"xAxisName": "Hour",
				"yAxisName": "Total Transaction",				
				"anchorradius": "3",
				"plotHighlightEffect": "fadeout|color=#f6f5fd, alpha=60",
				"showValues": "0",
				"rotateValues": "0",
				"placeValuesInside": "0",
				"formatNumberScale": "0",
				"decimalSeparator": ",",
				"thousandSeparator": ".",
				"numberPrefix": "",
				"ValuePadding": "0",
				"yAxisValuesStep":"1",
				"xAxisValuesStep":"0",
				"yAxisMaxvalue": "300",
				"yAxisMinValue": "0",
				"numDivLines": "5",
				"xAxisNamePadding": "30",
				"showHoverEffect":"1",
				"animation": "1"							
			},
			"categories": [
				{
					"category": '.Json::encode($ctg).'
				}
			],
			"dataset": [
				{
					"seriesname": "Today",
					"data":'.Json::encode($day0).'
				},
				{
					"seriesname": "Yesterday",
					"data":'.Json::encode($day1).'
				},
				{
					"seriesname": "2 Day ago",
					"data":'.Json::encode($day2).'
				},
				{
					"seriesname": "3 Day ago",
					"data":'.Json::encode($day3).'
				},
				{
					"seriesname": "4 Day ago",
					"data":'.Json::encode($day4).'
				},
				{
					"seriesname": "5 Day ago",
					"data":'.Json::encode($day5).'
				},
				{
					"seriesname": "6 Day ago",
					"data":'.Json::encode($day6).'
				},
				{
					"seriesname": "7 Day ago",
					"data":'.Json::encode($day7).'
				},
				{
					"seriesname": "8 Day ago",
					"data":'.Json::encode($day8).'
				}
			]
		}'; 
		
		return json::decode($rsltSrc8DayHour);;
	}
	public function actionWeeklySales(){
		$searchModel = new FoodtownSearch(['Val_Nm'=>'Total_Grand_Weekly']);
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataModel= $dataProvider->getModels();
		//Array PaletteColors dari component.
		$lineColor = ArrayHelper::toArray(Yii::$app->arrayBantuan->ArrayRowPaletteColors());
		//ambil field Val_Json dengan data format Json. 
		$aryDataModel= $dataModel[0]->Val_Json;
		$fixSpasi= str_replace(' ','',$aryDataModel); 
		$fixKomaDibelakang= str_replace(', }','}',$fixSpasi); 
		$fixValueDigitNolDidepan= str_replace(':0',':',$fixKomaDibelakang); 
		$fixDatatoString1= str_replace('"date":','"date":"',$fixValueDigitNolDidepan); 
		$fixDatatoString2= str_replace(',"tgl"','","tgl"',$fixDatatoString1); 
		$fixFormatJson = json_decode($fixDatatoString2);
		//return $fixFormatJson;
		
		//category
		foreach($fixFormatJson as $row => $value){
			$ctg[]=["label"=>(string)$value->{'tgl'}];
			$dataTglKey[]=(string)$value->{'date'};
		}	
		//return $ctg;
		//return $dataTglKey; //$dataTglKey[0];
		
		foreach($fixFormatJson as $row => $value){
			$saleData[]=["label"=>(string)$value->{'tgl'},"value"=>(string)$value->{'total'}];	
		} 		
		//return $saleData;
		
		/**
		 * Maping Chart 
		 * Type : msline
		 * 
		*/
		$rsltSrcWeeklySales='{
			"chart": {
				"caption": "WEEKLY SALES CHART",
				"subCaption": "Monday - Sunday",
				"captionFontSize": "12",
				"subcaptionFontSize": "10",
				"subcaptionFontBold": "0",
				"paletteColors": '.'"'.Yii::$app->arrayBantuan->ArrayPaletteColors().'"'.',
				"bgcolor": "#ffffff",
				"showBorder": "0",
				"showShadow": "0",				
				"usePlotGradientColor": "0",
				"legendBorderAlpha": "0",
				"legendShadow": "0",
				"showLegend":"0",
				"showLabels":"0",
				"showAxisLines": "1",
				"showAlternateHGridColor": "0",
				"divlineThickness": "1",
				"divLineIsDashed": "0",				
				"divLineDashLen": "1",				
				"divLineGapLen": "1",
				"vDivLineDashed": "0",
				"numVDivLines": "6",
				"vDivLineThickness": "1",
				"xAxisName": "",
				"yAxisName": "",				
				"anchorradius": "3",
				"plotHighlightEffect": "fadeout|color=#f6f5fd, alpha=60",
				"showValues": "0",
				"rotateValues": "0",
				"placeValuesInside": "0",
				"formatNumberScale": "0",
				"decimalSeparator": ",",
				"thousandSeparator": ".",
				"numberPrefix": "",
				"numberSuffix": "jt",
				"ValuePadding": "0",
				"yAxisValuesStep":"1",
				"xAxisValuesStep":"0",
				"yAxisMaxvalue": "10",
				"yAxisMinValue": "0",
				"numDivLines": "5",
				"xAxisNamePadding": "30",
				"showHoverEffect":"1",
				"animation": "1"							
			},
			"data":'.Json::encode($saleData).'
				
		}'; 
		 return json::decode($rsltSrcWeeklySales);;
	}
	public function actionWeeklySalesDays(){
		$searchModel = new FoodtownSearch(['Val_Nm'=>'Total_Grand_Weekly_Month']);
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataModel= $dataProvider->getModels();
		//Array PaletteColors dari component.
		$lineColor = ArrayHelper::toArray(Yii::$app->arrayBantuan->ArrayRowPaletteColors());
		//ambil field Val_Json dengan data format Json. 
		$aryDataModel= $dataModel[0]->Val_Json;
		$fixSpasi= str_replace(' ','',$aryDataModel); 
		$fixKomaDibelakang= str_replace(', }','}',$fixSpasi); 
		$fixValueDigitNolDidepan= str_replace(':0',':',$fixKomaDibelakang); 
		$fixDatatoString1= str_replace('total1:','"total1":',$fixValueDigitNolDidepan); 
		$fixDatatoString2= str_replace('total2:','"total2":',$fixDatatoString1); 
		$fixDatatoString3= str_replace('total3:','"total3":',$fixDatatoString2); 
		$fixDatatoString4= str_replace('total4:','"total4":',$fixDatatoString3); 
		$fixDatatoString5= str_replace('total5:','"total5":',$fixDatatoString4);		
		$fixFormatJson = json_decode($fixDatatoString5); 
		//return $fixFormatJson;
		
		//category
		foreach($fixFormatJson as $row => $value){
			//$ctg[]=["label"=>(string)$value->{'name'}];
			$dataTglKey[]=(string)$value->{'date'};
		}	
		//$bulan =date_format(date($dataTglKey[0]), "m");
		//return $dataTglKey;
		//return $dataTglKey; //$dataTglKey[0];
		
		foreach($fixFormatJson as $row => $value){
			if ((string)$value->{'week'}=='1'){
				$week1[]=["label"=>(string)$value->{'name'},"value"=>(string)$value->{'total1'},"anchorBgColor"=> $lineColor[0]];				
			};
			if ((string)$value->{'week'}=='2'){
				$week2[]=["label"=>(string)$value->{'name'},"value"=>(string)$value->{'total2'},"anchorBgColor"=> $lineColor[1]];				
			};
			if ((string)$value->{'week'}=='3'){
				$week3[]=["label"=>(string)$value->{'name'},"value"=>(string)$value->{'total3'},"anchorBgColor"=> $lineColor[2]];				
			};
			if ((string)$value->{'week'}=='4'){
				$week4[]=["label"=>(string)$value->{'name'},"value"=>(string)$value->{'total4'},"anchorBgColor"=> $lineColor[3]];				
			};
			if ((string)$value->{'week'}=='5'){
				$week5[]=["label"=>(string)$value->{'name'},"value"=>(string)$value->{'total5'},"anchorBgColor"=> $lineColor[4]];				
			};
			
			
		} 		
		//return $Week1;
		
		/**
		 * Maping Chart 
		 * Type : msline
		 * 
		*/
		$rsltSrcWeeklySalesMonth='{
			"chart": {
				"caption": "WEEKLY DATA (DAY)",
				"subCaption": "",
				"captionFontSize": "12",
				"subcaptionFontSize": "10",
				"subcaptionFontBold": "0",
				"paletteColors": '.'"'.Yii::$app->arrayBantuan->ArrayPaletteColors().'"'.',
				"bgcolor": "#ffffff",
				"showBorder": "0",
				"showShadow": "0",				
				"usePlotGradientColor": "0",
				"legendBorderAlpha": "0",
				"legendShadow": "0",
				"showAxisLines": "1",
				"showAlternateHGridColor": "0",
				"divlineThickness": "1",
				"divLineIsDashed": "0",				
				"divLineDashLen": "1",				
				"divLineGapLen": "1",
				"vDivLineDashed": "0",
				"numVDivLines": "11",
				"vDivLineThickness": "1",
				"xAxisName": "week of month",
				"yAxisName": "IDR",				
				"anchorradius": "6",
				"plotHighlightEffect": "fadeout|color=#f6f5fd, alpha=60",
				"showValues": "1",
				"rotateValues": "1",
				"placeValuesInside": "1",
				"formatNumberScale": "0",
				"decimalSeparator": ",",
				"thousandSeparator": ".",
				"numberPrefix": "",
				"numberSuffix": "jt",
				"ValuePadding": "0",
				"yAxisValuesStep":"1",
				"xAxisValuesStep":"0",
				"yAxisMaxvalue": "100",
				"yAxisMinValue": "0",
				"numDivLines": "10",
				"xAxisNamePadding": "30",
				"showHoverEffect":"1",
				"animation": "1",
				"plotFillAngle": "1",
				"plotFillRatio": "0,100",
				"showPlotBorder": "1"		
			},
			"categories": [{
				"category": [
					{
						"label": "Monday"
					},
					{
						"label": "Tuesday"
					},
					{
						"label": "Wednesday"
					},
					{
						"label": "Thursday"
					},
					{
						"label": "Friday"
					},
					{
						"label": "Saturday"
					},
					{
						"label": "Sunday"
					}
				]
			}],
			"dataset": [
				{
					"seriesname": "Week1",
					"data":'.Json::encode($week1).'
				},
				{
					"seriesname": "Week2",
					"data":'.Json::encode($week2).'
				},
				{
					"seriesname": "Week3",
					"data":'.Json::encode($week3).'
				},
				{
					"seriesname": "Week4",
					"data":'.Json::encode($week4).'
				},
				{
					"seriesname": "Week5",
					"data":'.Json::encode($week5).'
				}
			]
		}'; 
		 return json::decode($rsltSrcWeeklySalesMonth); 
		 //return $bulan;
	}
	
	public function actionMember(){
		$searchModel = new FoodtownSearch(['Val_Nm'=>'Top5_Member_Year']);
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataModel= $dataProvider->getModels();
		//Array PaletteColors dari component.
		$lineColor = ArrayHelper::toArray(Yii::$app->arrayBantuan->ArrayRowPaletteColors());
		//ambil field Val_Json dengan data format Json. 
		$aryDataModel= $dataModel[0]->Val_Json;
		$fixSpasi= str_replace(' ','',$aryDataModel); 
		$fixKomaDibelakang= str_replace(', }','}',$fixSpasi); 
		$fixValueDigitNolDidepan= str_replace(':0',':',$fixKomaDibelakang); 
		$fixFormatJson = json_decode($fixValueDigitNolDidepan);
		//return $fixFormatJson;
		
		foreach($fixFormatJson as $row => $value){
			$saleData[]=["label"=>(string)$value->{'nama'},"value"=>str_replace(',','',(string)$value->{'grandtotal'}),"anchorBgColor"=> $lineColor[$row]];	
		} 		 
		//return $saleData;
		
		/**
		 * Maping Chart 
		 * Type : msline
		 * 
		*/
		$rsltSrcMember='{
			"chart": {
				"caption": "TOP 5 Member",
				"subCaption": "Of The Year",
				"captionFontSize": "12",
				"subcaptionFontSize": "10",
				"subcaptionFontBold": "0",
				"paletteColors": '.'"'.Yii::$app->arrayBantuan->ArrayPaletteColors().'"'.',
				"bgcolor": "#ffffff",
				"showBorder": "0",
				"showShadow": "0",				
				"usePlotGradientColor": "0",
				"legendBorderAlpha": "0",
				"legendShadow": "0",
				"showAxisLines": "1",
				"showAlternateHGridColor": "0",
				"divlineThickness": "1",
				"divLineIsDashed": "0",				
				"divLineDashLen": "1",				
				"divLineGapLen": "1",
				"vDivLineDashed": "0",
				"numVDivLines": "10",
				"vDivLineThickness": "1",
				"xAxisName": "Member",
				"yAxisName": "IDR",				
				"anchorradius": "6",
				"plotHighlightEffect": "fadeout|color=#f6f5fd, alpha=60",
				"showValues": "1",
				"rotateValues": "1",
				"placeValuesInside": "1",
				"formatNumberScale": "0",
				"decimalSeparator": ",",
				"thousandSeparator": ".",
				"numberPrefix": "",
				"numberSuffix": "",
				"ValuePadding": "0",
				"yAxisValuesStep":"1",
				"xAxisValuesStep":"0",
				"yAxisMaxvalue": "100",
				"yAxisMinValue": "0",
				"numDivLines": "10",
				"xAxisNamePadding": "30",
				"showHoverEffect":"1",
				"animation": "1",
				"plotFillAngle": "1",
				"plotFillRatio": "0,100",
				"showPlotBorder": "1"		
			},
			"data":'.Json::encode($saleData).'
				
		}'; 
		 return json::decode($rsltSrcMember);
	}
	
	public function actionTenant(){
		$searchModel = new FoodtownSearch(['Val_Nm'=>'Top5_Tenant_Year']);
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataModel= $dataProvider->getModels();
		//Array PaletteColors dari component.
		$lineColor = ArrayHelper::toArray(Yii::$app->arrayBantuan->ArrayRowPaletteColors());
		//ambil field Val_Json dengan data format Json. 
		$aryDataModel= $dataModel[0]->Val_Json;
		$fixSpasi= str_replace(' ','',$aryDataModel); 
		$fixKomaDibelakang= str_replace(', }','}',$fixSpasi); 
		$fixValueDigitNolDidepan= str_replace(':0',':',$fixKomaDibelakang); 
		$fixFormatJson = json_decode($fixValueDigitNolDidepan);
		//return $fixFormatJson;
		
		foreach($fixFormatJson as $row => $value){
			$tenantData[]=["label"=>(string)$value->{'nama'},"value"=>str_replace(',','',(string)$value->{'grandtotal'}),"anchorBgColor"=> $lineColor[$row]];	
		} 		 
		//return $saleData;
		
		/**
		 * Maping Chart 
		 * Type : msline
		 * 
		*/
		$rsltSrcTenant='{
			"chart": {
				"caption": "TOP 5 Tenant",
				"subCaption": "Of The Year",
				"captionFontSize": "12",
				"subcaptionFontSize": "10",
				"subcaptionFontBold": "0",
				"paletteColors": '.'"'.Yii::$app->arrayBantuan->ArrayPaletteColors().'"'.',
				"bgcolor": "#ffffff",
				"showBorder": "0",
				"showShadow": "0",				
				"usePlotGradientColor": "0",
				"legendBorderAlpha": "0",
				"legendShadow": "0",
				"showAxisLines": "1",
				"showAlternateHGridColor": "0",
				"divlineThickness": "1",
				"divLineIsDashed": "0",				
				"divLineDashLen": "1",				
				"divLineGapLen": "1",
				"vDivLineDashed": "0",
				"numVDivLines": "10",
				"vDivLineThickness": "1",
				"xAxisName": "Member",
				"yAxisName": "IDR",				
				"anchorradius": "6",
				"plotHighlightEffect": "fadeout|color=#f6f5fd, alpha=60",
				"showValues": "1",
				"rotateValues": "1",
				"placeValuesInside": "1",
				"formatNumberScale": "0",
				"decimalSeparator": ",",
				"thousandSeparator": ".",
				"numberPrefix": "",
				"numberSuffix": "",
				"ValuePadding": "0",
				"yAxisValuesStep":"1",
				"xAxisValuesStep":"0",
				"yAxisMaxvalue": "100",
				"yAxisMinValue": "0",
				"numDivLines": "10",
				"xAxisNamePadding": "30",
				"showHoverEffect":"1",
				"animation": "1",
				"plotFillAngle": "1",
				"plotFillRatio": "0,100",
				"showPlotBorder": "1"		
			},
			"data":'.Json::encode($tenantData).'
				
		}'; 
		 return json::decode($rsltSrcTenant);
	}
	/**
		 * BASIC JSON UNTU DAPAT DI DECODE
			1. pastikan tidak ada tanda quote di belakang.
			2. patikan tidak ada nilai 0 di depan dalam dua digit. contoh 09 atau 010.
			3. untuk tanggal to string, customize. contoh 2017-01-22 dijadikan string "2017-01-22", penambahan tanda petik depan belakang.
		 * BASIC CHART CONFIGURATION.
			1. Y Value constant (PENENTUAN BATAS ATAS DAN BAWAH, MENDAPATKAN VERTICAL ROWS STABIL 200,600,800)
				"yAxisMaxvalue": "1800000000", 
				"yAxisMinValue": "0",
				"numDivLines": "8"
			2. LABEL VALUE (Menampilkan Nilai dalam Chart).
				"showValues": "0",
				"rotateValues": "0",  //label value vertical/horizontal
				"placeValuesInside": "0",
			3. Type line : Untuk besar kecil buletan.
				"anchorradius": "6",
			4. Effect animate
				"animation": "1"
				"plotHighlightEffect": "fadeout|color=#f6f5fd, alpha=60", //animation harus value 1
				"showHoverEffect":"1"
			5. Number
				"numberPrefix": "", //depan
				"numberSuffix": "jt", //belakang
		 * EXPORT CLIENT SIDE
				"exportEnabled": "1",
				"exportFileName":"FT-SalesYears",
				"exportAtClientSide":"1"
		*/
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
    /**
     * Displays a single Foodtown model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Foodtown model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Foodtown();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->Id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Foodtown model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->Id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Foodtown model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Foodtown model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Foodtown the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Foodtown::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
