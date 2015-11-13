<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\master\models\MasterjadwalkerjaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Absensi';
//$this->params['breadcrumbs'][] = $this->title;
$script = <<<SKRIPT

$("#close").click(function(){
        var keys = $('#w0').yiiGridView('getSelectedRows');
        alert(keys);
});

$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
})
        
$("#year").change(function () {
    var selectedYear = $(this).val()
    //var text = $(this).find('option:selected').text(); //find the selected option inside the current select
    alert("You have selected the year of  " + selectedYear);
});   
SKRIPT;

$this->registerJs($script);
?>
<div class="masterjadwalkerja-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php Pjax::begin(['id' => 'PtlCommentsPjax']);?>`
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            [
               'class' => 'yii\grid\CheckboxColumn',
               'checkboxOptions' => function ($model, $key, $index, $column) {
                    return ['value' => $model->CustomerID];
                }
            ],
            [
                'label'=>'Customer ID',
                'value'=>'CustomerID'
            ],
            [
                'label'=>'Customer Name',
                'value'=>'customer.Nama'
            ],
            [
                'label'=>'Area ID',
                'value'=>'AreaID'
            ],
            [
                'label'=>'Area Name',
                'value'=>'area.Description'
            ],
            [
                'label'=>'Action',
                'format' => 'raw',
                'value' => function($data){
//                   print_r($data);
//                   die();
                   
                    return Html::a('Edit','./index.php?r=master/master-jadwal-kerja/dtl&id='.$data['IDJadwalAbsensiStatusH'].'&areaID='.$data['AreaID'].'&cusID='.$data['CustomerID']);
                }
            ]
            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    
   
     <?php Pjax::end(); ?> 
    <p style="float:left;">
        <?= Html::button('Close Selection',['class' => 'btn btn-success','id'=>'close']) ?>
    </p>
    <p style="float:right;">
        <?= Html::a('Upload File', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
</div>
