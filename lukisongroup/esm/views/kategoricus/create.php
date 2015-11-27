<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\esm\models\Kategoricus */

$this->title = 'Create Kategoricus';
$this->params['breadcrumbs'][] = ['label' => 'Kategoricuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kategoricus-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
