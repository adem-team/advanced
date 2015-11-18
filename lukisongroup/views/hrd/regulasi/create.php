<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\models\hrd\Regulasi */

$this->title = 'Create Regulasi';
$this->params['breadcrumbs'][] = ['label' => 'Regulasis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="regulasi-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
