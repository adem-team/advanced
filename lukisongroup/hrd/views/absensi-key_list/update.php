<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model lukisongroup\hrd\models\Key_list */

$this->title = 'Update Key List: ' . ' ' . $model->FunctionKey;
$this->params['breadcrumbs'][] = ['label' => 'Key Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->FunctionKey, 'url' => ['view', 'id' => $model->FunctionKey]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="key-list-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
