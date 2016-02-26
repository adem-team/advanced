<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\hrd\models\Personallog_usbSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Personallog Usbs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="personallog-usb-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Personallog Usb', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'TerminalID',
            'FingerPrintID',
            'FunctionKey',
            'DateTime',
            'FlagAbsence',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
