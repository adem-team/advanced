<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\master\models\MasterItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Item';
//$this->params['breadcrumbs'][] = $this->title;
$script = <<<SKRIPT

$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
})

SKRIPT;

$this->registerJs($script);
?>
<div class="master-item-index">

    <h1><?= Html::encode($this->title) ?></h1>
      <?php Pjax::begin(['id' => 'PtlCommentsPjax']);?>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

  
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
[
    'label'=>'Item ID',
    'value'=> 'ItemID',
],
         
            'ItemDescription',
//            'IsActive',
//            'UserCrt',
//            'DateCrt',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
        <?php Pjax::end(); ?>
    <p style="float: right">
        <?= Html::a('add', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

</div>
