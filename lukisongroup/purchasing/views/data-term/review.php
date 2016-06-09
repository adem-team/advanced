<?php
use kartik\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use kartik\tabs\TabsX;
use yii\helpers\Json;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\web\Request;
use kartik\daterange\DateRangePicker;
use yii\db\ActiveRecord;
use yii\data\ArrayDataProvider;

use lukisongroup\master\models\Customers;
use lukisongroup\master\models\Termcustomers;
use lukisongroup\master\models\Distributor;
use lukisongroup\hrd\models\Corp;



$this->sideCorp = 'ESM-Trading Terms';              /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_trading_term';               /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Trading Terms ');

//print_r($model[0]);

//echo $model[0]->NmDis;
?>
<div class="content" >
	<!-- HEADER !-->
	<div  class="row">
		<div class="col-lg-12">

				<!-- HEADER !-->
				<div class="col-md-1" style="float:left;">
					<?php echo Html::img('@web/upload/lukison.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']); ?>
				</div>
				<div class="col-md-9">
					<h4 class="text-center"><b> <?php echo 'REVIEW TERM';  ?> </b></h4>
					<h4 class="text-center"><b> <?php echo  ucwords($model->NmCustomer)  ?> </b></h4>
				</div>
				<div class="col-md-12">
					<hr style="height:10px;margin-top: 1px; margin-bottom: 1px;color:#94cdf0">
				</div>

				<!-- DATA !-->
				<?php
					$contentData=$this->render('_reviewData',[
						'model'=>$model,
            'cus_kd'=>$cus_kd,
						'dataProvider'=>$dataProvider,
						'dataProviderBudget'=>$dataProviderBudget,
						'dataProviderBudgetdetail'=>$dataProviderBudgetdetail,
						'dataProviderBudgetdetail_inves'=>$dataProviderBudgetdetail_inves
					]);
					$contentChart=$this->render('_reviewChart');

					$items=[
						[
							'label'=>'<i class="fa fa-mortar-board fa-lg"></i>  TERM DATA','content'=>$contentData,
							'active'=>true,
							'options' => ['id' => 'term-data'],
						],
						[
							'label'=>'<i class="fa fa-bar-chart fa-lg"></i> SELL CONTRIBUTING','content'=>'',
							'options' => ['id' => 'sell-chart'],
						],
						[
							'label'=>'<i class="fa fa-bar-chart fa-lg"></i>  TERM CHART','content'=>'',
							'options' => ['id' => 'term-chart'],
						]
					];
					echo TabsX::widget([
						'id'=>'tab-term-plan',
						'items'=>$items,
						'sideways'=>true,
						'position'=>TabsX::POS_ABOVE,
						'encodeLabels'=>false,

					]);
				?>
		</div>
	</div>

</div><!-- Body !-->
