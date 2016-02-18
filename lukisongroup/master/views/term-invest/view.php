<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Terminvest */

$this->title = $model->INVES_TYPE;
$this->params['breadcrumbs'][] = ['label' => 'Terminvests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="terminvest-view">

    <h1><?= Html::encode($this->title) ?></h1>

  

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ID',
            'INVES_TYPE',
            'STATUS',
            'KETERANGAN:ntext',
        ],
    ]) ?>

</div>
