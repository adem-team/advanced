<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\ActiveForm;
use kartik\tabs\TabsX;
/* @var $this yii\web\View */
/* @var $model app\models\system\Dashboard */
?>
<div class="panel panel-default" style="margin-top: 10px">
    <div class="panel-heading"><?php echo 'DASHBOARD '. $model->CORP_NM; ?>
     </div>
    <div class="panel-body">

<div class="dashboard-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->CORP_ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->CORP_ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'CORP_ID',
            'CORP_NM',
        ],
    ]) ?>
    sd</div>
    </div>
</div>
