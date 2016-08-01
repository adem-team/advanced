<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\DraftGeo */

$this->title = 'Create Draft Geo';
$this->params['breadcrumbs'][] = ['label' => 'Draft Geos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="draft-geo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
