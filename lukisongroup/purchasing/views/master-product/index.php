<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\master\models\MasterProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Product';
//$this->params['breadcrumbs'][] = $this->title;
$script = <<<SKRIPT

$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
})

SKRIPT;

$this->registerJs($script);
?>
<div class="masterproduct-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

   
     <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php Pjax::begin(['id' => 'PtlCommentsPjax']);?>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'pager' => [
//            'firstPageLabel' => 'First',
//            'lastPageLabel' => 'Last',
//        ],
        //'filterModel' => $searchModel,
//        print_r($dataProvider),
//                    die(),
            
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

           
             [
                'label'=>'Product',
                'value'=>'ProductID',
             
            ],
               [
                'label'=>'NIK',
                'value'=>'NIK',
             
            ],
           
              [
//                 'options' => ['style' => 'max-width:2000px;'],
//                'header'=>'<span style:width:2000px;>Nama</span>', 
                 'header'=>'Nama Product',
                 'value' => 'Nama',
                  'contentOptions'=>['style'=>'max-width: 1000px;'] 
                
          
//                  'headerHtmlOptions'=>['style'=>'width: 150px'],
//                 'label' => 'Nama',
//                  'contentOptions' => ['style' => 'width:200px;'],
//                    'value'=>'Nama',
             
                 
	           
                 
            ],
          
             [
                'label'=>'JobDesc',
                'value'=>'MJDesc',
//              'value'=>'IDJobDesc',
            ],
           
            'Gender',
           
              [
                'label'=>'KTP',
                'value'=>'KTP',
//                 'value'=>'IDJobDesc',
            ],
            [
                'label'=>'KTP Expired Date',
                'value'=> 'KTPExpiredDate',
                'format'=>['DateTime','php:d-m-Y'],
            ],
            // 'KTPExpireddate',
          
              
              [
                'label'=>'SIM',
                'value'=>'SIM',
//                 'value'=>'IDJobDesc',
            ],
            [
                 'label'=>'SIM Expired Date',
                'value'=> 'SIMExpiredDate',
                'format'=>['DateTime','php:d-m-Y'],
            ],
            // 'simexpireddate',
            
            [
                'label'=>'StatusNikah',
                'value'=>'MSD',
//                'value'=>'IDStatusNikah',
            ],
             'Address',
             'City',
             'Zip',
             'Phone',
             'Mobile1',
             'Mobile2',
              [
                'label'=>'Bank Name',
                'value'=>'BankName',
            ],
             'BankAccNumber',
              [
                'label'=>'NPWP',
                'value'=>'NPWP',
//                'value'=>'IDStatusNikah',
            ],
              
//             'IsActive',
            
              [
                'label'=>'Satus Product',
                'value'=> 'Status',
//                'value'=>'ClassID',
            ],
            [
                'label'=>'Class',
                'value'=>'ClassDesc',
//                'value'=>'ClassID',
            ],
//             'usercrt',
//             'datecrt',
//             'userUpdate',
//             'dateUpdate',

            ['class' => 'yii\grid\ActionColumn',
                 'template' => "{update}",],
        ],
    ]); ?>
     <?php // print_r($dataProvider); die(); ?>
  <?php Pjax::end(); ?>
    <p style="float:right;">
        <?= Html::a('Add', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
</div>
