<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\DraftLayer */

$this->title = 'Create Draft Layer';
$this->params['breadcrumbs'][] = ['label' => 'Draft Layers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="draft-layer-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
