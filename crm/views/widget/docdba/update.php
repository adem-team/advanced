<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model lukisongroup\models\widget\doc\Docdba */

$this->title = 'Update Docdba: ' . ' ' . $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Docdbas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'ID' => $model->ID, 'MDL_ID' => $model->MDL_ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="docdba-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
