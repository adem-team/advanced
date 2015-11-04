<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\master\models\MasterGajiPokokSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Gaji Pokok';
//$this->params['breadcrumbs'][] = $this->title;

$script = <<<SKRIPT

$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
})

SKRIPT;

$this->registerJs($script);
?>
<div class="master-gaji-pokok-index">

    <h1><center><?= Html::encode($this->title) ?></center></h1>
    <?php Pjax::begin(['id' => 'PtlCommentsPjax']);?>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
       
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'GapokID',
            ['label'=> 'Seq ID','value'=>'SeqID'],
            ['label'=> 'Job Desc','value'=>'mjdesc'],//iDJobDesc
            ['label'=> 'Area','value'=>'madesc'],//area
            [
                'label'=> 'Amount',
                'value'=>'Amount',
                'format'=>['decimal',2]
            ],
            ['label'=> 'Is Active','value'=>'IsActive'],
            // 'usercrt',
            // 'datecrt',
            [
                    'label'=>'Action',
                    'format' => 'raw',
                    'value'=>function ($data) {
                       return Html::a('Update','./index.php?r=master/master-gaji-pokok/update&ID='.$data['GapokID'].'&seqID='.$data['SeqID']);
                       
                    },
             ],
//                              print_r($dataProvider),
//                    die(),
            //['class' => 'yii\grid\ActionColumn','template' => "{update}"],
        ],
    ]); ?>
    <?php //print_r($dataProvider); die(); ?>
    <?php Pjax::end(); ?>
    
    <p style="float:right;">
        <?= Html::a('Add', ['create'], ['class' => 'btn btn-success']) ?>
      <?php  if(!isset($_GET['typeSearch']) == NULL && !isset($_GET['textsearch']) == NULL)
        {
            echo Html::a('Back', ['index'], ['class' => 'btn btn-primary']);
        } ?>
    </p>
</div>
