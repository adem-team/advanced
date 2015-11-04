<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\master\models\MasterTunjanganpotongansearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
//$this->params['breadcrumbs'][] = $this->title;
//print_r(Yii::$app->request->queryParams);
//die();
$script = <<<SKRIPT
        
$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
});

SKRIPT;

$this->registerJs($script);
?>

 <?php  //if (Yii::$app->controller->action->id === 'tunjangan') {
//     $actionview = Html::a('Create Master Tunjangan', ['tuncreate'], ['class' => 'btn btn-success']) ;
//     $title     = $this->title = 'Master Tunjangan';
//    $search =$this->render('_search', ['model' => $searchModel]);
//             
//}
//else{
//     $actionview = Html::a('Create Master potongan', ['potcreate'], ['class' => 'btn btn-success']) ;
//     $title = $this->title = 'Master potongan';
//    $search = $this->render('_search', ['model' => $searchModel]);
//              
//}?>


<div class="master-tunjanganpotongan-index">
    
    <?php 
    if (Yii::$app->controller->action->id === 'tunjangan') {
    ?>
    <?php $this->title = 'Master Tunjangan'; ?>
    <h1><?= Html::encode($this->title) ?></h1>
    
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php Pjax::begin(['id' =>'PtlCommentsPjax']);?>
   
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
//        'pager' => [
//            'firstPageLabel' => 'First',
//            'lastPageLabel' => 'Last',
//        ],
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'ID',
            'Description',
            //'IsActive',
            //'usercrt',
            //'datecrt',

//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
    
    <?php echo Html::a('Create Master Tunjangan', ['tuncreate'], ['class' => 'btn btn-success']);?>
    <?php }
    
    elseif (Yii::$app->controller->action->id === 'asuransi') {
    ?>
    <?php $this->title = 'Master asuransi'; ?>
    <h1><?= Html::encode($this->title) ?></h1>
    
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    
  
    <?php Pjax::begin(['id' =>'PtlCommentsPjax']);?>
   
     
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'ID',
            'Description',
            //'IsActive',
            //'usercrt',
            //'datecrt',

//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
    <?php echo Html::a('Create Master asuransi', ['tuncreate'], ['class' => 'btn btn-success']);?>
    <?php }
    
    else { ?>
    <?php $this->title = 'Master Potongan'; ?>
    
    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php Pjax::begin(['id' =>'PtlCommentsPjax']);?>
    <?php //echo $search;?>
     
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
//        'pager' => [
//            'firstPageLabel' => 'First',
//            'lastPageLabel' => 'Last',
//        ],
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'ID',
            'Description',
            //'IsActive',
            //'usercrt',
            //'datecrt',

//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
    <?php echo Html::a('Create Master potongan', ['potcreate'], ['class' => 'btn btn-success']);?>
    <?php } ?>
</div>
