<?php

use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model lukisongroup\child\models\Child */

$this->title = 'Create Child';
$this->params['breadcrumbs'][] = ['label' => 'Children', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="child-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
