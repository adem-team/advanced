<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\master\models\MasterCustomerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Customer';
//$this->params['breadcrumbs'][] = $this->title;

$script = <<<SKRIPT

$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
})

SKRIPT;

$this->registerJs($script);


?>
<div class="master-customer-index">

    <h1><center><?= Html::encode($this->title) ?></center></h1>
   
    <?php Pjax::begin(['id' => 'PtlCommentsPjax']);?>
    <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>
    <? /*= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'CustomerID',
                'value' => 'CustomerID'
            ],
            [
                'label' => 'Parent ID',
                'value' => 'ParentID'
            ],
            [
                'label' => 'Nama',
                'value' => 'Nama'
            ],
            [
                'label' => 'Address',
                'value' => 'Address'
            ],
            [
                'label' => 'City',
                'value' => 'City'
            ],
             [
                'label' => 'Zip',
                'value' => 'Zip'
            ],
             [
                'label' => 'Phone',
                'value' => 'Phone'
            ],
             [
                'label' => 'Fax',
                'value' => 'Fax'
            ],
            [
                'label' => 'Contact Name',
                'value' => 'ContactName'
            ],
             [
                'label' => 'Contact Phone',
                'value' => 'ContactPhone'
            ],
            [
                'label' => 'Contact Email',
                'value' => 'ContactEmail'
            ],
            
             [
             'header' => 'Start-End<br>Absen',
            'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
            'value' => function ($data) {
                return $data->StartAbsen.'-'.$data->EndAbsen; // $data['name'] for array data, e.g. using SqlDataProvider.
            },
        ],
            // 'IsActive',
            // 'usercrt',
            // 'datecrt',
            // 'userUpdate',
            // 'dateUpdate',

            ['class' => 'yii\grid\ActionColumn','template' => "{update}"],
        ],
    ]); */ ?>
    <?php Pjax::end(); ?>
    <p style="float:right;">
        <?= Html::a('Add', ['create'], ['class' => 'btn btn-success']) ?>
      <?php  if(!isset($_GET['typeSearch']) == NULL && !isset($_GET['textsearch']) == NULL)
        {
            echo Html::a('Back', ['index'], ['class' => 'btn btn-primary']);
        } ?>
    </p>
    
</div>
