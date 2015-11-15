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

$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
})

SKRIPT;

$this->registerJs($script);

?>
<div class="master-vendor-index">

    <h1><?= Html::encode($this->title) ?></h1>
      <?php Pjax::begin(['id' => 'PtlCommentsPjax']);?>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
       // 'filterModel' => $searchModel,
//        'pager' => [
//            'firstPageLabel' => 'First',
//            'lastPageLabel' => 'Last',
//        ],
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'VendorID',
            'VendorName',
            'Address',
            'City',
            'Zip',
             'Phone',
             'Fax',
            'ContactName',
             'ContactPhone',
             'ContactEmail',
            // 'IsActive',
            // 'UserCrt',
            // 'DateCrt',
            // 'UserUpdate',
            // 'DateUpdate',

            //['class' => 'yii\grid\ActionColumn'],
              ['class' => 'yii\grid\ActionColumn','template' => "{update}"],
        ],
    ]); ?>
      <?php Pjax::end(); ?>
    <p style="float: right">
        <?= Html::a('Add', ['create'], ['class' => 'btn btn-success']) ?>
      <?php  if(!isset($_GET['typeSearch']) == NULL && !isset($_GET['textsearch']) == NULL)
        {
            echo Html::a('Back', ['index'], ['class' => 'btn btn-primary']);
        } ?>
    </p>
</div>
