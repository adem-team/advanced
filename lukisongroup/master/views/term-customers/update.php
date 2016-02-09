<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Termcustomers */

$this->title = 'Update Termcustomers: ' . ' ' . $model->ID_TERM;
$this->params['breadcrumbs'][] = ['label' => 'Termcustomers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID_TERM, 'url' => ['view', 'id' => $model->ID_TERM]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="termcustomers-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
