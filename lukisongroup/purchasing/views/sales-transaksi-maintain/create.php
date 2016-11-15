<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\purchasing\models\salesmanorder\SoT2 */

$this->title = 'Create So T2';
$this->params['breadcrumbs'][] = ['label' => 'So T2s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="so-t2-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
