<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model lukisongroup\hrd\models\Personallog_usb */

$this->title = $model->TerminalID;
$this->params['breadcrumbs'][] = ['label' => 'Personallog Usbs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="personallog-usb-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->TerminalID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->TerminalID], [
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
            'TerminalID',
            'FingerPrintID',
            'FunctionKey',
            'DateTime',
            'FlagAbsence',
        ],
    ]) ?>

</div>
