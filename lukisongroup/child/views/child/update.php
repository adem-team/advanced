<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model lukisongroup\child\models\Child */

$this->title = 'Update Child: ' . ' ' . $model->CHILD_ID;
$this->params['breadcrumbs'][] = ['label' => 'Children', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->CHILD_ID, 'url' => ['view', 'id' => $model->CHILD_ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="child-update">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
