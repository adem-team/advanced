<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Proggresjobdetail */

$this->title = 'Update Proggresjobdetail: ' . ' ' . $model->proggresjobdetail_id;
$this->params['breadcrumbs'][] = ['label' => 'Proggresjobdetails', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->proggresjobdetail_id, 'url' => ['view', 'id' => $model->proggresjobdetail_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="proggresjobdetail-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
