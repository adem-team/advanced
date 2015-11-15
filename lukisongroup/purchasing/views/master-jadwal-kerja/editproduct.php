<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;
//use yii\widgets\Pjax;
//use yii\widgets\ActiveForm;
//use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
//use app\eprocess\models\JadwalAbsensiStatusH;
use app\master\models\MasterProduct;

/* @var $this yii\web\View */
/* @var $searchModel app\operational\models\OfferingHdrSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Edit Product Absensi';
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
           
            'ProductID:raw:Product ID',
            'Nama:raw:Product Name',
//            'AreaID:raw:Area ID',
//            'area.Description:raw:Area Name'
        ],
    ]) ?>
 
    <?php
    
    $query = app\master\models\MasterJadwalKerja::find()
            ->where("ProductID = '".$_GET['pid']."'")
            ->orderBy(['Tgl'=>SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false
        ]);
    
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
           
            [
                'label'=>'Tgl',
                'value'=> function($data)
                {
                    $totime = strtotime($data['Tgl']);
                    $newdate = date('d',$totime);
                    return $newdate;
                }
            ],
            [
                'label'=>'Status',
                'value'=>'Status'
            ],
            [
                'label'=>'Jam Masuk',
                'value'=>'JadwalMasuk'
            ],
            [
                'label'=>'Jam Keluar',
                'value'=>'JadwalKeluar'
            ],
            [
                'label'=>'Action',
                'format' => 'raw',
                'value' => function($data){
                   //return Html::a('Edit','./index.php?r=master/master-jadwal-kerja/edit&pid='.$data['ProductID'].'&idh='.$data['IDJadwalAbsensiStatusH'],['id'=>'edbutton']);
                 
                },
//                'method' => 'post',
            ],
            //
        ],
    ]); ?>
    
    
</div>
