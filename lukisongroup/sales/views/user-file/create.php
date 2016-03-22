<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\sales\models\UserFile */

$this->title = 'Create User File';
$this->params['breadcrumbs'][] = ['label' => 'User Files', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-file-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
