<?php

/*extensions*/
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use kartik\detail\DetailView;
use kartik\money\MaskMoney;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;
use yii\widgets\Pjax;

/*namespace models*/
use lukisongroup\master\models\Terminvest;
use lukisongroup\master\models\Termgeneral;
use lukisongroup\master\models\Customers;
use lukisongroup\master\models\Termcustomers;
use lukisongroup\master\models\Distributor;
use lukisongroup\hrd\models\Corp;
use lukisongroup\hrd\models\Jobgrade;
use lukisongroup\purchasing\models\pr\Costcenter;



$this->sideCorp = 'ESM-Trading Terms';              /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_trading_term';               /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Trading Terms ');

	$aryStatus= [
		  ['STATUS' =>0, 'DESCRIP' => 'New'],
		  ['STATUS' =>1, 'DESCRIP' => 'Approved'],
		  ['STATUS' =>2, 'DESCRIP' => 'Reject']
	];
	$valStatus = ArrayHelper::map($aryStatus, 'STATUS', 'DESCRIP');


	/*
	 * STATUS FLOW DATA
	 * 1. NEW		= 0 	| Create First
	 * 2. APPROVED	= 1 	| Approved
	 * 3. REJECT	= 101	| Reject
	*/
	function statusTerm($model){
		if($model['STATUS']==0){
			/*New*/
			return Html::a('<i class="fa fa-square-o fa-md"></i> New', '#',['class'=>'btn btn-info btn-xs', 'style'=>['width'=>'100px'],'title'=>'New']);
		}elseif($model['STATUS']==1){
			/*Approved*/
			return Html::a('<i class="fa fa-check-square-o fa-md"></i>Approved', '#',['class'=>'btn btn-success btn-xs','style'=>['width'=>'100px'], 'title'=>'Approved']);
		}elseif ($model['STATUS']==3){
			/*REJECT*/
			return Html::a('<i class="fa fa-remove fa-md"></i>Reject ', '#',['class'=>'btn btn-danger btn-xs','style'=>['width'=>'100px'], 'title'=>'Reject']);
		};
	}

  function tombolApproval($url, $Model){
        $title = Yii::t('app', 'Approved');
        $options = [ 'id'=>'approved',
               'data-pjax' => true,
               'data-toggle-approved'=>$Model->ID,
        ];
        $icon = '<span class="glyphicon glyphicon-ok"></span>';
        $label = $icon . ' ' . $title;
        return '<li>' . Html::a($label, '' , $options) . '</li>';
  }

  function tombolReject($url, $Model) {
				$title = Yii::t('app', 'Reject');
				$options = [ 'id'=>'reject',
							 'data-pjax'=>true,
							 'data-toggle-reject' =>$Model->ID
				];
				$icon = '<span class="glyphicon glyphicon-ok"></span>';
				$label = $icon . ' ' . $title;
				$options['tabindex'] = '-1';
				return '<li>' . Html::a($label, '' , $options) . '</li>' ;
	}

	function tombolCancel($url, $Model) {
				$title = Yii::t('app', 'cancel');
				$options = [ 'id'=>'cancel',
							 'data-pjax'=>true,
							 'data-toggle-cancel' =>$Model->ID
				];
				$icon = '<span class="glyphicon glyphicon-ok"></span>';
				$label = $icon . ' ' . $title;
				$options['tabindex'] = '-1';
				return '<li>' . Html::a($label, '' , $options) . '</li>' ;
	}


	function pihak($model){
		$title = Yii::t('app','');
		$options = [ 'id'=>'phk',
			  'data-toggle'=>"modal",
			  'data-target'=>"#pihak",
			  'class'=>'btn btn-warning btn-xs',
			  //'style'=>['width'=>'150px'],
			  'title'=>'Set'
		];
		$icon = '<span class="glyphicon glyphicon-open"></span>';
		$label = $icon . ' ' . $title;
		$url = Url::toRoute(['/master/term-customers/pihak','id'=>$model->ID_TERM]);
		$content = Html::a($label,$url, $options);
		return $content;
	}

	function periode($model){
		$title = Yii::t('app','');
		$options = [ 'id'=>'peirod',
			  'data-toggle'=>"modal",
			  'data-target'=>"#periode",
			  'class'=>'btn btn-warning btn-xs',
			  //'style'=>['width'=>'150px'],
			  'title'=>'Set'
		];
		$icon = '<span class="glyphicon glyphicon-open"></span>';
		$label = $icon . ' ' . $title;
		$url = Url::toRoute(['/master/term-customers/periode','id'=>$model->ID_TERM]);
		$content = Html::a($label,$url, $options);
		return $content;
	}

	function TOP($model){
		$title = Yii::t('app','');
		$options = [ 'id'=>'top',
			  'data-toggle'=>"modal",
			  'data-target'=>"#TOP",
			  'class'=>'btn btn-warning btn-xs',
			  //'style'=>['width'=>'150px'],
			  'title'=>'Set'
		];
		$icon = '<span class="glyphicon glyphicon-open"></span>';
		$label = $icon . ' ' . $title;
		$url = Url::toRoute(['/master/term-customers/top','id'=>$model->ID_TERM]);
		$content = Html::a($label,$url, $options);
		return $content;
	}

	function RABATE($model){
		$title = Yii::t('app','');
		$options = [ 'id'=>'rabate',
			  'data-toggle'=>"modal",
			  'data-target'=>"#RABATE",
			  'class'=>'btn btn-warning btn-xs',
			  //'style'=>['width'=>'150px'],
			  'title'=>'Set'
		];
		$icon = '<span class="glyphicon glyphicon-open"></span>';
		$label = $icon . ' ' . $title;
		$url = Url::toRoute(['/master/term-customers/rabate','id'=>$model->ID_TERM]);
		$content = Html::a($label,$url, $options);
		return $content;
	}

	function target($model){
		$title = Yii::t('app','');
		$options = [ 'id'=>'target-id',
			  'data-toggle'=>"modal",
			  'data-target'=>"#TARGET",
			  'class'=>'btn btn-warning btn-xs',
			  //'style'=>['width'=>'150px'],
			  'title'=>'Set'
		];
		$icon = '<span class="glyphicon glyphicon-open"></span>';
		$label = $icon . ' ' . $title;
		$url = Url::toRoute(['/master/term-customers/target','id'=>$model->ID_TERM]);
		$content = Html::a($label,$url, $options);
		return $content;
	}

	function growth($model){
		$title = Yii::t('app','');
		$options = [ 'id'=>'growth',
			  'data-toggle'=>"modal",
			  'data-target'=>"#Growth",
			  'class'=>'btn btn-warning btn-xs',
			  //'style'=>['width'=>'150px'],
			  'title'=>'Set'
		];
		$icon = '<span class="glyphicon glyphicon-open"></span>';
		$label = $icon . ' ' . $title;
		$url = Url::toRoute(['/master/term-customers/growth','id'=>$model->ID_TERM]);
		$content = Html::a($label,$url, $options);
		return $content;
	}

	function getPermission(){
	    if (Yii::$app->getUserOpt->Modul_akses('4')){
	      return Yii::$app->getUserOpt->Modul_akses('4');
	    }else{
	      return false;
	    }

	}

	function getPermissionEmp(){
		if (Yii::$app->getUserOpt->profile_user()){
			return Yii::$app->getUserOpt->profile_user()->emp;
		}else{
			return false;
		}
	}

	function INVOCE($model)
	{
		$title = Yii::t('app','');
		$options = [ 'id'=>'term-invoce-id',
						'data-toggle'=>"modal",
						'data-target'=>"#term-invoce",
						'class'=>'btn btn-info btn-xs',
						//'style'=>['width'=>'150px'],
						'title'=>'Invoce'
		];
		$icon = '<span class="fa fa-plus fa-lg"></span>';
		$label = $icon . ' ' . $title;
		$url = Url::toRoute(['/master/term-customers/invoce','id'=>$model->ID_TERM]);
		$content = Html::a($label,$url, $options);
		return $content;
	}

	function Faktur($model)
	{
		$title = Yii::t('app','');
		$options = [ 'id'=>'term-faktur-id',
						'data-toggle'=>"modal",
						'data-target'=>"#term-faktur",
						'class'=>'btn btn-info btn-xs',
						//'style'=>['width'=>'150px'],
						'title'=>'Faktur Pajak'
		];
		$icon = '<span class="fa fa-plus fa-lg"></span>';
		$label = $icon . ' ' . $title;
		$url = Url::toRoute(['/master/term-customers/faktur-pajak','id'=>$model->ID_TERM]);
		$content = Html::a($label,$url, $options);
		return $content;
	}

	function PoNote($model){
			$title = Yii::t('app','');
			$options = [ 'id'=>'po-note-id',
						  'data-toggle'=>"modal",
						  'data-target'=>"#po-note",
						  'class'=>'btn btn-info btn-xs',
						  //'style'=>['width'=>'150px'],
						  'title'=>'PO Note'
			];
			$icon = '<span class="fa fa-plus fa-lg"></span>';
			$label = $icon . ' ' . $title;
			$url = Url::toRoute(['/master/term-customers/po-note','ID'=>$model->ID_TERM]);
			$content = Html::a($label,$url, $options);
			return $content;
	}



	function PrintPdf($model){
		$title = Yii::t('app','Print');
		$options = [ 'id'=>'pdf-print-id',
			  'class'=>'btn btn-default btn-xs',
			  'title'=>'Print PDF',
			  'target' => '_blank'
		];
		$icon = '<span class="fa fa-print fa-fw"></span>';
		$label = $icon . ' ' . $title;
		$url = Url::toRoute(['/master/term-customers/cetakpdf-act','id'=>$model->ID_TERM]);
		$content = Html::a($label,$url, $options);
		return $content;
	}

	function SignCreated($model){
		$title = Yii::t('app', 'Sign Hire');
		$options = [ 'id'=>'po-auth1',
						'data-toggle'=>"modal",
						'data-target'=>"#term1-auth2-sign",
						'class'=>'btn btn-warning btn-xs',
						'style'=>['width'=>'100px'],
						'title'=>'Detail'
		];
		$icon = '<span class="glyphicon glyphicon-retweet"></span>';
		$label = $icon . ' ' . $title;
		$url = Url::toRoute(['/master/term-customers/sign-auth1-view','id'=>$model->ID_TERM]);
		//$options1['tabindex'] = '-1';
		$content = Html::a($label,$url, $options);
		return $content;
	}

	// permission sign2 == 1
if(getPermission()->BTN_SIGN2 == 1)
{
	function SignChecked($model){
		$title = Yii::t('app', 'Sign Hire');
		$options = [ 'id'=>'term-auth2',
					  'data-toggle'=>"modal",
					  'data-target'=>"#term-auth2-sign",
					  'class'=>'btn btn-warning btn-xs',
					  'style'=>['width'=>'100px'],
					  'title'=>'Detail'
		];
		$icon = '<span class="glyphicon glyphicon-retweet"></span>';
		$label = $icon . ' ' . $title;
		$url = Url::toRoute(['/master/term-customers/sign-auth2-view','id'=>$model->ID_TERM]);
		//$options1['tabindex'] = '-1';
		$content = Html::a($label,$url, $options);
		return $content;
	}
}
else{
	$title1 = Yii::t('app', 'Add Term ');
	$options1 = [ 'id'=>'action-denied-id',
					'data-toggle'=>"modal",
					'data-target'=>"#confirm-permission-alert",
						'class' => 'btn btn-success',
	];
	$icon1 = '<span class="fa fa-plus fa-lg"></span>';
	$label1 = $icon1 . ' ' . $title1;
	$content = Html::a($label1,'',$options1);
	return $content;
}


	function SignApproved($model){
		$title = Yii::t('app', 'Sign Hire');
		$options = [ 'id'=>'po-auth2',
					  'data-toggle'=>"modal",
					  'data-target'=>"#po-auth2-sign",
					  'class'=>'btn btn-warning btn-xs',
					  'style'=>['width'=>'100px'],
					  'title'=>'Detail'
		];
		$icon = '<span class="glyphicon glyphicon-retweet"></span>';
		$label = $icon . ' ' . $title;
		$url = Url::toRoute(['/purchasing/purchase-order/sign-auth2-view','id'=>$model->ID_TERM]);
		//$options1['tabindex'] = '-1';
		$content = Html::a($label,$url, $options);
		return $content;
	}


?>
<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt;padding-bottom:20px;">

	<!-- HEADER !-->
	<div  class="row">
		<!-- HEADER !-->
		<div class="col-md-12">
			<div class="col-md-1" style="float:left;">
				<?php echo Html::img('@web/upload/lukison.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']); ?>
			</div>
			<div class="col-md-9" style="padding-top:15px;">
				<h3 class="text-center"><b> <?php echo ucwords($model->NM_TERM)  ?>  </b></h3>
			</div>
			<div class="col-md-12">
				<hr style="height:10px;margin-top: 1px; margin-bottom: 1px;color:#94cdf0">
			</div>

		</div>
	</div>

	<!-- PARTIES/PIHAK !-->
	<div class="row">
		<div class="col-xs-6 col-sm-6 col-md-6" style="font-family: tahoma ;font-size: 9pt;padding-left:30px">
			<div>
				<?php echo pihak($model); ?>
			</div>
			<dl>
				<?php
					$data = Customers::find()->where(['CUST_KD'=> $model->CUST_KD])
											->asArray()
											->one();
					$datadis = Distributor::find()->where(['KD_DISTRIBUTOR'=> $model->DIST_KD])
												  ->asArray()
												  ->one();
					$datacorp = Corp::find()->where(['CORP_ID'=> $model->PRINCIPAL_KD])
																				->asArray()
																				->one();
				 ?>
				<dt><h6><u><b>PARTIES/PIHAK BERSANGKUTAN :</b></u></h6></dt>

				<dd>1 :	<?= $data['CUST_NM'] ?></dd>


				<dd>2 :	<?= $datadis['NM_DISTRIBUTOR']?></dd>


				<dd>3 :	<?=$datacorp['CORP_NM']?></dd>
			</dl>
		</div>
	</div>

	<!-- PERIODE/JANGKA WAKTU !-->
	<div class="row">
		<div class="col-xs-6 col-sm-6 col-md-6" style="font-family: tahoma ;font-size: 9pt;padding-left:30px">
			<div>
				<?php echo periode($model); ?>
			</div>
			<dl>
				<dt><h6><u><b>PERIODE/JANGKA WAKTU :</b></u></h6></dt>
				<dt style="width:80px; float:left;"> Dari: </dt>
				<dd>:	<?=$model->PERIOD_START ?></dd>

				<dt style="width:80px; float:left;">Sampai:</dt>
				<dd>:	<?=$model->PERIOD_END?></dd>
			</dl>
		</div>
	</div>

	<!-- TERM OF PAYMENT !-->
	<div class="row">
		<div class="col-xs-6 col-sm-6 col-md-6" style="font-family: tahoma ;font-size: 9pt;padding-left:30px">
			<div>
				<?php echo TOP($model); ?>
			</div>
			<dl>
				<dt><h6><u><b>TERM OF PAYMENT :</b></u></h6></dt>
				<dd> <?= $model->TOP ?></dd>
			</dl>
		</div>
	</div>

	<!-- Invoce Number  -->
	<div class="row">
		<div class="col-xs-6 col-sm-6 col-md-6" style="font-family: tahoma ;font-size: 9pt;padding-left:30px">
			<div>
				<?php echo INVOCE($model); ?>
			</div>
			<dl>
				<dt><h6><u><b> Invoice Nomer :</b></u></h6></dt>
				<dd> <?= $model->NOMER_INVOCE ?></dd>
			</dl>
		</div>
	</div>
	<!-- Faktur Pajak Number  -->
	<div class="row">
		<div class="col-xs-6 col-sm-6 col-md-6" style="font-family: tahoma ;font-size: 9pt;padding-left:30px">
			<div>
				<?php echo Faktur($model); ?>
			</div>
			<dl>
				<dt><h6><u><b> Nomer Faktur Pajak :</b></u></h6></dt>
				<dd> <?= $model->NOMER_FAKTURPAJAK ?></dd>
			</dl>
		</div>
	</div>

	<!-- TARGET !-->
    <div class="row">
		<div class="col-xs-5 col-sm-5 col-md-5" style="font-family: tahoma ;font-size: 9pt;padding-left:30px">
			<div>
				<?php echo target($model); ?>
			</div>
			<dl>
				<dt style="width:80px;"><h6><u><b>TARGET :</b></u></h6></dt>
				<dd style="width:80px"> Rp.<?=$model->TARGET_VALUE?></dd>
				<dd><?=$model->TARGET_TEXT ?> Rupiah</dd>

			</dl>
		</div>
	</div>

	<?php
		$dataids = $_GET['id'];
    //Pjax::begin(['id'=>'tes']);
	?>

	<!-- TRADE INVESTMENT !-->
	<div class="row">
	  <div class="col-xs-12 col-sm-12 col-md-12" style="font-family: tahoma ;font-size: 9pt;padding-left:30px">
		<?php

			# code...
			echo  $grid = GridView::widget([
				'id'=>'gv-term-general',
				'dataProvider'=> $dataProvider1,
				'footerRowOptions'=>['style'=>'font-weight:bold;text-decoration: underline;'],
				'beforeHeader'=>[
					[
						'columns'=>[
							['content'=>'ITEMS TRAIDE INVESTMENT', 'options'=>['colspan'=>3,'class'=>'text-center info',]],
							['content'=>'PLAN BUDGET', 'options'=>['colspan'=>2, 'class'=>'text-center info']],
							['content'=>'ACTUAL BUDGET', 'options'=>['colspan'=>2, 'class'=>'text-center info']],
							['content'=>'', 'options'=>['colspan'=>1, 'class'=>'text-center info']],
							['content'=>'Action Status ', 'options'=>['colspan'=>3,  'class'=>'text-center info']],
						],
					]
				],
				'columns' =>[
          [	//COL-0
            'class'=>'kartik\grid\ActionColumn',
            'dropdown' => true,
            'template' => '{approved} {reject} {cancel}',
            'dropdownOptions'=>['class'=>'pull-left dropdown'],
            'dropdownButton'=>['class'=>'btn btn-default btn-xs'],
            'buttons' => [
              'approved' => function ($url, $Model) {
                        return tombolApproval($url, $Model);
                    },
              /* Reject RO | Permissian Status 4; | Dept = Dept login | GF >= M */
              'reject' => function ($url, $Model) {
                        return tombolReject($url, $Model);

                    },
							'cancel' => function ($url, $Model) {
			                    return tombolCancel($url, $Model);

			                    },
            ],
            'headerOptions'=>[
              'style'=>[
                'text-align'=>'center',
                'width'=>'100px',
                'font-family'=>'verdana, arial, sans-serif',
                'font-size'=>'8pt',
                'background-color'=>'rgba(247, 245, 64, 0.6)',
              ]
            ],
            'contentOptions'=>[
              'style'=>[
                'text-align'=>'center',
                'width'=>'100px',
                'font-family'=>'verdana, arial, sans-serif',
                'font-size'=>'8pt',
                'background-color'=>'rgba(247, 245, 64, 0.6)',
              ]
            ],
          ],
					[
						'class'=>'kartik\grid\SerialColumn',
						'contentOptions'=>['class'=>'kartik-sheet-style'],
						'width'=>'5%',
						'header'=>'No.',
						'headerOptions'=>[
							'style'=>[
							 'text-align'=>'center',
							 'width'=>'100px',
							 'font-family'=>'verdana, arial, sans-serif',
							 'font-size'=>'9pt',
							 'background-color'=>'rgba(97, 211, 96, 0.3)',
							]
						],
						'contentOptions'=>[
							'style'=>[
							 'text-align'=>'center',
							 'width'=>'100px',
							 'font-family'=>'tahoma, arial, sans-serif',
							 'font-size'=>'9pt',
							]
						],
					],
					[
						'attribute' => 'inves.INVES_TYPE',
						'label'=>'Trade Investment',
						'hAlign'=>'left',
						'vAlign'=>'middle',
						'headerOptions'=>[
							'style'=>[
								 'width'=>'25%',
								 'text-align'=>'center',
								 'font-family'=>'tahoma, arial, sans-serif',
								 'font-size'=>'9pt',
								 'background-color'=>'rgba(97, 211, 96, 0.3)',
							]
						],
						'contentOptions'=>[
							'style'=>[
								 'text-align'=>'left',
								 'width'=>'25%',
								 'font-family'=>'tahoma, arial, sans-serif',
								 'font-size'=>'9pt',
							]
						],
						'pageSummaryOptions' => [
							'style'=>[
								 'border-left'=>'0px',
								 'border-right'=>'0px',
							]
						],

					],

					[
						'attribute' => 'PERIODE_END',
						'label'=>'Periode',
						'hAlign'=>'left',
						'vAlign'=>'middle',
						'noWrap'=>true,
						'value' => function($model) {
							$prde=$model->PERIODE_START!='0000-00-00'? $model->PERIODE_START . " - " . $model->PERIODE_END:"";
							//return $model->PERIODE_START . " - " . $model->PERIODE_END;
							return $prde;
						},
						'headerOptions'=>[
							'style'=>[
							 'text-align'=>'center',
							 'width'=>'15%',
							 'font-family'=>'tahoma, arial, sans-serif',
							 'font-size'=>'9pt',
							 'background-color'=>'rgba(97, 211, 96, 0.3)',
							]
						],
						'contentOptions'=>[
							'style'=>[
							 'text-align'=>'center',
							 'width'=>'15%',
							 'font-family'=>'tahoma, arial, sans-serif',
							 'font-size'=>'9pt',
							]
						],
						'pageSummary'=>function ($summary, $data, $widget){
							 return '<div> Total Budget Plan:</div>';
							},
						'pageSummaryOptions' => [
							'style'=>[
								 'font-family'=>'tahoma',
								 'font-size'=>'8pt',
								 'text-align'=>'right',
								 'border-left'=>'0px',

							]
						],
					],
					[	//COL-9
						// 'class'=>'kartik\grid\FormulaColumn',
						'header'=>'BUDGET_PLAN',
						'attribute'=>'BUDGET_PLAN',
						'mergeHeader'=>true,
						'vAlign'=>'middle',
						'hAlign'=>'right',
						//'width'=>'7%',
						// 'value'=>function ($model, $key, $index, $widget) {
						// 	$p = compact('model', 'key', 'index');
						// 	// return $widget->col(6, $p) != 0 ? $widget->col(6, $p) * round($model->UNIT_QTY  * $widget->col(8, $p),0,PHP_ROUND_HALF_UP) : 0;
						// 		return $widget->col(6, $p) != 0 ? $widget->col(6, $p) * $widget->col(8, $p): 0;
						// 	//return $widget->col(3, $p) != 0 ? $widget->col(5 ,$p) * 100 / $widget->col(3, $p) : 0;
						// },
						'headerOptions'=>[
							//'class'=>'kartik-sheet-style'
							'style'=>[
								'text-align'=>'center',
								'width'=>'150px',
								'font-family'=>'tahoma',
								'font-size'=>'8pt',
								'background-color'=>'rgba(97, 211, 96, 0.3)',
							]
						],
						'contentOptions'=>[
							'style'=>[
									'text-align'=>'right',
									'width'=>'150px',
									'font-family'=>'tahoma',
									'font-size'=>'8pt',
							]
						],
						'pageSummaryFunc'=>GridView::F_SUM,
						'pageSummary'=>true,
						'format'=>['decimal', 2],
						'pageSummary'=>function ($summary, $data, $widget) use($dataProvider1,$model2)	{
								$model=$dataProvider1->getModels();
								/*
								 * Calculate SUMMARY TOTAL
								 * @author wawan
								 * @since 1.0
								 */
							$baris = count($model);
						if($baris == 0)
						{
							$total = $summary =  0.00;
							$ttlSubtotal=number_format($total,2);
							return '<div>'.$ttlSubtotal.'</div'
							;
						}
						else{
								$total = $model2;
								$ttlSubtotal=number_format($total,2);
							return '<div>'.$ttlSubtotal.'</div>'

							;
						}

					},
						'pageSummaryOptions' => [
							'style'=>[
									'text-align'=>'right',
									'width'=>'100px',
									'font-family'=>'tahoma',
									'font-size'=>'8pt',
									//'text-decoration'=>'underline',
									//'font-weight'=>'bold',
									//'border-left-color'=>'transparant',
									'border-left'=>'0px',
							]
						]
					],
					[
						'attribute' => 'budget.TARGET_VALUE',
						'label'=>'%',
						'hAlign'=>'left',
						'vAlign'=>'middle',
						'value' => function($model) {
								if($model->budget->TARGET_VALUE == '')
								{
									 return  $model->budget->TARGET_VALUE = 0.00;
								}
								else {
									# code...
									 return $model->BUDGET_PLAN / $model->budget->TARGET_VALUE * 100;
								}
						},
						'headerOptions'=>[
							'style'=>[
								'text-align'=>'center',
								'width'=>'10%',
								'font-family'=>'tahoma, arial, sans-serif',
								'font-size'=>'9pt',
								'background-color'=>'rgba(97, 211, 96, 0.3)',
							]
						],
						'contentOptions'=>[
							'style'=>[
								'text-align'=>'right',
								'width'=>'10%',
								'font-family'=>'tahoma, arial, sans-serif',
								'font-size'=>'9pt',
							]
						],
						'pageSummaryFunc'=>GridView::F_SUM,
						'format'=>['decimal', 2],
						'pageSummary'=>true,
						'pageSummaryOptions' => [
							'style'=>[
								'font-family'=>'tahoma',
								'font-size'=>'8pt',
								'text-align'=>'right',
								'border-left'=>'0px',
							]
						 ],
					],
					[
						'attribute' => 'PROGRAM',
						'label'=>'PROGRAM',
						'hAlign'=>'left',
						'vAlign'=>'middle',
						'headerOptions'=>[
							'style'=>[
								 'width'=>'25%',
								 'text-align'=>'center',
								 'font-family'=>'tahoma, arial, sans-serif',
								 'font-size'=>'9pt',
								 'background-color'=>'rgba(97, 211, 96, 0.3)',
							]
						],
						'contentOptions'=>[
							'style'=>[
								 'text-align'=>'left',
								 'width'=>'25%',
								 'font-family'=>'tahoma, arial, sans-serif',
								 'font-size'=>'9pt',
							]
						],
						'pageSummaryOptions' => [
							'style'=>[
								 'border-left'=>'0px',
								 'border-right'=>'0px',
							]
						],

					],
					[	//COL-3
						/* Attribute Request KD_COSTCENTER */
						'class'=>'kartik\grid\EditableColumn',
						'attribute'=>'KD_COSTCENTER',
						'label'=>'CostCenter',
						'vAlign'=>'middle',
						// 'hAlign'=>'center',
						'mergeHeader'=>true,
						'headerOptions'=>[
							'style'=>[
								'text-align'=>'center',
								'width'=>'60px',
								'font-family'=>'tahoma',
								'font-size'=>'8pt',
								 'background-color'=>'rgba(97, 211, 96, 0.3)',
							]
						],
						'contentOptions'=>[
							'style'=>[
									'text-align'=>'center',
									'width'=>'60px',
									'font-family'=>'tahoma',
									'font-size'=>'8pt',
									//'border-right'=>'0px',
							]
						],
						'pageSummary'=>function ($summary, $data, $widget){
							 return '<div> Total:</div>
							 				<div> PPN :</div>
							 				<div> PPH23 :</div>
											<div> Sub Total:</div>'
											;
							},
						'pageSummaryOptions' => [
							'style'=>[
								'font-family'=>'tahoma',
								'font-size'=>'8pt',
								'text-align'=>'right',
								'border-left'=>'0px',
							]
						],
						'editableOptions' => [
							'header' => 'Cost Center',
							'inputType' => \kartik\editable\Editable::INPUT_SELECT2,
							'size' => 'sm',
							'options' => [
								'data' => ArrayHelper::map(Costcenter::find()->where('KD_COSTCENTER IN ("1000","1001")' )->all(), 'KD_COSTCENTER', 'NM_COSTCENTER'),
								'pluginOptions' => [
									//'min'=>0,
									//'max'=>5000,
									'allowClear' => true,
									'class'=>'pull-top dropup'
								],
							],
							//Refresh Display
							'displayValueConfig' => ArrayHelper::map(Costcenter::find()->all(), 'KD_COSTCENTER', 'KD_COSTCENTER'),
						],
					],

					[	//BUDGET_ACTUAL
						//COL
						'class'=>'kartik\grid\EditableColumn',
						'attribute' => 'BUDGET_ACTUAL',
						'label'=>'Budget Actual',
						'hAlign'=>'left',
						'vAlign'=>'middle',
						'refreshGrid'=>true,
						'pageSummaryFunc'=>GridView::F_SUM,
						'format'=>['decimal', 2],
						'pageSummary'=>true,
						'pageSummaryOptions' => [
							'style'=>[
								 'font-family'=>'tahoma',
								 'font-size'=>'8pt',
								 'text-align'=>'right',
								 'border-left'=>'0px',
							]
						],
						'pageSummaryFunc'=>GridView::F_SUM,
						'pageSummary'=>true,
						'format'=>['decimal', 2],
						'pageSummary'=>function ($summary, $data, $widget) use($dataProvider1,$model2,$modelnewaprov)	{
								$model=$dataProvider1->getModels();
								/*
								 * Calculate SUMMARY TOTAL
								 * @author wawan
								 * @since 1.0
								 */
							$baris = count($model);
						if($baris == 0)
						{
							$defaultppn = $model[0]['PPN'] = 0.00;
							$ppn = number_format($defaultppn,2);
							$defaultpph23 = $model[0]['PPH23'] = 0.00;
							$pph23 = number_format($defaultpph23,2);
							$total = $summary =  0.00;
							$ttlSubtotal=number_format($total,2);
							$total = $summary =  0.00;
							$Subtotal=number_format($total,2);
							return '<div>'.$ttlSubtotal.'</div>
											<div>'.$ppn.'</div>
											<div>'.$pph23.'</div>
											<div>'.$Subtotal.'</div>'
							;
						}
						else{
								$id =  $model[0]['ID_TERM'];
								$ttlSubtotal = $modelnewaprov;
								$defaultpph23=$model!=''?($model[0]['PPH23']*$ttlSubtotal)/100:0.00;
								$pph23 = number_format($defaultpph23,2);
								$defaultppn=$model!=''?($model[0]['PPN']*$ttlSubtotal)/100:0.00;
								$ppn =  number_format($defaultppn,2);
								$Subtotal = ($ttlSubtotal+$ppn)-$pph23;
								$Totalsub = number_format($Subtotal,2);

							return '<div>'.number_format($ttlSubtotal,2).'</div>
							<div>'.Html::a($ppn,Url::toRoute(['/master/term-customers/ppn','id'=>$id]),['id'=>'PPn','data-toggle'=>'modal','data-target'=>'#PPN']).'</div>
							<div>'.Html::a($pph23,Url::toRoute(['/master/term-customers/pph','id'=>$id]),['id'=>'PPh','data-toggle'=>'modal','data-target'=>'#PPH']).'</div>
								<div>'.$Totalsub.'</div>'
							;
						}



					},
						'editableOptions' => [
								'header' => 'Update Budget actual',
								'inputType' => \kartik\editable\Editable::INPUT_MONEY,
								'size' => 'sm',
								 'asPopover' => true,

								// 'options' => [
								// 	'pluginOptions' => ['min'=>0, 'max'=>50000]
								// ]
								//'displayValueConfig' => '121'

							],
						'headerOptions'=>[
							'style'=>[
								 'text-align'=>'center',
								 'width'=>'15%',
								 'font-family'=>'tahoma, arial, sans-serif',
								 'font-size'=>'9pt',
								 'background-color'=>'rgba(97, 211, 96, 0.3)',
							]
						],
						'contentOptions'=>[
							'style'=>[
								 'text-align'=>'right',
								 'width'=>'15%',
								 'font-family'=>'tahoma, arial, sans-serif',
								 'font-size'=>'9pt',
							]
						],

					],

					[	//PERCENT ACTUAL
						//COL
						'attribute' => 'budget.TARGET_VALUE',
						'label'=>'%',
						'hAlign'=>'left',
						'vAlign'=>'middle',
						'value' => function($model) {
								if($model->budget->TARGET_VALUE == '')
								{
									 return  $model->budget->TARGET_VALUE = 0.00;
								}
								else {
									# code...
									 return $model->BUDGET_ACTUAL / $model->budget->TARGET_VALUE * 100;
								}
						},
						'headerOptions'=>[
							'style'=>[
								'text-align'=>'center',
								'width'=>'10%',
								'font-family'=>'tahoma, arial, sans-serif',
								'font-size'=>'9pt',
								'background-color'=>'rgba(97, 211, 96, 0.3)',
							]
						],
						'contentOptions'=>[
							'style'=>[
								'text-align'=>'right',
								 'width'=>'10%',
								'font-family'=>'tahoma, arial, sans-serif',
								'font-size'=>'9pt',
							]
						],
						'pageSummaryFunc'=>GridView::F_SUM,
						'format'=>['decimal', 2],
						'pageSummary'=>true,
						'pageSummaryOptions' => [
							'style'=>[
								'font-family'=>'tahoma',
								'font-size'=>'8pt',
								'text-align'=>'right',
								'border-left'=>'0px',
							]
						 ],
					],

					[
						'attribute'=>'STATUS',
						'label'=>'Status',
						'hAlign'=>'right',
						'vAlign'=>'middle',
						'filter'=>$valStatus,
						'filterOptions'=>[
							'style'=>'background-color:rgba(0, 95, 218, 0.3); align:center;',
							'vAlign'=>'middle',
						],
						'format' => 'html',
						'value'=>function ($model, $key, $index, $widget) {
							return statusTerm($model);
						},
						'noWrap'=>true,
						'headerOptions'=>[
							'style'=>[
								'text-align'=>'center',
								'width'=>'15%',
								'font-family'=>'tahoma, arial, sans-serif',
								'font-size'=>'8pt',
								'background-color'=>'rgba(97, 211, 96, 0.3)',
							]
						],
						'contentOptions'=>[
							'style'=>[
								'text-align'=>'center',
								'width'=>'15%',
								'font-family'=>'tahoma, arial, sans-serif',
								'font-size'=>'8pt',
								//'background-color'=>'rgba(13, 127, 3, 0.1)',
							]
						],
						//'pageSummaryFunc'=>GridView::F_SUM,
						//'pageSummary'=>true,
						'pageSummaryOptions' => [
							'style'=>[
									'text-align'=>'right',
									'font-family'=>'tahoma',
									'font-size'=>'8pt',
									'text-decoration'=>'underline',
									'font-weight'=>'bold',
									'border-left-color'=>'transparant',
									'border-left'=>'0px',
							]
						],
					],
				],
				'showPageSummary' => true,
				'pjax'=>true,
				'pjaxSettings'=>[
					'options'=>[
						'enablePushState'=>false,
						'id'=>'gv-term-general',
					],
				],
				'toolbar' => [
					'',
				],
				'panel' => [
					'heading'=>'<h5 class="panel-title">TRADE INVESTMENT</h5>',
					'type'=>'success',
					'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Add Investment ',
						['modelClass' => 'Termcustomers',]),['/master/term-customers/create-budget-act','id'=>$dataids],[
							'data-toggle'=>"modal",
							'data-target'=>"#modal-create",
							'data-title'=>'type Investasi',
								'class' => 'btn btn-danger btn-xs'
									]),
					'showFooter'=>false,
				],
				'export' =>false,
			]);

//Pjax::end()
			?>
		</div>
	</div>

	<!-- RABATE !-->
    <div class="row">
		<div class="col-xs-6 col-sm-6 col-md-6" style="font-family: tahoma ;font-size: 9pt;padding-left:30px">
			<div>
				<?php echo RABATE($model); ?>
			</div>
			<dl>
				<dt><h6><u><b>Conditional Rabate : <?= $model->RABATE_CNDT ?></b></u></h6></dt>
			</dl>
		</div>
    </div>

	<!-- GROWTH !-->
	<div class="row">
		<div class="col-xs-6 col-sm-6 col-md-6" style="font-family: tahoma ;font-size: 9pt;padding-left:30px">
			<div>
			  <?php echo Growth($model); ?>
			</div>
			<dl>
			  <dt><h6><u><b>Growth : <?= $model->GROWTH ?> %</b></u></h6></dt>
			</dl>
		</div>
	</div>

	<!-- GENERAL TERM !-->
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12" style="font-family: tahoma ;font-size: 9pt;padding-left:30px">

			<?php
		// 	$items = [];
		// 	$data = Termgeneral::find()->where(['ID_TERM'=>$model->ID_TERM])
		// 														->asArray()
		// 														->all();
		// 	foreach ($data as $value) {
		// 	$items []= ['url' => $value['ISI_TERM'],'src' => $value['ISI_TERM']];
		// }

			 ?>

			 <!-- dosamigos\gallery\Gallery::widget(['items' => $items]);?> -->

			<?php
			echo \kato\DropZone::widget([
       'options' => [
           'maxFilesize' => '2',
					 'url'=>'/master/term-customers/upload?id='.$model->ID_TERM.''
       ],
       'clientEvents' => [
           'complete' => "function(file){console.log(file)}",
           'removedfile' => "function(file){alert(file.name + ' is removed')}"
       ],
   ]);
			// $image = $model->imagedisplay($model->ID_TERM);
			 ?>
			 <div>
				 <?php
				//  $dataimage = $image->GENERAL_TERM !=''? '<img src="data:image/jpeg;base64,' . $image->GENERAL_TERM . '" />' : '<u><h6><b>Upload Aturan</h6></b></u>';
				//  	echo  $dataimage;

			?>
		</div>

		</div>
	</div>

	<!-- PO Note !-->
	<div  class="row">
		<div  class="col-md-12" style="font-family: tahoma ;font-size: 9pt;">
			<dt><b>General Notes :</b></dt>
			<hr style="height:1px;margin-top: 1px; margin-bottom: 1px;font-family: tahoma ;font-size:8pt;">
			<div>
				<div style="float:right;text-align:right;">
					 <?php echo PoNote($model); ?>
				</div>
				<div style="margin-left:5px">
					<dd> <?php echo $model->KETERANGAN; ?></dd>
					<dt>Invoice exchange can be performed on Monday through Tuesday time of 09:00AM-16:00PM</dt>
				</div>
			</div>
			<hr style="height:1px;margin-top: 1px;">
		</div>
	</div>

	<!-- PrintPdf !-->
	<div style="text-align:right;float:right">
		<?php echo PrintPdf($model); ?>
	</div>

	<!-- Signature !-->
	<div  class="col-md-12">
		<div  class="row" >
			<div class="col-md-6">
				<table id="tblRo" class="table table-bordered" style="font-family: tahoma ;font-size: 8pt;">
					<!-- Tanggal!-->
					 <tr>
						<!-- Tanggal Pembuat RO!-->
						<th  class="col-md-1" style="text-align: center; height:20px">
							<div style="text-align:center;">
								<?php
									$placeTgl1=$model->SIG1_TGL!=0 ? Yii::$app->ambilKonvesi->convert($model->SIG1_TGL,'date') :'';
									echo '<b>Tangerang</b>,' . $placeTgl1;
								?>
							</div>

						</th>
						<!-- Tanggal Pembuat RO!-->
						<th class="col-md-1" style="text-align: center; height:20px">
							<div style="text-align:center;">
								<?php
									$placeTgl2=$model->SIG2_TGL!=0 ? Yii::$app->ambilKonvesi->convert($model->SIG2_TGL,'date') :'';
									echo '<b>Tangerang</b>,' . $placeTgl2;
								?>
							</div>

						</th>
						<!-- Tanggal PO Approved!-->
						<th class="col-md-1" style="text-align: center; height:20px">
							<div style="text-align:center;">
								<?php
									$placeTgl3=$model->SIG3_TGL!=0 ? Yii::$app->ambilKonvesi->convert($model->SIG3_TGL,'date') :'';
									echo '<b>Tangerang</b>,' . $placeTgl3;
								?>
							</div>
						</th>

					</tr>
					<!-- Department|Jbatan !-->
					 <tr>
						<th  class="col-md-1" style="background-color:rgba(126, 189, 188, 0.3);text-align: center; vertical-align:middle;height:20">
							<div>
								<b><?php  echo 'Created'; ?></b>
							</div>
						</th>
						<th class="col-md-1"  style="background-color:rgba(126, 189, 188, 0.3);text-align: center; vertical-align:middle;height:20">
							<div>
								<b><?php  echo 'Checked'; ?></b>
							</div>
						</th>
						<th class="col-md-1" style="background-color:rgba(126, 189, 188, 0.3);text-align: center; vertical-align:middle;height:20">
							<div>
								<b><?php  echo 'Approved'; ?></b>
							</div>
						</th>
					</tr>
					<!-- Signature !-->
					 <tr>
						<th class="col-md-1" style="text-align: center; vertical-align:middle; height:40px">
							<?php
								$ttd1 = $model->SIG1_SVGBASE64!='' ?  '<img style="width:80; height:40px" src='.$model->SIG1_SVGBASE64.'></img>' :SignCreated($model);
                  echo $ttd1;
							?>
						</th>
						<th class="col-md-1" style="text-align: center; vertical-align:middle">
							<?php
								$ttd2 = $model->SIG2_SVGBASE64!='' ?  '<img style="width:80; height:40px" src='.$model->SIG2_SVGBASE64.'></img>' :SignChecked($model);
                echo $ttd2;
							?>
						</th>
						<th  class="col-md-1" style="text-align: center; vertical-align:middle">
							<?php
								$ttd3 = $model->SIG3_SVGBASE64!='' ?  '<img style="width:80; height:40px" src='.$model->SIG3_SVGBASE64.'></img>' :SignApproved($model);
									echo $ttd3;
							?>
						</th>
					</tr>
					<!--Nama !-->
					 <tr>
						<th class="col-md-1" style="text-align: center; vertical-align:middle;height:20; background-color:rgba(126, 189, 188, 0.3);text-align: center;">
							<div>
								<?php
									$sigNm1=$model->SIG1_NM!='none' ? '<b>'.$model->SIG1_NM.'</b>' : 'none';
									echo $sigNm1;
								?>
							</div>
						</th>
						<th class="col-md-1" style="text-align: center; vertical-align:middle;height:20; background-color:rgba(126, 189, 188, 0.3);text-align: center;">
							<div>
								<?php
									$sigNm2=$model->SIG2_NM!='none' ? '<b>'.$model->SIG2_NM.'</b>' : 'none';
									echo $sigNm2;
								?>
							</div>
						</th>
						<th class="col-md-1" style="text-align: center; vertical-align:middle;height:20; background-color:rgba(126, 189, 188, 0.3);text-align: center;">
							<div>
								<?php
									$sigNm3=$model->SIG3_NM!='none' ? '<b>'.$model->SIG3_NM.'</b>' : 'none';
									echo $sigNm3;
								?>
							</div>
						</th>
					</tr>
					<!-- Department|Jbatan !-->
					 <tr>
						<th style="text-align: center; vertical-align:middle;height:20">
							<div>
								<b><?php  echo 'Marketing & Sales'; ?></b>
							</div>
						</th>
						<th style="text-align: center; vertical-align:middle;height:20">
							<div>
								<b><?php  echo 'F & A'; ?></b>
							</div>
						</th>
						<th style="text-align: center; vertical-align:middle;height:20">
							<div>
								<b><?php  echo 'Director'; ?></b>
							</div>
						</th>
					</tr>
				</table>
			</div>
</div>
<?php

$this->registerJs("
	 // $(document).ready(function(){
		 // $('.kv-editable-submit').click(function($){
		//	alert('tes');
		//	$('gv-term-general').load(window.location + '#gv-term-general');
		//	$.pjax.reload('#gv-term-general');
		// });
		// $(function() {
			// startRefresh();
		// });

		// function startRefresh() {
			// setTimeout(function(){
			//	$('gv-term-general').load(window.location + '#gv-term-general');
			//	$.pjax.reload('#gv-term-general');
				// $.pjax.reload({container:'#gv-term-general'});
			// }, 1000);
		 // }
	// })


",$this::POS_READY);

$this->registerJs("
		$.fn.modal.Constructor.prototype.enforceFocus = function() {};
		$('#term-auth2-sign').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget)
			var modal = $(this)
			var title = button.data('title')
			var href = button.attr('href')
			modal.find('.modal-title').html(title)
			modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
			$.post(href)
				.done(function( data ) {
					modal.find('.modal-body').html(data)
				});
			}),
",$this::POS_READY);

$this->registerJs("
		$.fn.modal.Constructor.prototype.enforceFocus = function() {};
		$('#term-auth2-sign').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget)
			var modal = $(this)
			var title = button.data('title')
			var href = button.attr('href')
			modal.find('.modal-title').html(title)
			modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
			$.post(href)
				.done(function( data ) {
					modal.find('.modal-body').html(data)
				});
			}),
",$this::POS_READY);
Modal::begin([
		'id' => 'term-auth2-sign',
		//'header' => '<h4 class="modal-title">Signature Authorize</h4>',
		'header' => '<div style="float:left;margin-right:10px">'. Html::img('@web/img_setting/login/login1.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']).'</div><div style="margin-top:10px;"><h4><b>Signature Authorize</b></h4></div>',
		//'size' => 'modal-xs'
		'size' => Modal::SIZE_SMALL,
		'headerOptions'=>[
			'style'=> 'border-radius:5px; background-color:rgba(230, 251, 225, 1)'
		]
	]);
Modal::end();

$this->registerJs("
		$.fn.modal.Constructor.prototype.enforceFocus = function() {};
		$('#term1-auth2-sign').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget)
			var modal = $(this)
			var title = button.data('title')
			var href = button.attr('href')
			modal.find('.modal-title').html(title)
			modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
			$.post(href)
				.done(function( data ) {
					modal.find('.modal-body').html(data)
				});
			}),
",$this::POS_READY);
Modal::begin([
		'id' => 'term1-auth2-sign',
		//'header' => '<h4 class="modal-title">Signature Authorize</h4>',
		'header' => '<div style="float:left;margin-right:10px">'. Html::img('@web/img_setting/login/login1.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']).'</div><div style="margin-top:10px;"><h4><b>Signature Authorize</b></h4></div>',
		//'size' => 'modal-xs'
		'size' => Modal::SIZE_SMALL,
		'headerOptions'=>[
			'style'=> 'border-radius:5px; background-color:rgba(230, 251, 225, 1)'
		]
	]);
Modal::end();


			 $this->registerJs("
					$.fn.modal.Constructor.prototype.enforceFocus = function(){};
					$('#pihak').on('show.bs.modal', function (event) {
					 var button = $(event.relatedTarget)
					 var modal = $(this)
					 var title = button.data('title')
					 var href = button.attr('href')
					 //modal.find('.modal-title').html(title)
					 modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
					 $.post(href)
						 .done(function( data ) {
							 modal.find('.modal-body').html(data)
						 });
					 })
			 ",$this::POS_READY);
				 Modal::begin([
					'id' => 'pihak',
				 'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title"> Pihak Terkait</h4></div>',
				 'headerOptions'=>[
						 'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
				 ],
				 ]);
				 Modal::end();

			 $this->registerJs("
					$.fn.modal.Constructor.prototype.enforceFocus = function(){};
					$('#term-invoce').on('show.bs.modal', function (event) {
					 var button = $(event.relatedTarget)
					 var modal = $(this)
					 var title = button.data('title')
					 var href = button.attr('href')
					 //modal.find('.modal-title').html(title)
					 modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
					 $.post(href)
						 .done(function( data ) {
							 modal.find('.modal-body').html(data)
						 });
					 })
			 ",$this::POS_READY);
				 Modal::begin([
					'id' => 'term-invoce',
				 'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title"> Pihak Terkait</h4></div>',
				 'headerOptions'=>[
						 'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
				 ],
				 ]);
				 Modal::end();

				 $this->registerJs("
					 $.fn.modal.Constructor.prototype.enforceFocus = function(){};
					 $('#term-faktur').on('show.bs.modal', function (event) {
						var button = $(event.relatedTarget)
						var modal = $(this)
						var title = button.data('title')
						var href = button.attr('href')
						//modal.find('.modal-title').html(title)
						modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
						$.post(href)
							.done(function( data ) {
								modal.find('.modal-body').html(data)
							});
						})
				",$this::POS_READY);
					Modal::begin([
					 'id' => 'term-faktur',
					'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title"> Pihak Terkait</h4></div>',
					'headerOptions'=>[
							'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
					],
					]);
					Modal::end();

			 $this->registerJs("
					$.fn.modal.Constructor.prototype.enforceFocus = function(){};
					$('#PPN').on('show.bs.modal', function (event) {
					 var button = $(event.relatedTarget)
					 var modal = $(this)
					 var title = button.data('title')
					 var href = button.attr('href')
					 //modal.find('.modal-title').html(title)
					 modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
					 $.post(href)
						 .done(function( data ) {
							 modal.find('.modal-body').html(data)
						 });
					 })
			 ",$this::POS_READY);
				 Modal::begin([
					'id' => 'PPN',
				 'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title"> Pihak Terkait</h4></div>',
				 'headerOptions'=>[
						 'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
				 ],
				 ]);
				 Modal::end();

				 $this->registerJs("
					 $.fn.modal.Constructor.prototype.enforceFocus = function(){};
					 $('#PPH').on('show.bs.modal', function (event) {
						var button = $(event.relatedTarget)
						var modal = $(this)
						var title = button.data('title')
						var href = button.attr('href')
						//modal.find('.modal-title').html(title)
						modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
						$.post(href)
							.done(function( data ) {
								modal.find('.modal-body').html(data)
							});
						})
				",$this::POS_READY);
					Modal::begin([
					 'id' => 'PPH',
					'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title"> Pihak Terkait</h4></div>',
					'headerOptions'=>[
							'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
					],
					]);
					Modal::end();

			 $this->registerJs("
					$.fn.modal.Constructor.prototype.enforceFocus = function(){};
					$('#po-note').on('show.bs.modal', function (event) {
					 var button = $(event.relatedTarget)
					 var modal = $(this)
					 var title = button.data('title')
					 var href = button.attr('href')
					 //modal.find('.modal-title').html(title)
					 modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
					 $.post(href)
						 .done(function( data ) {
							 modal.find('.modal-body').html(data)
						 });
					 })
			 ",$this::POS_READY);
				 Modal::begin([
					'id' => 'po-note',
				 'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title"> Pihak Terkait</h4></div>',
				 'headerOptions'=>[
						 'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
				 ],
				 ]);
				 Modal::end();

       $this->registerJs("
          $.fn.modal.Constructor.prototype.enforceFocus = function(){};
          $('#RABATE').on('show.bs.modal', function (event) {
           var button = $(event.relatedTarget)
           var modal = $(this)
           var title = button.data('title')
           var href = button.attr('href')
           //modal.find('.modal-title').html(title)
           modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
           $.post(href)
             .done(function( data ) {
               modal.find('.modal-body').html(data)
             });
           })
       ",$this::POS_READY);
         Modal::begin([
          'id' => 'RABATE',
         'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title"> Rabate Conditional</h4></div>',
         'headerOptions'=>[
             'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
         ],
         ]);
         Modal::end();
         $this->registerJs("
            $.fn.modal.Constructor.prototype.enforceFocus = function(){};
            $('#Growth').on('show.bs.modal', function (event) {
             var button = $(event.relatedTarget)
             var modal = $(this)
             var title = button.data('title')
             var href = button.attr('href')
             //modal.find('.modal-title').html(title)
             modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
             $.post(href)
               .done(function( data ) {
                 modal.find('.modal-body').html(data)
               });
             })
         ",$this::POS_READY);
           Modal::begin([
            'id' => 'Growth',
           'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title"> Growth</h4></div>',
           'headerOptions'=>[
               'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
           ],
           ]);
           Modal::end();

       $this->registerJs("
          $.fn.modal.Constructor.prototype.enforceFocus = function(){};
          $('#periode').on('show.bs.modal', function (event) {
           var button = $(event.relatedTarget)
           var modal = $(this)
           var title = button.data('title')
           var href = button.attr('href')
           //modal.find('.modal-title').html(title)
           modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
           $.post(href)
             .done(function( data ) {
               modal.find('.modal-body').html(data)
             });
           })
       ",$this::POS_READY);
         Modal::begin([
          'id' => 'periode',
         'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">Jangka Waktu</h4></div>',
         'headerOptions'=>[
             'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
         ],
         ]);
         Modal::end();

         $this->registerJs("
            $.fn.modal.Constructor.prototype.enforceFocus = function(){};
            $('#TOP').on('show.bs.modal', function (event) {
             var button = $(event.relatedTarget)
             var modal = $(this)
             var title = button.data('title')
             var href = button.attr('href')
             //modal.find('.modal-title').html(title)
             modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
             $.post(href)
               .done(function( data ) {
                 modal.find('.modal-body').html(data)
               });
             })
         ",$this::POS_READY);
           Modal::begin([
            'id' => 'TOP',
           'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">Term Of Payment</h4></div>',
           'headerOptions'=>[
               'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
           ],
           ]);
           Modal::end();

           $this->registerJs("
              $.fn.modal.Constructor.prototype.enforceFocus = function(){};
              $('#TARGET').on('show.bs.modal', function (event) {
               var button = $(event.relatedTarget)
               var modal = $(this)
               var title = button.data('title')
               var href = button.attr('href')
               //modal.find('.modal-title').html(title)
               modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
               $.post(href)
                 .done(function( data ) {
                   modal.find('.modal-body').html(data)
                 });
               })
           ",$this::POS_READY);
             Modal::begin([
              'id' => 'TARGET',
             'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">Target</h4></div>',
             'headerOptions'=>[
                 'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
             ],
             ]);
             Modal::end();

             $this->registerJs("
                $.fn.modal.Constructor.prototype.enforceFocus = function(){};
                $('#modal-create').on('show.bs.modal', function (event) {
                 var button = $(event.relatedTarget)
                 var modal = $(this)
                 var title = button.data('title')
                 var href = button.attr('href')
                 //modal.find('.modal-title').html(title)
                 modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
                 $.post(href)
                   .done(function( data ) {
                     modal.find('.modal-body').html(data)
                   });
                 })
             ",$this::POS_READY);
               Modal::begin([
                'id' => 'modal-create',
               'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">Term</h4></div>',
               'headerOptions'=>[
                   'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
               ],
               ]);
               Modal::end();

               $this->registerJs("
                  $.fn.modal.Constructor.prototype.enforceFocus = function(){};
                  $('#modal-general').on('show.bs.modal', function (event) {
                   var button = $(event.relatedTarget)
                   var modal = $(this)
                   var title = button.data('title')
                   var href = button.attr('href')
                   //modal.find('.modal-title').html(title)
                   modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
                   $.post(href)
                     .done(function( data ) {
                       modal.find('.modal-body').html(data)
                     });
                   })
               ",$this::POS_READY);
                 Modal::begin([
                  'id' => 'modal-general',
                 'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">General Term</h4></div>',
                 'headerOptions'=>[
                     'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
                 ],
                 ]);
                 Modal::end();

                 $this->registerJs("
                    $.fn.modal.Constructor.prototype.enforceFocus = function(){};
                    $('#TTD1').on('show.bs.modal', function (event) {
                     var button = $(event.relatedTarget)
                     var modal = $(this)
                     var title = button.data('title')
                     var href = button.attr('href')
                     //modal.find('.modal-title').html(title)
                     modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
                     $.post(href)
                       .done(function( data ) {
                         modal.find('.modal-body').html(data)
                       });
                     })
                 ",$this::POS_READY);
                   Modal::begin([
                    'id' => 'TTD1',
                   'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">Create Items Sku</h4></div>',
                   'headerOptions'=>[
                       'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
                   ],
                   ]);
                   Modal::end();
                   $this->registerJs("
                      $.fn.modal.Constructor.prototype.enforceFocus = function(){};
                      $('#TTD2').on('show.bs.modal', function (event) {
                       var button = $(event.relatedTarget)
                       var modal = $(this)
                       var title = button.data('title')
                       var href = button.attr('href')
                       //modal.find('.modal-title').html(title)
                       modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
                       $.post(href)
                         .done(function( data ) {
                           modal.find('.modal-body').html(data)
                         });
                       })
                   ",$this::POS_READY);
                     Modal::begin([
                      'id' => 'TTD2',
                     'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">Create Items Sku</h4></div>',
                     'headerOptions'=>[
                         'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
                     ],
                     ]);
                     Modal::end();
                     $this->registerJs("
                        $.fn.modal.Constructor.prototype.enforceFocus = function(){};
                        $('#TTD3').on('show.bs.modal', function (event) {
                         var button = $(event.relatedTarget)
                         var modal = $(this)
                         var title = button.data('title')
                         var href = button.attr('href')
                         //modal.find('.modal-title').html(title)
                         modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
                         $.post(href)
                           .done(function( data ) {
                             modal.find('.modal-body').html(data)
                           });
                         })
                     ",$this::POS_READY);
                       Modal::begin([
                        'id' => 'TTD3',
                       'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">Create Items Sku</h4></div>',
                       'headerOptions'=>[
                           'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
                       ],
                       ]);
                       Modal::end();

											 $this->registerJs("
											     $.fn.modal.Constructor.prototype.enforceFocus = function() {};
											     $('#confirm-permission-alert').on('show.bs.modal', function (event) {
											       //var button = $(event.relatedTarget)
											       //var modal = $(this)
											       //var title = button.data('title')
											       //var href = button.attr('href')
											       //modal.find('.modal-title').html(title)
											       //modal.find('.modal-body').html('')
											       /* $.post(href)
											         .done(function( data ) {
											           modal.find('.modal-body').html(data)
											         }); */
											       }),
											 ",$this::POS_READY);
											 Modal::begin([
											     'id' => 'confirm-permission-alert',
											     'header' => '<div style="float:left;margin-right:10px">'. Html::img('@web/img_setting/warning/denied.png',  ['class' => 'pnjg', 'style'=>'width:40px;height:40px;']).'</div><div style="margin-top:10px;"><h4><b>Permmission Confirm !</b></h4></div>',
											     'size' => Modal::SIZE_SMALL,
											     'headerOptions'=>[
											       'style'=> 'border-radius:5px; background-color:rgba(142, 202, 223, 0.9)'
											     ]
											   ]);
											   echo "<div>You do not have permission for this module.
											       <dl>
											         <dt>Contact : itdept@lukison.com</dt>
											       </dl>
											     </div>";
											 Modal::end();

                       $this->registerJs("
                     		$(document).on('click', '[data-toggle-approved]', function(e){
                     			e.preventDefault();
                     			var idx = $(this).data('toggle-approved');
                     			$.ajax({
                     					url: '/master/term-customers/approved-ro-term',
                     					type: 'POST',
                     					//contentType: 'application/json; charset=utf-8',
                     					data:'id='+idx,
                     					dataType: 'json',
                     					success: function(result) {
                     						if (result == 1){
                     							// Success
                     							$.pjax.reload({container:'#gv-term-general'});
                     						} else {
                     							// Fail
                     						}
                     					}
                     				});

                     		});
                     		$(document).on('click', '[data-toggle-reject]', function(e){
                     			e.preventDefault();
                     			var idx = $(this).data('toggle-reject');
                     			$.ajax({
                     					url: '/master/term-customers/reject-ro-term',
                     					type: 'POST',
                     					//contentType: 'application/json; charset=utf-8',
                     					data:'id='+idx,
                     					dataType: 'json',
                     					success: function(result) {
                     						if (result == 1){
                     							$.pjax.reload({container:'#gv-term-general'});
                     						}
                     					}
                     				});
                     		});

												$(document).on('click', '[data-toggle-cancel]', function(e){
													e.preventDefault();
													var idx = $(this).data('toggle-cancel');
													$.ajax({
															url: '/master/term-customers/cancel',
															type: 'POST',
															//contentType: 'application/json; charset=utf-8',
															data:'id='+idx,
															dataType: 'json',
															success: function(result) {
																if (result == 1){
																	$.pjax.reload({container:'#gv-term-general'});
																}
															}
														});
												});

                     	",$this::POS_READY);
