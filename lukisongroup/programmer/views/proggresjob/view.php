<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\widgets\ActiveForm; 
use dosamigos\ckeditor\CKEditor;
//use dosamigos\datepicker\DatePicker;
use dosamigos\datetimepicker\DateTimePicker;
use dosamigos\ckeditor\CKEditorInline;


$this->sideMenu = 'itprogrammer';

//$this->title = $model->proggres_id;
$this->params['breadcrumbs'][] = ['label' => 'Proggresjobs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
  <h1>PROGRESS DETAIL</h1>
       
  <table class="table table-striped">
    <thead>
      <tr>
        <th>User Id</th>
        <th>Modul</th>
        <th>Judul</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><?php echo $GetAll->user_id;?></td>
        <td><?php echo $GetAll->modul;?></td>
        <td><?php echo $GetAll->judul;?></td>
      </tr>
      
    </tbody>
  </table>
</div>

<div class="proggresjob-form">
 
    <?php $form = ActiveForm::begin([
    'method' => 'post',
    'action' => ['/it/proggresjob/detailprogress'],
]);
   ?>

    <?= $form->field($model, 'keterangan_detail')->widget(CKEditor::className(), [
       'value' => 'Please write your comment',
        'options' => ['rows' => 6],
        'preset' => 'basic'
    ]) ?>

    <?= $form->field($model, 'start_data')->widget(
        DateTimePicker::className(), [
        'template' => '{addon}{input}',
        'value'=>'',
        'clientOptions' => [
        'autoclose' => true,
        'format' => 'yyyy-mm-dd'
        ]
     ]);?>
     <?=$form->field($model, 'proggres_id')->hiddenInput() ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'POST', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<div class="container">

  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-striped">
    <tr>
      <th width="14%" scope="col">PROGRESS ID</th>
      <th width="14%" scope="col">CREATED DATE</th>
      <th width="17%" scope="col">KETERANGAN</th>
      <th width="12%" scope="col">PIC</th>
     
     <!-- <th width="19%" scope="col">ACTION</th>-->
    </tr>
    <?php 
foreach ($progressalldetail as $key => $row) 
  {?>


    <tr>
      <td><?php echo $row->progress_id;?></td>
      <td><?php echo $row->created_date;?></td>
      <td><?php echo $row->keterangan;?></td>
      <td><?php echo $row->pic;?></td>
     
     <!-- <td><a href="3"><label class="btn btn-info" >Edit</label></a>  <a href="3"><label class="btn btn-danger" >Delete</label></a></td>-->    </tr>
   <?php } ?>
  </table>
</div>


<!--
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
        </div>-->