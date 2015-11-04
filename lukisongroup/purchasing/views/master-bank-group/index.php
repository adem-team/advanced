<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\master\models\MasterBankGroupsearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Bankgroup';
//$this->params['breadcrumbs'][] = $this->title;
$script = <<<SKRIPT

$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
})

SKRIPT;

$this->registerJs($script);
?>
<div class="master-bankgroup-index">

    <h1><center><?= Html::encode($this->title) ?></center></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
     <?php Pjax::begin(['id'=>'PtlCommentsPjax']); 
    echo $this->render('_search', ['model' => $searchModel]);

    ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
 [
                'label' => 'Bank Group ID',
                'value' => 'BankGroupID'
            ],
            
               [
                'label' => 'BankGroupName',
                'value' => 'BankGroupName'
            ],
            //'Description',
            
            
//            'BankName',
//            'IsActive',
//            'usercrt',
//            'datecrt',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?> 
     <p style="float:right;">
        <?= Html::a('Add', ['create'], ['class' => 'btn btn-success']) ?>
        
        <?php
        
        if(!isset($_GET['typeSearch']) == NULL && !isset($_GET['textsearch']) == NULL)
        {
            echo Html::a('Back', ['index'], ['class' => 'btn btn-primary']);
        }
        
        ?>
    </p>

</div>
