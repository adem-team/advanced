<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model lukisongroup\widget\models\Berita */

$this->title = 'Update Berita: ' . ' ' . $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Beritas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'ID' => $model->ID, 'KD_BERITA' => $model->KD_BERITA]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="berita-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
