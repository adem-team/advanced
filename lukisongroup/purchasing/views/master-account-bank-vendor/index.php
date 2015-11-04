<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\master\models\MasterAccountBankVendorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Account Bank Vendor';
//$this->params['breadcrumbs'][] = $this->title;
$script = <<<SKRIPT

$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
})

SKRIPT;

$this->registerJs($script);
?>
<div class="master-account-bank-vendor-index">

    <h1><?= Html::encode($this->title) ?></h1>
     <?php Pjax::begin(['id'=>'PtlCommentsPjax'])?>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

   
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
        [
            'label'=>'Vendor ID',
            'value'=>'VendorID',
            ],
         
            'BankName',
            'AccountNo',
        ],
    ]); ?>
     <?php Pjax::end(); ?> 
    <p style="float: right">
        <?= Html::a('add', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    
</div>
