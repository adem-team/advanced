<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Termbudget */

$this->title = 'Create Termbudget';
$this->params['breadcrumbs'][] = ['label' => 'Termbudgets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="termbudget-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
