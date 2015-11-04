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



<div class="master-tunjanganpotongan-index">
    
    <!--master biaya tunjangan-->
    
    <?php 
    if (Yii::$app->controller->action->id === 'biayatunjangan') {
    ?>
    <?php $this->title = 'Master Biaya Tunjangan'; ?>
    <h1><?= Html::encode($this->title) ?></h1>
    
    <?php echo $this->render('_search', ['model' => $searchModel]); 
        Pjax::begin(['id' =>'PtlCommentsPjax']);?>
   
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'BiayaID',
            'Description',
            //'IsActive',
            //'usercrt',
            //'datecrt',

//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    
    <?php Pjax::end(); ?>
    
    <?php echo Html::a('add', ['tuncreate'], ['class' => 'btn btn-success']);?>
    
    
    
    
    <!--master biaya potongan-->
    
    <?php }
    
    
    else { ?>
    <?php $this->title = 'Master Biaya Potongan'; ?>
    
    <h1><?= Html::encode($this->title) ?></h1>
    
    <?php echo $this->render('_search', ['model' => $searchModel]);
    Pjax::begin(['id' =>'PtlCommentsPjax']);?>

     
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'BiayaID',
            'Description',
            //'IsActive',
            //'usercrt',
            //'datecrt',

//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
    <p style="float:right;">
    <?php 
        echo Html::a('add', ['potcreate'], ['class' => 'btn btn-success']);
    
        if(!isset($_GET['typeSearch']) == NULL && !isset($_GET['textsearch']) == NULL)
        {
            echo Html::a('Back', ['index'], ['class' => 'btn btn-primary']);
        }
        
        ?>
          </p>
    <?php } ?>
</div>

