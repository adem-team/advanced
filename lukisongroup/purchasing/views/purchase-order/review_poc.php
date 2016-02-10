<?php
use yii\helpers\Html;
//use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;

use lukisongroup\master\models\Suplier;
use lukisongroup\master\models\Barangumum;
use lukisongroup\master\models\Nmperusahaan;
use lukisongroup\purchasing\models\Purchasedetail;
use lukisongroup\esm\models\Barang;
/* @var $this yii\web\View */
/* @var $poHeader lukisongroup\poHeaders\esm\po\Purchaseorder */

$this->title = 'Detail PO';
$this->params['breadcrumbs'][] = ['label' => 'Purchaseorders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$y=4;

	/*
	 * Declaration Componen User Permission
	 * Function getPermission
	 * Modul Name[3=PO]
	*/
	function getPermission(){
		if (Yii::$app->getUserOpt->Modul_akses('3')){
			return Yii::$app->getUserOpt->Modul_akses('3');
		}else{
			return false;
		}
	}
	//print_r(getPermission());
	/*
	 * Declaration Componen User Permission
	 * Function profile_user
	 * Modul Name[3=PO]
	*/
	function getPermissionEmp(){
		if (Yii::$app->getUserOpt->profile_user()){
			return Yii::$app->getUserOpt->profile_user()->emp;
		}else{
			return false;
		}
	}
	//print_r(getPermissionEmp());
	/*
	 * Tombol Approval Item
	 * Permission Auth2 | Auth3
	 * Cancel Back To Process
	 * @author ptrnov [piter@lukison]
	 * @since 1.2
	*/
	function tombolApproval($url, $model){
		// if(getPermission()){
			// /* GF_ID>=4 Group Function[Director|GM|M|S] */
			// $gF=getPermissionEmp()->GF_ID;
			// $Auth2=getPermission()->BTN_SIGN2; // Auth2
			// $Auth3=getPermission()->BTN_SIGN3; // Auth3
			// if (($Auth2==1 or $Auth3==1) AND ($gF<=4)){
				$title = Yii::t('app', 'Approved');
				$options = [ 'id'=>'approved',
							 'data-pjax' => true,
							 'data-toggle-approved'=>$model->ID,
				];
				$icon = '<span class="glyphicon glyphicon-ok"></span>';
				$label = $icon . ' ' . $title;
				return '<li>' . Html::a($label, '' , $options) . '</li>' . PHP_EOL;
			// }
		// }
	}
	/*
	 * Tombol Reject Item
	 * Permission Auth2 | Auth3
	 * Cancel Back To Process
	 * @author ptrnov [piter@lukison]
	 * @since 1.2
	*/
	function tombolReject($url, $model) {
		// if(getPermission()){
			// /* GF_ID>=4 Group Function[Director|GM|M|S] */
			// $gF=getPermissionEmp()->GF_ID;
			// $Auth2=getPermission()->BTN_SIGN2; // Auth2
			// $Auth3=getPermission()->BTN_SIGN3; // Auth3
			// if (($Auth2==1 or $Auth3==1) AND ($gF<=4)){
				$title = Yii::t('app', 'Reject');
				$options = [ 'id'=>'reject',
							 'data-pjax'=>true,
							 'data-toggle-reject' => $model->ID
				];
				$icon = '<span class="glyphicon glyphicon-ok"></span>';
				$label = $icon . ' ' . $title;
				$options['tabindex'] = '-1';
				return '<li>' . Html::a($label, '' , $options) . '</li>' . PHP_EOL;
			// }
		// }
	}
	/*
	 * Tombol Reject Item
	 * Permission Auth2 | Auth3
	 * Cancel Back To Process
	 * @author ptrnov [piter@lukison]
	 * @since 1.2
	*/
	function tombolDelete($url, $model) {
		// if(getPermission()){
			// /* GF_ID>=4 Group Function[Director|GM|M|S] */
			// $gF=getPermissionEmp()->GF_ID;
			// $Auth2=getPermission()->BTN_SIGN2; // Auth2
			// $Auth3=getPermission()->BTN_SIGN3; // Auth3
			// if (($Auth2==1 or $Auth3==1) AND ($gF<=4)){
				$title = Yii::t('app', 'Delete');
				$options = [ 'id'=>'delete',
							 'data-pjax'=>true,
							 'data-toggle-delete' => $model->ID
				];
				$icon = '<span class="glyphicon glyphicon-ok"></span>';
				$label = $icon . ' ' . $title;
				$options['tabindex'] = '-1';
				return '<li>' . Html::a($label, '' , $options) . '</li>' . PHP_EOL;
			// }
		// }
	}
	/*
	 * Tombol Cancel Item
	 * Permission Auth2 | Auth3
	 * Cancel Back To Process
	 * @author ptrnov [piter@lukison]
	 * @since 1.2
	*/
	function tombolCancel($url, $model){
		// if(getPermission()){
			// /* GF_ID>=4 Group Function[Director|GM|M|S] */
			// $gF=getPermissionEmp()->GF_ID;
			// $Auth2=getPermission()->BTN_SIGN2; // Auth2
			// $Auth3=getPermission()->BTN_SIGN3; // Auth3
			// if (($Auth2==1 or $Auth3==1) AND ($gF<=4)){
				$title = Yii::t('app', 'Cancel');
				$options = [ 'id'=>'cancel',
							 'data-pjax'=>true,
							 'data-toggle-cancel' => $model->ID
				];
				$icon = '<span class="glyphicon glyphicon-ok"></span>';
				$label = $icon . ' ' . $title;
				return '<li>' . Html::a($label, '' , $options) . '</li>' . PHP_EOL;
			// }
		// }
	}

	/*
	 * Tombol Modul Konci ->
	 * Permission [Status 103]
	 * CLOSED 101 or 10
	*/
	function tombolKonci($url, $model){
		$title = Yii::t('app', 'LOCKED');
		$options = [ 'id'=>'confirm-permission-id',
					  'data-toggle'=>"modal",
					  'data-target'=>"#confirm-permission-alert",
					  'class'=>'btn btn-info btn-xs',
					  'style'=>['width'=>'100px','text-align'=>'center'],
					  'title'=>'Signature'
		];
		$icon = '<span class="glyphicon glyphicon-retweet" style="text-align:center"></span>';
		$label = $icon . ' ' . $title;
		$content = Html::button($label, $options);
		return $content;
	}

	/*
	 * STATUS FLOW DATA
	 * 1. NEW		= 0 	| Create First
	 * 2. APPROVED	= 1 	| Item Approved
	 * 3. PROCESS	= 101	| Sign Auth1 | Data Sudah di buat dan di tanda tangani
	 * 4. CHECKED	= 102	| Sign Auth2 | Data Sudah Di Check  dan di tanda tangani
	 * 5. APPROVED	= 103	| Sign Auth3 | Data Sudah Di disetujui dan di tanda tangani
	 * 6. DELETE	= 3 	| Data Hidden | Data Di hapus oleh pembuat petama, jika belum di Approved
	 * 7. REJECT	= 4		| Data tidak di setujui oleh manager atau Atasan  lain
	 * 8. PANDING	= 5		| Menunggu keputusan berikutnya.
	 * 9. UNKNOWN	<>		| Data Tidak valid atau tidak sah
	*/
	function statusProcessRo($model){
		if($model->STATUS==0){
			/*New*/
			return Html::a('<i class="fa fa-square-o fa-md"></i>', '#',['class'=>'btn btn-info btn-xs', 'style'=>['width'=>'25px'],'title'=>'New']);
		}elseif($model->STATUS==1){
			/*Approved*/
			return Html::a('<i class="fa fa-check-square-o fa-md"></i>', '#',['class'=>'btn btn-success btn-xs','style'=>['width'=>'25px'], 'title'=>'Approved']);
		}elseif ($model->STATUS==3){
			return Html::a('<i class="glyphicon glyphicon-remove"></i> DELETE', '#',['class'=>'btn btn-danger btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
		}elseif ($model->STATUS==4){
			/*REJECT*/
			return Html::a('<i class="fa fa-remove fa-md"></i> ', '#',['class'=>'btn btn-danger btn-xs','style'=>['width'=>'25px'], 'title'=>'Reject']);
		}elseif($model->STATUS==5){
			return Html::a('<i class="glyphicon glyphicon-retweet"></i> Pending', '#',['class'=>'btn btn-danger btn-xs', 'style'=>['width'=>'100px'],'title'=>'Detail']);
		}elseif ($model->STATUS==101){
			return Html::a('<i class="glyphicon glyphicon-time"></i> Proccess', '#',['class'=>'btn btn-warning btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
		}elseif ($model->STATUS==102){
			return Html::a('<i class="glyphicon glyphicon-ok"></i> Checked', '#',['class'=>'btn btn-success btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
		}elseif ($model->STATUS==103){
			return Html::a('<i class="glyphicon glyphicon-ok"></i> Approved', '#',['class'=>'btn btn-success btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
		}else{
			return Html::a('<i class="glyphicon glyphicon-question-sign"></i> Unknown', '#',['class'=>'btn btn-danger btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
		};
	}

	/*
	 * LINK PO Note
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.2
	*/
	function PoNote($poHeader){
			$title = Yii::t('app','');
			$options = [ 'id'=>'po-note-id',
						  'data-toggle'=>"modal",
						  'data-target'=>"#po-note-review",
						  'class'=>'btn btn-info btn-xs',
						  //'style'=>['width'=>'150px'],
						  'title'=>'PO Note'
			];
			$icon = '<span class="fa fa-plus fa-lg"></span>';
			$label = $icon . ' ' . $title;
			$url = Url::toRoute(['/purchasing/purchase-order/po-note-review','kdpo'=>$poHeader->KD_PO]);
			$content = Html::a($label,$url, $options);
			return $content;
	}

	/*
	 * LINK PO Note TOP
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.2
	*/
	function PoNoteTOP($poHeader){
			$title = Yii::t('app','');
			$options = [ 'id'=>'po-notetop-id',
						  'data-toggle'=>"modal",
						  'data-target'=>"#po-notetop-review",
						  'class'=>'btn btn-info btn-xs',
						  //'style'=>['width'=>'150px'],
						  'title'=>'PO Note'
			];
			$icon = '<span class="fa fa-plus fa-lg"></span>';
			$label = $icon . ' ' . $title;
			$url = Url::toRoute(['/purchasing/purchase-order/po-notetop-review','kdpo'=>$poHeader->KD_PO]);
			$content = Html::a($label,$url, $options);
			return $content;
	}
?>

 <?php
        $sup = Suplier::find()->where(['KD_SUPPLIER'=>$poHeader->KD_SUPPLIER])->one();
        //$pod = Purchasedetail::find()->where(['KD_PO'=>$poHeader->KD_PO])->all();

        $ship = Nmperusahaan::find()->where(['ID' => $poHeader->SHIPPING])->one();
        $bill = Nmperusahaan::find()->where(['ID' => $poHeader->BILLING])->one();

		/* $x=10;
		function ax(){
			return '10';
		}
		 */
		/* function formulaAmount($summary, $data, $widget){
				//$calculate = dataCell($model, $key, $index);
				//$p = compact('model', 'key', 'index');
				return '<div>'.$summary * $this->model().',</div>
						<div>'.min($data).'</div>
						<div>'.$summary.'</div>
						<div>100,0</div>
						<div><b>10000,0</b></div>';
		}; */
		/*
	 * COLUMN GRID VIEW CREATE PO
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	$gridColumnsX= [
		[
			'class'=>'kartik\grid\ActionColumn',
			'dropdown' => true,
			'template' => '{approved} {reject} {cancel} {delete} {closed}',
			'dropdownOptions'=>['class'=>'pull-left dropdown'],
			//'headerOptions'=>['class'=>'kartik-sheet-style'],
			'buttons' => [
				'approved' => function ($url, $model) use ($poHeader) {
								if ($poHeader->STATUS!==103) {
									return tombolApproval($url, $model);
								}else{
								}
							},
				/* Reject RO | Permissian Status 4; | Dept = Dept login | GF >= M */
				'reject' => function ($url, $model) use ($poHeader) {
								if ($poHeader->STATUS!==103) {
									return tombolReject($url, $model);
								}
							},
				/* Cancel RO | Permissian Status 0; | Dept = Dept login | GF >= M */
				'cancel' => function ($url, $model) use ($poHeader){
								if ($poHeader->STATUS!==103) {
									return tombolCancel($url, $model);
								}
							},
				/* Delete RO | Permissian Status 0; | Dept = Dept login | GF >= M */
				'delete' => function ($url, $model) use ($poHeader){
								if ($poHeader->STATUS!==103) {
									return tombolDelete($url, $model);
								}
							},

				'closed' => function ($url, $model) use ($poHeader){
								/*Check Status Checked on Requestorderstatus TYPE=102*/
								/* $checkedMdl=Requestorderstatus::find()->where([
									'KD_RO'=>$model->KD_RO,
									'TYPE'=>102,
									'ID_USER'=>getPermissionEmp()->EMP_ID,
								])->one();
								if ($headerStatus==103 or $checkedMdl<>''  ) {
									//return Html::label('<i class="glyphicon glyphicon-lock dm"></i> LOCKED','',['class'=>'label label-danger','style'=>['align'=>'center']]);
									return  tombolKonci($url, $model);
								} */
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
			/* Attribute Status Detail RO */
			'attribute'=>'STATUS',
			'options'=>['id'=>'test-ro'],
			'label'=>'Status',
			'hAlign'=>'center',
			'vAlign'=>'middle',
			'mergeHeader'=>true,
			'contentOptions'=>['style'=>'width: 100px'],
			'format' => 'html',
			'value'=>function ($model, $key, $index, $widget) {
						return statusProcessRo($model);
			},
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'50px',
					'font-family'=>'verdana, arial, sans-serif',
					'font-size'=>'8pt',
					'background-color'=>'rgba(247, 245, 64, 0.6)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'50px',
					'font-family'=>'verdana, arial, sans-serif',
					'font-size'=>'8pt',
					'background-color'=>'rgba(247, 245, 64, 0.6)',
				]
			],
		],
		[/* Attribute Serial No */
			'class'=>'kartik\grid\SerialColumn',
			'width'=>'10px',
			'header'=>'No.',
			'hAlign'=>'center',
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'10px',
					'font-family'=>'tahoma',
					'font-size'=>'8pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'10px',
					'font-family'=>'tahoma',
					'font-size'=>'8pt',
				]
			],
			'pageSummaryOptions' => [
				'style'=>[
						'border-right'=>'0px',
				]
			]
		],
		/* [
			'attribute'=>'KD_PO',
			'hidden'=>true,
			'group'=>false,
			'groupFooter'=>function ($model, $key, $index, $widget) {
				$subttl=[
					 'mergeColumns'=>[[1,5]],
					  'content'=>[             // content to show in each summary cell
                        1=>'Summary',
                        6=>GridView::F_SUM,
                    ],
				 ];
				return $subttl;
			},

		], */

		[/* Attribute Items Barang */
			'attribute'=>'KD_BARANG',
			'label'=>'SKU',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'mergeHeader'=>true,
			'format' => 'raw',
			'headerOptions'=>[
				//'class'=>'kartik-sheet-style'
				'style'=>[
					'text-align'=>'center',
					'width'=>'150px',
					'font-family'=>'tahoma',
					'font-size'=>'8pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'width'=>'150px',
					'font-family'=>'tahoma',
					'font-size'=>'8pt',
				]
			],
			'pageSummaryOptions' => [
				'style'=>[
						'border-left'=>'0px',
						'border-right'=>'0px',
				]
			]
		],
		[/* Attribute Items Barang */
			'label'=>'Items Name',
			'attribute'=>'NM_BARANG',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'mergeHeader'=>true,
			'format' => 'raw',
			'headerOptions'=>[
				//'class'=>'kartik-sheet-style'
				'style'=>[
					'text-align'=>'center',
					'width'=>'200px',
					'font-family'=>'tahoma',
					'font-size'=>'8pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'width'=>'200px',
					'font-family'=>'tahoma',
					'font-size'=>'8pt',
				]
			],
			'pageSummaryOptions' => [
				'style'=>[
						'border-left'=>'0px',
						'border-right'=>'0px',
				]
			]
		],
		[/* Attribute Request Quantity */
			'class'=>'kartik\grid\EditableColumn',
			'attribute'=>'QTY',
			'label'=>'Qty',
			'vAlign'=>'middle',
			'hAlign'=>'center',
			'mergeHeader'=>true,
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'60px',
					'font-family'=>'tahoma',
					'font-size'=>'8pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
						'text-align'=>'right',
						'width'=>'60px',
						'font-family'=>'tahoma',
						'font-size'=>'8pt',
						//'border-right'=>'0px',
				]
			],
			'pageSummaryOptions' => [
				'style'=>[
						'border-left'=>'0px',
						'border-right'=>'0px',
				]
			],
			'editableOptions' => [
				'header' => 'Update Quantity',
				'inputType' => \kartik\editable\Editable::INPUT_TEXT,
				'size' => 'sm',
				'options' => [
				  'pluginOptions' => ['min'=>0, 'max'=>50000]
				]
			],
		],
		[/* Attribute Unit Barang */
			'attribute'=>'NM_UNIT',
			'mergeHeader'=>true,
			'label'=>'UoM',
			'vAlign'=>'middle',
			'hAlign'=>'right',
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'150px',
					'font-family'=>'tahoma',
					'font-size'=>'8pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
						'text-align'=>'left',
						'width'=>'150px',
						'font-family'=>'tahoma',
						'font-size'=>'8pt',
						'border-left'=>'0px',
				]
			],
			'pageSummaryOptions' => [
				'style'=>[
						'border-left'=>'0px',
						'border-right'=>'0px',
				]
			],
			'pageSummary'=>function ($summary, $data, $widget){
							return 	'<div>Sub Total :</div>
									<div>Discount :</div>
									<div>TAX :</div>
									<div>Delevery.Cost :</div>
									<div><b>GRAND TOTAL :</b></div>';
						},
			'pageSummaryOptions' => [
				'style'=>[
						'font-family'=>'tahoma',
						'font-size'=>'8pt',
						'text-align'=>'right',
						'border-left'=>'0px',
						'border-right'=>'0px',
				]
			],
		],
		[	/* Attribute Unit Barang */
			'class'=>'kartik\grid\EditableColumn',
			'attribute'=>'HARGA',
			'mergeHeader'=>true,
			'label'=>'Price',
			'vAlign'=>'middle',
			'hAlign'=>'right',
			'headerOptions'=>[
				//'class'=>'kartik-sheet-style'
				'style'=>[
					'text-align'=>'center',
					'width'=>'100px',
					'font-family'=>'tahoma',
					'font-size'=>'8pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
						'text-align'=>'right',
						'width'=>'100px',
						'font-family'=>'tahoma',
						'font-size'=>'8pt',
				]
			],
			'editableOptions' => [
				'header' => 'Update Price',
				'inputType' => \kartik\editable\Editable::INPUT_TEXT,
				'size' => 'sm',
				 'options' => [
				  'pluginOptions' => ['min'=>0, 'max'=>10000000000]
				]
			],
			'format'=>['decimal', 2],
			'pageSummary'=>function ($summary, $data, $widget) use ($poHeader){
							$discountModal=$poHeader->DISCOUNT!=0 ? $poHeader->DISCOUNT:'0.00';
							$pajakModal=$poHeader->PAJAK!=0 ? $poHeader->PAJAK:'0.00';
							return '<div>IDR</div >
									<div>
									'.$discountModal.'
									%</div >
									<div>
									'.$pajakModal.'
									%</div >
									<div>IDR</div >
									<div>IDR</div >';

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
		[
			'class'=>'kartik\grid\FormulaColumn',
			'header'=>'Amount',
			'mergeHeader'=>true,
			'vAlign'=>'middle',
			'hAlign'=>'right',
			//'width'=>'7%',
			'value'=>function ($model, $key, $index, $widget) {
				$p = compact('model', 'key', 'index');
				return $widget->col(5, $p) != 0 ? $widget->col(5, $p) * round($model->UNIT_QTY * $widget->col(5, $p),0,PHP_ROUND_HALF_UP) : 0;
				//return $widget->col(3, $p) != 0 ? $widget->col(5 ,$p) * 100 / $widget->col(3, $p) : 0;
			},
			'headerOptions'=>[
				//'class'=>'kartik-sheet-style'
				'style'=>[
					'text-align'=>'center',
					'width'=>'150px',
					'font-family'=>'tahoma',
					'font-size'=>'8pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',
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
			'pageSummary'=>function ($summary, $data, $widget) use ($poHeader)	{
					/*
					 * Calculate SUMMARY TOTAL
					 * @author ptrnov  <piter@lukison.com>
					 * @since 1.1
					 */
					$subTotal=$summary!=''? $summary : 0.00;

					$ttlDiscount=$poHeader->DISCOUNT!=0 ? ($poHeader->DISCOUNT/100) * $subTotal:0.00;
					$ttlTax = $poHeader->PAJAK!=0 ? ($poHeader->PAJAK / 100) * $subTotal  :0.00;
					$ttlDelivery=$poHeader->DELIVERY_COST!=0 ? $poHeader->DELIVERY_COST:0.00;
					$grandTotal=($subTotal + $ttlTax + $ttlDelivery) - $ttlDiscount;

					/*SEND TO DECIMAL*/
					$ttlSubtotal=number_format($subTotal,2);
					$ttlDiscountF=number_format($ttlDiscount,2);
					$ttlTaxF=number_format($ttlTax,2);
					$ttlDeliveryF=number_format($ttlDelivery,2);
					$grandTotalF=number_format($grandTotal,2);
					/*
					 * DISPLAY SUMMARY TOTAL
					 * LINK Modal Editing Discount | tax
					 * @author ptrnov  <piter@lukison.com>
					 * @since 1.1
					 */
					return '<div>'.$ttlSubtotal.'</div>
						<div>'.$ttlDiscountF.'</div>
						<div>'.$ttlTaxF.'</div>
						<div>'.$ttlDeliveryF.'</div>
						<div><b>'.$grandTotalF.'</b></div>';
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
			],
			'footer'=>true,
		],
	];

	$viewGrid= GridView::widget([
		'id'=>'po-review-id',
		'dataProvider'=> $dataProvider,
		'showPageSummary' => true,
		'columns' => $gridColumnsX,
		'pjax'=>true,
		'pjaxSettings'=>[
		'options'=>[
			'enablePushState'=>false,
			'id'=>'ro-review-id',
		   ],
		],
		/* 'panel' => [
			'footer'=>false,
			'heading'=>false,
		],
		'toolbar'=> [
			//'{items}',
		], */
		'hover'=>true, //cursor select
		'responsive'=>true,
		'responsiveWrap'=>true,
		'bordered'=>true,
		'striped'=>'4px',
		'autoXlFormat'=>true,
		'export' => false,
	]);

	/*
	 * SIGNATURE AUTH1 | CREATED
	 * Status Value Signature1 | PurchaseOrder
	 * Permission Edit [BTN_SIGN1==1] & [Status 0=process 1=CREATED]
	*/
	function SignCreated($poHeader){
		$title = Yii::t('app', 'Sign Hire');
		$options = [ 'id'=>'po-auth1',
					  'data-toggle'=>"modal",
					  'data-target'=>"#po-auth1-sign",
					  'class'=>'btn btn-warning btn-xs',
					  'style'=>['width'=>'100px'],
					  'title'=>'Detail'
		];
		$icon = '<span class="glyphicon glyphicon-retweet"></span>';
		$label = $icon . ' ' . $title;
		$url = Url::toRoute(['/purchasing/purchase-order/sign-auth1-view','kdpo'=>$poHeader->KD_PO]);
		//$options1['tabindex'] = '-1';
		$content = Html::a($label,$url, $options);
		return $content;
	}

	/*
	 * SIGNATURE AUTH2 | CHECKED
	 * Status Value Signature1 | PurchaseOrder
	 * Permission Edit [BTN_SIGN1==1] & [Status 0=process 1=CREATED]
	*/
	function SignChecked($poHeader){
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
		$url = Url::toRoute(['/purchasing/purchase-order/sign-auth2-view','kdpo'=>$poHeader->KD_PO]);
		//$options1['tabindex'] = '-1';
		$content = Html::a($label,$url, $options);
		return $content;
	}

	/*
	 * SIGNATURE AUTH3 | APPROVED
	 * Status Value Signature1 | PurchaseOrder
	 * Permission Edit [BTN_SIGN1==1] & [Status 0=process 1=CREATED]
	*/
	function SignApproved($poHeader){
		$title = Yii::t('app', 'Sign Hire');
		$options = [ 'id'=>'po-auth3',
					  'data-toggle'=>"modal",
					  'data-target'=>"#po-auth3-sign",
					  'class'=>'btn btn-warning btn-xs',
					  'style'=>['width'=>'100px'],
					  'title'=>'Detail'
		];
		$icon = '<span class="glyphicon glyphicon-retweet"></span>';
		$label = $icon . ' ' . $title;
		$url = Url::toRoute(['/purchasing/purchase-order/sign-auth3-view','kdpo'=>$poHeader->KD_PO]);
		//$options1['tabindex'] = '-1';
		$content = Html::a($label,$url, $options);
		return $content;
	}


 ?>
<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt;">
	<div  class="row">
	<!-- HEADER !-->
		<div class="col-md-12">
			<div class="col-md-1" style="float:left;">
				<?php echo Html::img('@web/upload/lukison.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']); ?>
			</div>
			<div class="col-md-9" style="padding-top:15px;">
				<h3 class="text-center"><b>PURCHASE ORDER</b></h3>
			</div>
			<div class="col-md-12" style="padding-left:0px;">
				<hr style="height:10px;margin-top: 1px; margin-bottom: 1px;color:#94cdf0">
			</div>

		</div>
	</div>
	<!-- Title HEADER Descript !-->
	<div  class="row">
		<div class="col-md-12" style="font-family: tahoma ;font-size: 9pt;float:left;">
			<div class="col-md-4">
				<dl>
					<dt><b><?= $sup->NM_SUPPLIER; ?></b></dt>
					<dt><?= $sup->ALAMAT; ?></dt>
					<dt><?= $sup->KOTA; ?></dt>
					<dt style="width:80px; float:left;">Telp / Fax</dt>
					<dd>: <?= $sup->TLP; ?> / <?= $sup->FAX; ?></dd>
					<dt style="width:80px; float:left;">Email</dt>
					<dd>: <?= $sup->EMAIL; ?></dd>
				</dl>
			</div>
			<div class="col-md-4"></div>
			<div class="col-md-4">
				<dl>
					<!-- Date !-->
					<dt style="width:80px; float:left;">Date</dt>
					<dd>: <?php echo date('d-M-Y'); ?></dd>
					<!-- PO NO !-->
					<dt style="width:80px; float:left;">No. Order</dt>
					<dd>: <?= $poHeader->KD_PO; ?></dd>
					<!-- Purchese Order Created !-->
					<dt style="width:80px; float:left;">Order By</dt>
					<dd>: <?php echo "alam@lukison.com"; ?></dd>
					<!-- Estimasi Time Arrival!-->
					<dt style="width:80px; float:left;">ETA</dt>
					<dd>: <?= $poHeader->ETD; ?></dd>
					<!-- Estimasi Time Delevery !-->
					<dt style="width:80px; float:left;">ETD</dt>
					<dd>: <?= $poHeader->ETA; ?></dd>
				</dl>
			</div>
		</div>
	</div>
	<!-- Title GRID PO Detail !-->
	<div  class="row">
		<div class="ccol-md-12"  style="float:none">

			<div class="col-md-12">

				<?php echo $viewGrid;?>
			</div>
		</div>
	</div>
	<!-- Title BOTTEM Descript !-->
	<div  class="row">
		<div class="col-md-12" style="font-family: tahoma ;font-size: 9pt;float:left;">
			<div class="col-md-4" style="float:left;">
				<dl>
					<?php
						$shipNm= $ship !='' ? $ship->NM_ALAMAT : 'Shipping Not Set';
						$shipAddress= $ship!='' ? $ship->ALAMAT_LENGKAP :'Address Not Set';
						$shipCity= $ship!='' ? $ship->KOTA : 'City Not Set';
						$shipPhone= $ship!='' ? $ship->TLP : 'Phone Not Set';
						$shipFax= $ship!='' ? $ship->FAX : 'Fax Not Set';
						$shipPic= $ship!='' ? $ship->CP : 'PIC not Set';
					?>
					<dt><h6><u><b>Shipping Address :</b></u></h6></dt>
					<dt><?=$shipNm; ?></dt>
					<dt><?=$shipAddress;?></dt>
					<dt><?=$shipCity?></dt>
					<dt style="width:80px; float:left;">Tlp</dt>
					<dd>:	<?=$shipPhone;?></dd>
					<dt style="width:80px; float:left;">FAX</dt>
					<dd>:	<?=$shipFax; ?></dd>
					<dt style="width:80px; float:left;">CP</dt>
					<dd>:	<?=$shipPic; ?></dd>
				</dl>
			</div>
			<div class="col-md-3"></div>
			<div class="col-md-4" style="float:left;">
				<dl>
					<?php
						$billNm= $bill !='' ? $bill->NM_ALAMAT : 'Billing Not Set';
						$billAddress= $bill!='' ? $bill->ALAMAT_LENGKAP :'Address Not Set';
						$billCity= $bill!='' ? $bill->KOTA : 'City Not Set';
						$billPhone= $bill!='' ? $bill->TLP : 'Phone Not Set';
						$billFax= $bill!='' ? $bill->FAX : 'Fax Not Set';
						$billPic= $bill!='' ? $bill->CP : 'PIC not Set';
					?>
					<dt><h6><u><b>Billing Address :</b></u></h6></dt>
					<dt><?=$billNm;?></dt>
					<dt><?=$billAddress;?></dt>
					<dt><?=$billCity;?></dt>

					<dt style="width:80px; float:left;">Tlp</dt>
					<dd>:	<?=$billPhone;?></dd>

					<dt style="width:80px; float:left;">FAX</dt>
					<dd>:	<?=$billFax;?></dd>

					<dt style="width:80px; float:left;">CP</dt>
					<dd>:	<?=$billPic;?></dd>
				</dl>
			</div>
		</div>
	</div>
	<!-- PO Term Of Payment !-->
	<div  class="row">
		<div  class="col-md-12" style="font-family: tahoma ;font-size: 9pt;">
			<dt><b>Term Of Payment :</b></dt>
			<hr style="height:1px;margin-top: 1px; margin-bottom: 1px;font-family: tahoma ;font-size:8pt;">
			<div>
				<div style="float:right;text-align:right;">
					<?php echo PoNoteTOP($poHeader); ?>
				</div>
				<div style="margin-left:5px">
					<dt style="width:80px; float:left;"><?php echo $poHeader->TOP_TYPE; ?></dt>
					<dd><?php echo $poHeader->TOP_DURATION; ?></dd>
					<br/>
				</div>
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
					<?php echo PoNote($poHeader); ?>
				</div>
				<div style="margin-left:5px">
					<dd><?php echo $poHeader->NOTE; ?></dd>
					<dt>Invoice exchange can be performed on Monday through Tuesday time of 09:00AM-16:00PM</dt>
				</div>
			</div>
			<hr style="height:1px;margin-top: 1px;">
		</div>
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
									$placeTgl1=$poHeader->SIG1_TGL!=0 ? Yii::$app->ambilKonvesi->convert($poHeader->SIG1_TGL,'date') :'';
									echo '<b>Tanggerang</b>,' . $placeTgl1;
								?>
							</div>

						</th>
						<!-- Tanggal Pembuat RO!-->
						<th class="col-md-1" style="text-align: center; height:20px">
							<div style="text-align:center;">
								<?php
									$placeTgl2=$poHeader->SIG2_TGL!=0 ? Yii::$app->ambilKonvesi->convert($poHeader->SIG2_TGL,'date') :'';
									echo '<b>Tanggerang</b>,' . $placeTgl2;
								?>
							</div>

						</th>
						<!-- Tanggal PO Approved!-->
						<th class="col-md-1" style="text-align: center; height:20px">
							<div style="text-align:center;">
								<?php
									$placeTgl3=$poHeader->SIG3_TGL!=0 ? Yii::$app->ambilKonvesi->convert($poHeader->SIG3_TGL,'date') :'';
									echo '<b>Tanggerang</b>,' . $placeTgl3;
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
								$ttd1 = $poHeader->SIG1_SVGBASE64!='' ?  '<img style="width:80; height:40px" src='.$poHeader->SIG1_SVGBASE64.'></img>' :SignCreated($poHeader);
								echo $ttd1;
							?>
						</th>
						<th class="col-md-1" style="text-align: center; vertical-align:middle">
							<?php
								$ttd2 = $poHeader->SIG2_SVGBASE64!='' ?  '<img style="width:80; height:40px" src='.$poHeader->SIG2_SVGBASE64.'></img>' :SignChecked($poHeader);
								echo $ttd2;
							?>
						</th>
						<th  class="col-md-1" style="text-align: center; vertical-align:middle">
							<?php
								$ttd3 = $poHeader->SIG3_SVGBASE64!='' ?  '<img style="width:80; height:40px" src='.$poHeader->SIG3_SVGBASE64.'></img>' :SignApproved($poHeader);
								//if ($poHeader->STATUS==101 OR $poHeader->STATUS==10){
									echo $ttd3;
								//}
							?>
						</th>
					</tr>
					<!--Nama !-->
					 <tr>
						<th class="col-md-1" style="text-align: center; vertical-align:middle;height:20; background-color:rgba(126, 189, 188, 0.3);text-align: center;">
							<div>
								<?php
									$sigNm1=$poHeader->SIG1_NM!='none' ? '<b>'.$poHeader->SIG1_NM.'</b>' : 'none';
									echo $sigNm1;
								?>
							</div>
						</th>
						<th class="col-md-1" style="text-align: center; vertical-align:middle;height:20; background-color:rgba(126, 189, 188, 0.3);text-align: center;">
							<div>
								<?php
									$sigNm2=$poHeader->SIG2_NM!='none' ? '<b>'.$poHeader->SIG2_NM.'</b>' : 'none';
									echo $sigNm2;
								?>
							</div>
						</th>
						<th class="col-md-1" style="text-align: center; vertical-align:middle;height:20; background-color:rgba(126, 189, 188, 0.3);text-align: center;">
							<div>
								<?php
									$sigNm3=$poHeader->SIG3_NM!='none' ? '<b>'.$poHeader->SIG3_NM.'</b>' : 'none';
									echo $sigNm3;
								?>
							</div>
						</th>
					</tr>
					<!-- Department|Jbatan !-->
					 <tr>
						<th style="text-align: center; vertical-align:middle;height:20">
							<div>
								<b><?php  echo 'Purchaser'; ?></b>
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
			<!-- Button Submit!-->
			<div style="text-align:right; margin-top:80px; margin-right:15px">
				<a href="/purchasing/purchase-order/" class="btn btn-info btn-xs" role="button" style="width:90px">Back</a>
				<?php echo Html::a('<i class="fa fa-print fa-fw"></i> Print', ['cetakpdf','kdpo'=>$poHeader->KD_PO], ['target' => '_blank', 'class' => 'btn btn-warning btn-xs']); ?>
				<?php echo Html::a('<i class="fa fa-print fa-fw"></i> tmp Print', ['temp-cetakpdf','kdpo'=>$poHeader->KD_PO], ['target' => '_blank', 'class' => 'btn btn-warning btn-xs']); ?>

			</div>
		</div>
	</div>
</div>
<?php
	/*
	 * JS AUTH1 | CREATED
	 * @author ptrnov <piter@lukison.com>
	 * @since 1.2
	*/
	$this->registerJs("
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};
			$('#po-auth1-sign').on('show.bs.modal', function (event) {
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
			'id' => 'po-auth1-sign',
			//'header' => '<h4 class="modal-title">Signature Authorize</h4>',
			'header' => '<div style="float:left;margin-right:10px">'. Html::img('@web/img_setting/login/login1.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']).'</div><div style="margin-top:10px;"><h4><b>Signature Authorize</b></h4></div>',
			//'size' => 'modal-xs'
			'size' => Modal::SIZE_SMALL,
			'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color:rgba(230, 251, 225, 1)'
			]
		]);
	Modal::end();

	/*
	 * JS AUTH2 | CHECKED
	 * @author ptrnov <piter@lukison.com>
	 * @since 1.2
	*/
	$this->registerJs("
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};
			$('#po-auth2-sign').on('show.bs.modal', function (event) {
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
			'id' => 'po-auth2-sign',
			//'header' => '<h4 class="modal-title">Signature Authorize</h4>',
			'header' => '<div style="float:left;margin-right:10px">'. Html::img('@web/img_setting/login/login1.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']).'</div><div style="margin-top:10px;"><h4><b>Signature Authorize</b></h4></div>',
			//'size' => 'modal-xs'
			'size' => Modal::SIZE_SMALL,
			'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color:rgba(230, 251, 225, 1)'
			]
		]);
	Modal::end();

	/*
	 * JS AUTH3 | APPROVED
	 * @author ptrnov <piter@lukison.com>
	 * @since 1.2
	*/
	$this->registerJs("
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};
			$('#po-auth3-sign').on('show.bs.modal', function (event) {
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
			'id' => 'po-auth3-sign',
			//'header' => '<h4 class="modal-title">Signature Authorize</h4>',
			'header' => '<div style="float:left;margin-right:10px">'. Html::img('@web/img_setting/login/login1.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']).'</div><div style="margin-top:10px;"><h4><b>Signature Authorize</b></h4></div>',
			//'size' => 'modal-xs'
			'size' => Modal::SIZE_SMALL,
			'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color:rgba(230, 251, 225, 1)'
			]
		]);
	Modal::end();

	/*
	 * Button Modal Confirm PERMISION DENAID
	 * @author ptrnov [piter@lukison]
	 * @since 1.2
	*/
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


	/*
	 * Action PO Detail
	*/
	$this->registerJs("
		$(document).on('click', '[data-toggle-approved]', function(e){
			e.preventDefault();
			var idx = $(this).data('toggle-approved');
			$.ajax({
					url: '/purchasing/purchase-order/approved_podetail',
					type: 'POST',
					//contentType: 'application/json; charset=utf-8',
					data:'id='+idx,
					dataType: 'json',
					success: function(result) {
						if (result == 1){
							// Success
							$.pjax.reload({container:'#po-review-id'});
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
					url: '/purchasing/purchase-order/reject_podetail',
					type: 'POST',
					//contentType: 'application/json; charset=utf-8',
					data:'id='+idx,
					dataType: 'json',
					success: function(result) {
						if (result == 1){
							$.pjax.reload({container:'#po-review-id'});
						}
					}
				});
		});
		$(document).on('click', '[data-toggle-delete]', function(e){
			e.preventDefault();
			var idx = $(this).data('toggle-delete');
			$.ajax({
					url: '/purchasing/purchase-order/delete_podetail',
					type: 'POST',
					//contentType: 'application/json; charset=utf-8',
					data:'id='+idx,
					dataType: 'json',
					success: function(result) {
						if (result == 1){
							$.pjax.reload({container:'#po-review-id'});
						}
					}
				});
		});

		$(document).on('click', '[data-toggle-cancel]', function(e){
			e.preventDefault();
			var idx = $(this).data('toggle-cancel');
			$.ajax({
					url: '/purchasing/purchase-order/cancel_podetail',
					type: 'POST',
					//contentType: 'application/json; charset=utf-8',
					data:'id='+idx,
					dataType: 'json',
					success: function(result) {
						if (result == 1){
							$.pjax.reload({container:'#po-review-id'});
						}
					}
				});
		});

	",$this::POS_READY);

	/*
	 * PO Note MODAL AJAX | ADD Items
	 * @author ptrnov <piter@lukison.com>
	 * @since 1.2
	*/
	$this->registerJs("
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};
			$('#po-note-review').on('show.bs.modal', function (event) {
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
			'id' => 'po-note-review',
			'header' => '<h4 class="modal-title">General Note</h4>',
			'size' => 'modal-md',
		]);
	Modal::end();

	/*
	 * PO Note term of payment
	 * @author ptrnov <piter@lukison.com>
	 * @since 1.2
	*/
	$this->registerJs("
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};
			$('#po-notetop-review').on('show.bs.modal', function (event) {
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
			'id' => 'po-notetop-review',
			'header' => '<h4 class="modal-title">Term Of Payment</h4>',
			'size' => 'modal-md',
		]);
	Modal::end();
?>
