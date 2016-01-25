<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Barangalias */

$this->title = 'Create Barangalias';
$this->params['breadcrumbs'][] = ['label' => 'Barangaliases', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="barangalias-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
