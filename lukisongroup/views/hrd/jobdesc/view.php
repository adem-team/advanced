<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model lukisongroup\models\hrd\Jobdesc */

//$this->title = $model->ID;
//$this->params['breadcrumbs'][] = ['label' => 'Jobdescs', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<!--<div class="jobdesc-view">-->
  <div class="row"> 
        <div class="col-md-8" style="margin:10px;"> 
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
       
        <?= Html::a('Delete', ['delete', 'id' => $model->ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ID',
            'JOBSDESK_TITLE',
            'JOBGRADE_NM',
            'JOBGRADE_DCRP:ntext',
            'JOBGRADE_STS',
            'JOBSDESK_IMG',
            'JOBSDESK_PATH',
            'SORT',
            'CORP_ID',
            'DEP_ID',
            'DEP_SUB_ID',
            'GF_ID',
            'SEQ_ID',
            'JOBGRADE_ID',
            'CREATED_BY',
            'UPDATED_BY',
            'UPDATED_TIME',
            'STATUS',
        ],
    ]) ?>

</div>
  </div>
