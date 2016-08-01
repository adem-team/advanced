<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\DraftLayerMutasi */

$this->title = 'Create Draft Layer Mutasi';
$this->params['breadcrumbs'][] = ['label' => 'Draft Layer Mutasis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="draft-layer-mutasi-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
