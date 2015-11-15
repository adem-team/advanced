<?php

use yii\helpers\Html;
use yii\grid\GridView;
use leandrogehlen\treegrid\TreeGrid;

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\models\widget\doc\DocdbaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Docdbas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="docdba-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Docdba', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

	<?= TreeGrid::widget([
      'dataProvider' => $dataProvider,
	  //'pageSizeLimit' => [5,100],
      'keyColumnName' => 'ID',
      'parentColumnName' => 'PARENT',
      'columns' => [
			//'ID',
            //'PARENT',
            //'MDL_ID',
            'MDL_NM',
            'MDL_DB',
            'MDL_DB_ALIAS',
            'MDL_TBL',
            'MDL_KEY',
            'MDL_FLD',
            'MDL_CLS',
            'MDL_LINK',
            'DSCRP',
            // 'CREATED_DATE',
            // 'STATUS',
            // 'CORP_ID',
            // 'DEP_ID',
            // 'USER_CREATED',
            // 'SORT',
          ['class' => 'yii\grid\ActionColumn']
      ]        
  ]); ?>  
  

</div>
