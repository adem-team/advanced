<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model lukisongroup\hrd\models\Kar_finger */

$this->title = $model->NO_URUT;
$this->params['breadcrumbs'][] = ['label' => 'Kar Fingers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kar-finger-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->NO_URUT], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->NO_URUT], [
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
            'NO_URUT',
            'TerminalID',
            'KAR_ID',
            'FingerPrintID',
            'FingerTmpl:ntext',
            'UPDT',
        ],
    ]) ?>

</div>
