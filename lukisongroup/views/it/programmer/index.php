<?php
/*
 * By ptr.nov
 * Load Config CSS/JS
 */
/* YII CLASS */
//use yii\helpers\Html;
use dosamigos\chartjs\ChartJs;
use yii\web\View;
use kartik\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;

/* TABLE CLASS DEVELOPE -> |DROPDOWN,PRIMARYKEY-> ATTRIBUTE */
use app\models\hrd\Dept;
/*	KARTIK WIDGET -> Penambahan componen dari yii2 dan nampak lebih cantik*/
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\tabs\TabsX;
use kartik\date\DatePicker;
use kartik\builder\Form;


//use miloschuman\highcharts\Highcharts;
//use yii\web\JsExpression;
//CLASS Chart GoogleChart
use scotthuangzl\googlechart\GoogleChart;
//use dosamigos\chartjs\Chart;  //Author Composer 2amigos yii2-chartjs-widget

use backend\assets\AppAsset; 	/* CLASS ASSET CSS/JS/THEME Author: -ptr.nov-*/
AppAsset::register($this);		/* INDEPENDENT CSS/JS/THEME FOR PAGE  Author: -ptr.nov-*/
$this->sideMenu = 'itprogrammer';
$this->title = Yii::t('app', 'Programmer Dashboard ');
$this->params['breadcrumbs'][] = $this->title;

echo Html::panel(
    ['heading' => Html::encode($this->title) ],
    Html::TYPE_DANGER
);
                /*
                $pertama=ChartJs::widget([
                    'type' => 'Line',
                    'options' => [
                        'canvas'=>['id'=>'canvas-holder',
                            'class'=> 'col-md-2'
                            //'height'=> 'auto',
                        ]
                    ],
                    'data' => [
                        'labels' => ["January", "February", "March", "April", "May", "June", "July"],
                        'datasets' => [
                            [
                                'fillColor' => "rgba(220,220,220,0.5)",
                                'strokeColor' => "rgba(220,220,220,1)",
                                'pointColor' => "rgba(220,220,220,1)",
                                'pointStrokeColor' => "#fff",
                                'data' => [65, 59, 90, 81, 56, 55, 40]
                            ],
                            [
                                'fillColor' => "rgba(151,187,205,0.5)",
                                'strokeColor' => "rgba(151,187,205,1)",
                                'pointColor' => "rgba(151,187,205,1)",
                                'pointStrokeColor' => "#fff",
                                'data' => [28, 48, 40, 19, 96, 27, 100]
                            ]
                        ]
                    ]
                ]);
                $kedua=ChartJs::widget([
                    'type' => 'Pie',
                    'options' => [
                        'canvas'=>['id'=>'canvas-holder half',
                            'class'=> 'col-md-3'
                            //'height'=> 'auto',
                        ]
                    ],
                    'data' => [
                        [
                            'value'=>300,
                            'color'=>'#F7464A',
                            'highlight'=>'#FF5A5E',
                            'label'=>'Red'
                        ],
                        [
                            'value'=> 50,
                            'color'=>'#46BFBD',
                            'highlight'=>'#5AD3D1',
                            'label'=>'Green'
                        ],
                        [
                            'value'=>100,
                            'color'=>'#FDB45C',
                            'highlight'=>'#FFC870',
                            'label'=>'Yellow'
                        ]
                    ]

                ]);
                */
				$pertama= GoogleChart::widget(array('visualization' => 'PieChart',
					'data' => array(
						array('Task', 'Hours per Day'),
						array('Work', 11),
						array('Eat', 2),
						array('Commute', 2),
						array('Watch TV', 2),
						array('Sleep', 7)
					),
                    //'options' => array('class'=>'col-xs-2  col-lg-2')
                    //'options' => array('title' => 'Employee Properties')
                ));


				$kedua= GoogleChart::widget(array('visualization' => 'PieChart',
					'data' => array(
						array('Task', 'Hours per Day'),
						array('Work', 11),
						array('Eat', 2),
						array('Commute', 2),
						array('Watch TV1', 2),
						array('Sleep1', 7)
					),
				//'options' => array('class'=>'col-xs-2 col-sm-2 col-md-2 col-lg-2')
                ));





			?>

<?php
echo GoogleChart::widget(array('visualization' => 'LineChart',
    'data' => array(
        array('Task', 'Hours per Day'),
        array('Work', 11),
        array('Eat', 2),
        array('Commute', 2),
        array('Watch TV', 2),
        array('Sleep', 7)
    ),
    'options' => array('title' => 'My Daily Activity')));
echo GoogleChart::widget(array('visualization' => 'LineChart',
    'data' => array(
        array('Year', 'Sales', 'Expenses'),
        array('2004', 1000, 400),
        array('2005', 1170, 460),
        array('2006', 660, 1120),
        array('2007', 1030, 540),
    ),
    'options' => array(
        'title' => 'My Company Performance2',
        'titleTextStyle' => array('color' => '#FF0000'),
        'vAxis' => array(
            'title' => 'Scott vAxis',
            'gridlines' => array(
                'color' => 'transparent'  //set grid line transparent
            )),
        'hAxis' => array('title' => 'Scott hAixs'),
        'curveType' => 'function', //smooth curve or not
        'legend' => array('position' => 'bottom'),
    )));

echo GoogleChart::widget( array('visualization' => 'Gauge', 'packages' => 'gauge',
    'data' => array(
        array('Label', 'Value'),
        array('Memory', 80),
        array('CPU', 55),
        array('Network', 68),
    ),
    'options' => array(
        'width' => 400,
        'height' => 120,
        'redFrom' => 90,
        'redTo' => 100,
        'yellowFrom' => 75,
        'yellowTo' => 90,
        'minorTicks' => 5
    )
));

echo GoogleChart::widget( array('visualization' => 'Map',
    'packages'=>'map',//default is corechart
    //'loadVersion'=>1.1,//default is 1.  As for Calendar, you need change to 1.1
    'data' => array(
        ['Country', 'Population'],
        ['China', 'China: 1,363,800,000'],
        ['India', 'India: 1,242,620,000'],
        ['US', 'US: 317,842,000'],
        ['Indonesia', 'Indonesia: 247,424,598'],
        ['Brazil', 'Brazil: 201,032,714'],
        ['Pakistan', 'Pakistan: 186,134,000'],
        ['Nigeria', 'Nigeria: 173,615,000'],
        ['Bangladesh', 'Bangladesh: 152,518,015'],
        ['Russia', 'Russia: 146,019,512'],
        ['Japan', 'Japan: 127,120,000']
    ),
    'options' => array('title' => 'My Daily Activity',
        'showTip'=>true,
    )));
?>
















<div class="body-content">
    <div class="row" style="padding-left: 5px; padding-right: 5px">

        <div class="col-lg-4">
            <?php
            echo Html::panel(
                ['heading' => 'Employee Status','body' => $pertama],
                Html::TYPE_SUCCESS


            );

            ?>
        </div>
        <div class="col-lg-3">
            <?php
            echo Html::panel(
                ['heading' => 'Employee Properties', 'body' =>$kedua],
                Html::TYPE_SUCCESS
            );
            ?>
        </div>

    </div>
</div>