<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model lukisongroup\models\hrd\Regulasi */

$this->title = $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Regulasis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="regulasi-view">

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
    
    <?php
	$sts = $model->STATUS;
	if($sts == 1){
		$stat = 'Aktif';
	} else {
		$stat = 'Tidak Aktif';
	}
?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'ID',
            'RGTR_TITEL',
            'TGL',
            'RGTR_ISI:ntext',
            'RGTR_DCRPT:ntext',
            'SET_ACTIVE',
            'CORP_ID',
            'DEP_ID',
            'DEP_SUB_ID',
            'GF_ID',
            'SEQ_ID',
            'JOBGRADE_ID',
            'CREATED_BY',
            'UPDATED_BY',
            'UPDATED_TIME',
            [
				'label' => 'Status',
				'value' => $stat,
			],
        ],
    ]) ?>

</div>
