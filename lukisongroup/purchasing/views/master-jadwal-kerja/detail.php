<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;
//use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use app\eprocess\models\JadwalAbsensiStatusH;
use app\operational\models\SOH;

/* @var $this yii\web\View */
/* @var $searchModel app\operational\models\OfferingHdrSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Edit Absensi';
//$this->params['breadcrumbs'][] = $this->title;

$script = <<<SKRIPT

$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
})

$('#edbutton').click(function(event) {
    event.preventDefault();
    window.open($(this).attr("href"), "popupWindow", "width=1024,height=600,scrollbars=yes,location=no");
});
SKRIPT;

$this->registerJs($script);

?>
<div class="jadwal-kerja-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?php //Pjax::begin(['id' => 'PtlCommentsPjax']);?>
    
    
    
    <?= 
    
        DetailView::widget([
        'model' => $model,
        'attributes' => [
           
            'CustomerID:raw:Customer ID',
            'customer.Nama:raw:Customer Name',
            'AreaID:raw:Area ID',
            'area.Description:raw:Area Name'
        ],
    ]) ?>
    
   <?php 
   
   $modelProdsearch = new app\operational\models\AllocationProductD();
   
   echo $this->render('_searchProd', ['model' => $modelProdsearch]); ?>

    <?php
    
        $query = SOH::find()
                ->select('AD.ProductID,mp.Nama')
                ->from('SOH')
                ->join('JOIN', 'SOD','SOD.SOIDH = SOH.SOIDH')
                ->join('JOIN','AllocationProductH AH','AH.SOIDH = SOD.SOIDH')
                ->join('JOIN','AllocationProductD AD','AD.AllocationProductIDH = AH.AllocationProductIDH')
                ->join('JOIN','MasterProduct mp','mp.ProductID = AD.ProductID')
                ->where("SOH.CustomerID = '".$_GET['cusID']."' and SOD.AreaID = '".$_GET['areaID']."'")
                ->orderBy('AD.ProductID');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false
        ]);
//        
//        print_r($dataProvider);
//        die();
    
//        $sp = "exec [dbo].[sp_getAllocationProduct] @customerid =".$_GET['cusID'].", @areaid = ".$_GET['areaID'];
//        
//        $dataProvider = new yii\data\SqlDataProvider([
//            'sql' => $sp,
//            'sort' => false,
//            'pagination' => [
//                'pageSize' => 3,
//            ],
//            
//        ]);
    
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            [
               'class' => 'yii\grid\CheckboxColumn',
               
            ],
            [
                'label'=>'Product ID',
                'value'=>'ProductID'
            ],
            [
                'label'=>'Product Name',
                'value'=>'Nama'
            ],
            [
                'label'=>'Action',
                'format' => 'raw',
                'value' => function($data){
                   //return Html::a('Edit','./index.php?r=master/master-jadwal-kerja/product&pid='.$data['ProductID'].'&idh='.$data['IDJadwalAbsensiStatusH'],['id'=>'edbutton']);
                 
                },
//                'method' => 'post',
            ],
            //
        ],
    ]); ?>
    
    
</div>
