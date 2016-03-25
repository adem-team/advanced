<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\sales\models\ImportView */

$this->title = 'Create Import View';
$this->params['breadcrumbs'][] = ['label' => 'Import Views', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="import-view-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
