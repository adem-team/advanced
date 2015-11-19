<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model lukisongroup\models\hrd\Jobdesc */

$this->title = 'Update Jobdesc: ' . ' ' . $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Jobdescs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="jobdesc-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
