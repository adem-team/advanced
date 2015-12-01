<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\esm\models\Kota */

$this->title = 'Create Kota';
$this->params['breadcrumbs'][] = ['label' => 'Kotas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kota-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
