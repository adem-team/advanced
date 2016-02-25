<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model lukisongroup\hrd\models\Machine */

$this->title = 'Update Machine: ' . ' ' . $model->TerminalID;
$this->params['breadcrumbs'][] = ['label' => 'Machines', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->TerminalID, 'url' => ['view', 'id' => $model->TerminalID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="machine-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
