<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Proggresjob */

$this->title = 'Update Proggresjob: ' . ' ' . $model->proggres_id;
$this->params['breadcrumbs'][] = ['label' => 'Proggresjobs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->proggres_id, 'url' => ['view', 'id' => $model->proggres_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="proggresjob-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
