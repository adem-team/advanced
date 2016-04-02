<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Terminvest */

$this->sideCorp = 'ESM-Trading Terms';              /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_trading_term';               /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Trading Terms ');   

$this->params['breadcrumbs'][] = ['label' => 'Terminvests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="terminvest-view">

    <h1><?= Html::encode($this->title) ?></h1>

  

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ID',
            'INVES_TYPE',
            'STATUS',
            'KETERANGAN:ntext',
        ],
    ]) ?>

</div>
