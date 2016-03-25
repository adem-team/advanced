<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model lukisongroup\sistem\models\Absensi */

$this->title = $model->idno;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Absensis'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="absensi-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->idno], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->idno], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idno',
            'TerminalID',
            'UserID',
            'FunctionKey',
            'Edited',
            'UserName',
            'FlagAbsence',
            'DateTime',
            'tgl',
            'waktu',
        ],
    ]) ?>

</div>
