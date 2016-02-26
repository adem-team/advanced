<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\hrd\models\Key_list */

$this->title = 'Create Key List';
$this->params['breadcrumbs'][] = ['label' => 'Key Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="key-list-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
