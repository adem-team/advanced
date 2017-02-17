<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\warehouse\models\TypeKtg */

$this->title = Yii::t('app', 'Create Type Ktg');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Type Ktgs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="type-ktg-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
