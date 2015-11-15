<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\master\models\MasterPegawaiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Pegawai';
//$this->params['breadcrumbs'][] = $this->title;

$script = <<<SKRIPT

$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
})

SKRIPT;

$this->registerJs($script);

?>
<div class="master-pegawai-index">

    <h1><center><?= Html::encode($this->title) ?></center></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php Pjax::begin(['id' => 'PtlCommentsPjax']);?>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'pager' => [
//            'firstPageLabel' => 'First',
//            'lastPageLabel' => 'Last',
//        ],
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label'=>'NIK',
                'value'=>'NIK'
            ],
            [
                'label'=>'Nama',
                'value'=>'Nama'
            ],
            [
                'label'=>'Job Desc',
                'value'=>'iDJobDesc.Description'
            ],
            [
                'label'=>'Gender',
                'value'=>'gender'
            ],
            [
                'label'=>'Status Pernikahan',
                'value'=>'iDStatusNikah.Description'
            ],
            [
                'label'=>'Address',
                'value'=>'address'
            ],
            [
                'label'=>'City',
                'value'=>'city'
            ],
            [
                'label'=>'Zip',
                'value'=>'zip'
            ],
            [
                'label'=>'Phone',
                'value'=>'phone'
            ],
            [
                'label'=>'Mobile 1',
                'value'=>'mobile1'
            ],
            [
                'label'=>'Mobile 2',
                'value'=>'mobile2'
            ],
            [
                'label'=>'Bank',
                'value'=>'bank.BankName'
            ],
            [
                'label'=>'Bank Account Number',
                'value'=>'BankAccNumber'
            ],
            [
                'label'=>'NPWP',
                'value'=>'NPWP'
            ],
            [
                'label'=>'Is Active',
                'value'=>'IsActive' 
            ],
            // 'usercrt',
            // 'datecrt',
            // 'userUpdate',
            // 'dateUpdate',

            ['class' => 'yii\grid\ActionColumn', 'template' => '{update}'],
        ],
    ]); ?>
    
    <?php Pjax::end(); ?>
    <p style="float:right;">
        <?= Html::a('Add', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

</div>
