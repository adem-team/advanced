<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\master\models\MasterNoFakturPajakHSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master No Faktur Pajak ';
$script = <<<SKRIPT

$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
})

SKRIPT;

$this->registerJs($script);

?>
<div class="master-no-faktur-pajak-h-index">
   
 
    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
    
       <?php Pjax::begin(['id' => 'PtlCommentsPjax']);?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
            [
                'label'=>'ID Faktur Pajak',
                'value'=> 'IDFakturPajakH',
            ],
           
            'PeriodFrom',
            'PeriodTo',
            'NumberFrom',
             'NumberTo',
            // 'DateCrt',
            // 'UserCrt',

//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); 
    ?>
      <?php Pjax::end(); ?>
   
      <p style="float:right;">
    <?php echo Html::a('add', ['create'], ['class' => 'btn btn-success']);?>
    
     <?php
        
        if(!isset($_GET['typeSearch']) == NULL && !isset($_GET['textsearch']) == NULL)
        {
            echo Html::a('Back', ['index'], ['class' => 'btn btn-primary']);
        }
        
        ?>
          </p>

</div>
