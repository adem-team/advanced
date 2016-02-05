<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\sales\models\Sot2 */

$this->title = 'Create Sot2';
$this->params['breadcrumbs'][] = ['label' => 'Sot2s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sot2-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
