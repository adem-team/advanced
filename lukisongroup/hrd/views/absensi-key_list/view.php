<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model lukisongroup\hrd\models\Key_list */

$this->title = $model->FunctionKey;
$this->params['breadcrumbs'][] = ['label' => 'Key Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="key-list-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->FunctionKey], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->FunctionKey], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'FunctionKey',
            'FunctionKeyNM',
        ],
    ]) ?>

</div>
