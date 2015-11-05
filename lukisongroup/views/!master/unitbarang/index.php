<?php
use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\models\master\UnitbarangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Unit Barang';
$this->params['breadcrumbs'][] = $this->title;

$this->sideCorp = 'Lukison Group';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'datamaster';                                 /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Data Master');         /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                      /* belum di gunakan karena sudah ada list sidemenu, on plan next*/

?>

<div class="unitbarang-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?php
		$gridColumns = [
            ['class' => 'yii\grid\SerialColumn'],

            'NM_UNIT',
            'SIZE',
            'WIGHT',
            'COLOR',
			
            ['class' => 'yii\grid\ActionColumn'],
    ]; 
	

	echo Yii::$app->gv->grview($gridColumns,$dataProvider,$searchModel, 'Unit Barang', 'unit-barang',$this->title);
	
	?>

</div>
