<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model lukisongroup\models\hrd\Corp */

$this->title = 'Update Corp: ' . ' ' . $model->CORP_ID;
$this->params['breadcrumbs'][] = ['label' => 'Corps', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->CORP_ID, 'url' => ['view', 'id' => $model->CORP_ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="corp-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
