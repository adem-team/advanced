<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\master\models\MasterVendorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Vendor';
//$this->params['breadcrumbs'][] = $this->title;
$script = <<<SKRIPT
         function getp()
   {
        var id =$("[name=ID]:checked").val().split('|');
        $('#v').attr('value',id);
        $('#vd').attr('value',id);
        $('#modal').modal('hide')

   }
        
$('#getpo').click( getp );

$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
})

SKRIPT;

$this->registerJs($script);

?>
<div class="master-vendor-index">

    <h1><?= Html::encode($this->title) ?></h1>
      <?php Pjax::begin(['id' => 'PtlCommentsPjax']);?>
    <?php  echo $this->render('searchaccbank', ['model' => $searchModeld]); ?>
   
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
       // 'filterModel' => $searchModel,
        'columns' => [
             [
                    'label'=>'Select',
                    'format'=>'raw',
                    'value'=>function ($data) {
                       return Html::radio('ID', false,['class'=>'p','value'=>$data[ 'VendorID']]);
                       
                    },
             ],
            'VendorID',
            'VendorName',
            'Address',
            'City',
            'Phone',
            'ContactName',
             'ContactPhone',
//             'ContactEmail',
            // 'IsActive',
            // 'UserCrt',
            // 'DateCrt',
            // 'UserUpdate',
            // 'DateUpdate',

            //['class' => 'yii\grid\ActionColumn'],
                            
//              ['class' => 'yii\grid\ActionColumn','template' => "{update}"],
        ],
    ]); 
                               
  Pjax::end(); 
          
    echo  Html::a('Select', NULL, ['class' => 'btn btn-success','id'=>'getpo'])
 
   ?>