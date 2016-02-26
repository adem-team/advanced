<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\hrd\models\Kar_finger */

$this->title = 'Create Kar Finger';
$this->params['breadcrumbs'][] = ['label' => 'Kar Fingers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kar-finger-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
