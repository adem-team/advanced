<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use common\components\MenuWidget;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProggresjobSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->sideMenu = 'itprogrammer';
$this->title = 'Proggresjobs';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="proggresjob-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Proggresjob', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

<?php 

    $gridColumns = [
        ['class' => 'yii\grid\SerialColumn'],

            'proggres_id',
            'user_id',
            'modul',
            [
            'class' => 'kartik\grid\EditableColumn',
            'header' => 'Judul',
            'attribute'=>'judul',
            'readonly'=>function($model, $key, $index, $widget) {
            return (!$model->judul); // do not allow editing of inactive records
        },

            ],
            'keterangan',
            
        ['class' => 'yii\grid\ActionColumn'],
    ];
   echo  GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns,
         'pjax'=>true,
        'panel' => [
            'heading'=>'<h3 class="panel-title">'. Html::encode($this->title).'</h3>',
            'type'=>'primary',
            'showFooter'=>false,
        ],  
    ]); ?>
</div>
           