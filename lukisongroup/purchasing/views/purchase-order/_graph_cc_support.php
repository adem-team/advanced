<?php
use kartik\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\ActiveForm;
use kartik\tabs\TabsX;
use yii\helpers\Json;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\data\ArrayDataProvider;
use yii\db\Query;

?>

<?php
	$provider= new ArrayDataProvider([
	'allModels'=>Yii::$app->db_esm->createCommand("CALL PURCHASING_report_cc('CC_SUPPORT','CORP')")->queryAll(),
	 'pagination' => [
		'pageSize' => 1000,
		]
	]);
	$dataJson=(Json::encode($provider->getModels()));
	$dataJsonSupportDept='data:'.$dataJson;
	//print_r($dataJsonSupportDept);
	//print_r(Json::encode($provider->getModels()));
	//print_r($provider);
?>




<div id="column2d-cc-support"></div>

<?php
	$this->registerJs("
		FusionCharts.ready(function () {
		var myChart = new FusionCharts({
			type: 'column2d',
			width: '100%',
			//height: '100%',			
			renderAt: 'column2d-cc-support',
			dataFormat: 'json',
			dataSource: {
				chart: {
					caption: 'COST CENTER SUPPORT',
					//subCaption: 'Top 5 stores in last month by revenue',
					//subcaption: 'Yearly Actual Total Stock sell-out',
					subcaptionFontBold: '0',
					subcaptionFontSize: '14',
					//numberPrefix: 'IDR ',
					//yaxismaxvalue: '9000000',
					numberscalevalue:'1000,1000,1000',
					numberscaleunit:'R,Jt,M',
					borderAlpha: '0',
					bgColor: '#ffffff',
					usePlotGradientColor: '0',
					plotBorderAlpha: '10', 
					showAlternateHGridColor: '0',
					showXAxisLine: '1'						
				},
				$dataJsonSupportDept
				/* data:[{
					label: 'Bakersfield Central',
					value: '880000'
				},
				{
					label: 'Garden Groove harbour',
					value: '730000'
				},
				{
					label: 'Los Angeles Topanga',
					value: '590000'
				},
				{
					label: 'Compton-Rancho Dom',
					value: '520000'
				},
				{
					label: 'Daly City Serramonte',
					value: '330000'
				}] */
			}
		});
		// Render the chart.
		myChart.render();
	});
",$this::POS_READY);
?>