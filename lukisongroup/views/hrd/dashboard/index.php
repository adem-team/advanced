<?php
/*
 * By ptr.nov
 * Load Config CSS/JS
 */
/* YII CLASS */
use yii\helpers\Html;
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
//use dosamigos\chartjs\Chart;
//use miloschuman\highcharts\Highcharts;
//use yii\web\JsExpression;

use backend\assets\AppAsset; 	/* CLASS ASSET CSS/JS/THEME Author: -ptr.nov-*/
AppAsset::register($this);		/* INDEPENDENT CSS/JS/THEME FOR PAGE  Author: -ptr.nov-*/

/*Title page Modul*/
$this->sideMenu = 'hrd';
$this->title = Yii::t('app', 'Dashboard');
$this->params['breadcrumbs'][] = $this->title;

use miloschuman\highcharts\Highcharts;

echo Highcharts::widget([
    'options' => [
        'title' => ['text' => 'Fruit Consumption'],
        'xAxis' => [
            'categories' => ['Apples', 'Bananas', 'Oranges']
        ],
        'yAxis' => [
            'title' => ['text' => 'Fruit eaten']
        ],
        'series' => [
            ['name' => 'Jane', 'data' => [1, 0, 4]],
            ['name' => 'John', 'data' => [5, 7, 3]]
        ]
    ]
]);
use miloschuman\highcharts\Highstock;
use yii\web\JsExpression;

$this->registerJs('$.getJSON("//www.highcharts.com/samples/data/jsonp.php?filename=aapl-c.json&callback=?", myCallbackFunction);');

echo Highstock::widget([
    // The highcharts initialization statement will be wrapped in a function
    // named 'mycallbackFunction' with one parameter: data.
    'callback' => 'myCallbackFunction',
    'options' => [
        'rangeSelector' => [
            'inputEnabled' => new JsExpression('$("#container").width() > 480'),
            'selected' => 1
        ],
        'title' => [
            'text' => 'AAPL Stock Price'
        ],
        'series' => [
            [
                'name' => 'AAPL Stock Price',
                'data' => new JsExpression('data'), // Here we use the callback parameter, data
                'type' => 'areaspline',
                'threshold' => null,
                'tooltip' => [
                    'valueDecimals' => 2
                ],
                'fillColor' => [
                    'linearGradient' => [
                        'x1' => 0,
                        'y1' => 0,
                        'x2' => 0,
                        'y2' => 1
                    ],
                    'stops' => [
                        [0, new JsExpression('Highcharts.getOptions().colors[0]')],
                        [1, new JsExpression('Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get("rgba")')]
                    ]
                ]
            ]
        ]
    ]
]);
use miloschuman\highcharts\Highmaps;
//use yii\web\JsExpression;


// To use Highcharts Map Collection, we must register those files separately.
// The 'depends' option ensures that the main Highmaps script gets loaded first.
$this->registerJsFile('http://code.highcharts.com/mapdata/countries/de/de-all.js', [
    'depends' => 'miloschuman\highcharts\HighchartsAsset'
]);

echo Highmaps::widget([
    'options' => [
        'title' => [
            'text' => 'Highmaps basic demo',
        ],
        'mapNavigation' => [
            'enabled' => true,
            'buttonOptions' => [
                'verticalAlign' => 'bottom',
            ]
        ],
        'colorAxis' => [
            'min' => 0,
        ],
        'series' => [
            [
                'data' => [
                    ['hc-key' => 'de-ni', 'value' => 0],
                    ['hc-key' => 'de-hb', 'value' => 1],
                    ['hc-key' => 'de-sh', 'value' => 2],
                    ['hc-key' => 'de-be', 'value' => 3],
                    ['hc-key' => 'de-mv', 'value' => 4],
                    ['hc-key' => 'de-hh', 'value' => 5],
                    ['hc-key' => 'de-rp', 'value' => 6],
                    ['hc-key' => 'de-sl', 'value' => 7],
                    ['hc-key' => 'de-by', 'value' => 8],
                    ['hc-key' => 'de-th', 'value' => 9],
                    ['hc-key' => 'de-st', 'value' => 10],
                    ['hc-key' => 'de-sn', 'value' => 11],
                    ['hc-key' => 'de-br', 'value' => 12],
                    ['hc-key' => 'de-nw', 'value' => 13],
                    ['hc-key' => 'de-bw', 'value' => 14],
                    ['hc-key' => 'de-he', 'value' => 15],
                ],
                'mapData' => new JsExpression('Highcharts.maps["countries/de/de-all"]'),
                'joinBy' => 'hc-key',
                'name' => 'Random data',
                'states' => [
                    'hover' => [
                        'color' => '#BADA55',
                    ]
                ],
                'dataLabels' => [
                    'enabled' => true,
                    'format' => '{point.name}',
                ]
            ]
        ]
    ]
]);

use dosamigos\chartjs\ChartJs;

?>


<?

 $coba = ChartJs::widget([
    'type' => 'Pie',
    //'options' => [
    //    'height' => 400,
    //    'width' => 400
    //],
    'data' => [
    [
        'value'=> '300',
        'color'=> '#F7464A',
        'highlight'=> '#FF5A5E',
        'label'=> 'Red'
    ],
    [
        'value'=> '50',
        'color'=> '#46BFBD',
        'highlight'=> '#5AD3D1',
        'label'=> 'Green'
    ],
    [
        'value'=> '100',
        'color'=> 'FDB45C',
        'highlight'=> '#FFC870',
        'label'=> 'Yellow'
    ]
]
]);

?>
<div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
            <span class="info-box-icon bg-aqua">
                <i class="ion ion-ios-gear-outline">
                <?=ChartJs::widget([
                    'type' => 'Pie',
                    'options' => [
                        'height' =>70,
                        'width' => 70
                    ],
                    'data' => [
                        [
                            'value'=> '300',
                            'color'=> '#F7464A',
                            'highlight'=> '#FF5A5E',
                            'label'=> 'Red'
                        ],
                        [
                            'value'=> '50',
                            'color'=> '#46BFBD',
                            'highlight'=> '#5AD3D1',
                            'label'=> 'Green'
                        ],
                        [
                            'value'=> '100',
                            'color'=> 'FDB45C',
                            'highlight'=> '#FFC870',
                            'label'=> 'Yellow'
                        ]
                    ]
                ]);
                   // echo $coba;
                ?>
                </i>
            </span>
        <div class="info-box-content">
            <span class="info-box-text"> Employe Count</span>
        </div>
    </div>
    <div class="info-box">
            <span class="info-box-icon bg-aqua">
                <i class="ion ion-ios-gear-outline">

                </i>
            </span>
        <div class="info-box-content">
            <span class="info-box-text"> Employe Count</span>
        </div>
    </div>
</div>
<div class="col-sm-5">
    <?php
    use scotthuangzl\googlechart\GoogleChart;

    echo GoogleChart::widget(array('visualization' => 'PieChart',
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
        'loadVersion'=>1,//default is 1.  As for Calendar, you need change to 1.1
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
</div>
<html>
<head>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
        google.load("visualization", "1", {packages:["orgchart"]});
        google.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Name');
            data.addColumn('string', 'Manager');
            data.addColumn('string', 'ToolTip');

            data.addRows([
                [{v:'Mike', f:'Mike<div style="color:red; font-style:italic">President</div>'}, '', 'The President'],
                [{v:'Jim', f:'Jim<div style="color:red; font-style:italic">Vice President</div>'}, 'Mike', 'VP'],
                ['Alice', 'Mike', ''],
                ['Bob', 'Jim', 'Bob Sponge'],
                ['Carol', 'Bob', '']
            ]);

            var chart = new google.visualization.OrgChart(document.getElementById('chart_div'));
            chart.draw(data, {allowHtml:true});
        }
    </script>
</head>
<body>
<div id="chart_div"></div>
</body>
</html>