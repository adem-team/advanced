<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model lukisongroup\grandchild\models\Grandchild */

$this->title = $model->GRANDCHILD_ID;
$this->params['breadcrumbs'][] = ['label' => 'Grandchildren', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grandchild-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->GRANDCHILD_ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->GRANDCHILD_ID], [
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
            'GRANDCHILD_ID',
            'CHILD_ID',
            'PARENT_ID',
            'GRANDCHILD',
        ],
    ]) ?>

</div>
