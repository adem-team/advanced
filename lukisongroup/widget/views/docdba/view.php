<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model lukisongroup\models\widget\doc\Docdba */

$this->title = $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Docdbas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="docdba-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'ID' => $model->ID, 'MDL_ID' => $model->MDL_ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'ID' => $model->ID, 'MDL_ID' => $model->MDL_ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ID',
            'PARENT',
            'MDL_ID',
            'MDL_NM',
            'MDL_DB',
            'MDL_DB_ALIAS',
            'MDL_TBL',
            'MDL_KEY',
            'MDL_FLD',
            'MDL_CLS',
            'MDL_LINK',
            'DSCRP:ntext',
            'CREATED_DATE',
            'STATUS',
            'CORP_ID',
            'DEP_ID',
            'USER_CREATED',
            'SORT',
        ],
    ]) ?>

</div>
