<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\esm\models\Customerskat */

$this->title = 'Create Customerskat';
$this->params['breadcrumbs'][] = ['label' => 'Customerskats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customerskat-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
