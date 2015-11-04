<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax; 

/* @var $this yii\web\View */
/* @var $searchModel app\master\models\MasterCalonProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Calon Product';
//$this->params['breadcrumbs'][] = $this->title;
$script = <<<SKRIPT

$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
})

SKRIPT;

$this->registerJs($script);

?>
<div class="master-calon-product-index">

    <h1><?= Html::encode($this->title) ?></h1>
  
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
        <?php Pjax::begin(['id' => 'PtlCommentsPjax']);?>
   

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

          
             [
                'label'=>  'CalonProduct',
                'value'=>'CalonProductID',
              
            ],
            [
                'label'=> 'Nama Product',
                'value'=> 'Nama',
              
            ],
           [
                'label'=> 'JobDesc',
                'value'=> 'IDJobDesc',
              
            ],
           
            'Gender',
            'KTP',
            [
                'label'=>'KTP Expire Date',
                'value'=>'KTPExpireddate',
                 'format'=>['DateTime','php:d-m-Y']
            ],
              [
                'label'=>  'SIM',
                'value'=>  'SIM',
              
            ],
            
            [
               'label'=>'SIM Expired Date',
                'value'=>'SIMExpireDate',
                 'format'=>['DateTime','php:d-m-Y'] 
            ],
           
              [
                'label'=>  'StatusNikah',
                'value'=>  'IDstatusnikah',
              
            ],
             'Address',
             'RefferensiDesc',
             'City',
             'Zip',
             'Phone',
             'Mobile1',
             'Mobile2',
              [
                'label'=>   'Bank',
                'value'=>  'BankID',
              
            ],
            
             'BankAccNumber',
             'NPWP',
             [                
                'class' => 'yii\grid\ActionColumn',
                'template' => "{update}",
//                 'label'=>'Atribute',
            ],
//             'IsActive',
//             'status',
//             'usercrt',
//             'datecrt',
//            

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
  <?php Pjax::end(); ?>
    <p style="float:right;">
        <?= Html::a('Add', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

</div>
