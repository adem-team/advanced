<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\DraftGeo */

$this->title = 'Update Draft Geo: ' . $model->GEO_ID;
$this->params['breadcrumbs'][] = ['label' => 'Draft Geos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->GEO_ID, 'url' => ['view', 'id' => $model->GEO_ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="draft-geo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
