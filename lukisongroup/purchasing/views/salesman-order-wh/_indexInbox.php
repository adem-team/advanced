
<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\helpers\Json;
use yii\web\Request;
use kartik\daterange\DateRangePicker;
use kartik\tabs\TabsX;
use yii\widgets\ListView;
use yii\data\ArrayDataProvider;

use lukisongroup\purchasing\models\salesmanorder\SoDetailSearch;


use lukisongroup\purchasing\models\so\Sodetail;
use lukisongroup\master\models\Unitbarang;
use lukisongroup\hrd\models\Employe;
use lukisongroup\hrd\models\Dept;

	/*
	 * Declaration Componen User Permission
	 * Function getPermissionInbox
	 * Modul Name[2=SO]
	*/
	function getPermissionInbox(){
		if (Yii::$app->getUserOpt->Modul_akses(2)){
			return Yii::$app->getUserOpt->Modul_akses(2);
		}else{
			return false;
		}
	}

	$getPermissionInboxCheeck = getPermissionInbox();

	//print_r(getPermissionInbox());
	/*
	 * Declaration Componen User Permission
	 * Function profile_user
	*/
	function getPermissionInboxEmp(){
		if (Yii::$app->getUserOpt->profile_user()){
			return Yii::$app->getUserOpt->profile_user()->emp;
		}else{
			return false;
		}
	}
	//print_r(getPermissionInboxEmp());

	/*
	 * Tombol Modul Create
	 * permission crate Ro
	*/
	function tombolCreateInbox(){
		if(getPermissionInbox()){
			if(getPermissionInbox()->BTN_CREATE==1){
				$title1 = Yii::t('app', 'New');
				$options1 = [ 'id'=>'so-create',
							  'data-toggle'=>"modal",
							  'data-target'=>"#new-so",
							  'class' => 'btn btn-warning  btn-xs',
				];
				$icon1 = '<span class="fa fa-plus fa-xs"></span>';
				$label1 = $icon1 . ' ' . $title1;
				$url1 = Url::toRoute(['/purchasing/sales-order/create']);
				//$options1['tabindex'] = '-1';
				$content = Html::a($label1,$url1, $options1);
				return $content;
			}else{
				$title1 = Yii::t('app', 'New');
				$options1 = [ 'id'=>'so-create',
							  'class' => 'btn btn-warning btn-xs',
								'data-toggle'=>"modal",
							  'data-target'=>"#confirm-permission-alert-so",
				];
				$icon1 = '<span class="fa fa-plus fa-xs"></span>';
				$label1 = $icon1 . ' ' . $title1;
				$url1 = Url::toRoute(['#']);
				//$options1['tabindex'] = '-1';
				$content = Html::a($label1,$url1, $options1);
				return $content;
			};
		}else{
				$title1 = Yii::t('app', 'New');
				$options1 = [ 'id'=>'so-create',
							  'class' => 'btn btn-warning  btn-xs',
								'data-toggle'=>"modal",
								'data-target'=>"#confirm-permission-alert-so",
				];
				$icon1 = '<span class="fa fa-plus fa-xs"></span>';
				$label1 = $icon1 . ' ' . $title1;
				$url1 = Url::toRoute(['#']);
				//$options1['tabindex'] = '-1';
				$content = Html::a($label1,$url1, $options1);
				return $content;
		}
	}

	/*
	 * Tombol Modul Barang
	 * No Permission
	*/
	function tombolBarangInbox(){
	$title = Yii::t('app', 'Barang');
	$options = ['id'=>'ro-barang',
				'data-toggle'=>"modal",
				'data-target'=>"#check-barang",
				'class' => 'btn btn-default  btn-xs'
	];
	$icon = '<span class="glyphicon glyphicon-search"></span>';
	$label = $icon . ' ' . $title;
	$url = Url::toRoute(['/purchasing/sales-order/create']);
	$content = Html::a($label,$url, $options);
	return $content;
}

	/*
	 * Tombol Modul Barang Kategori
	 * No Permission
	*/
	function tombolKategoriInbox(){
	$title = Yii::t('app', 'Kategori');
	$options = ['id'=>'ro-kategori',
				'data-toggle'=>"modal",
				'data-target'=>"#check-kategori",
				'class' => 'btn btn-default  btn-xs'
	];
	$icon = '<span class="glyphicon glyphicon-search"></span>';
	$label = $icon . ' ' . $title;
	$url = Url::toRoute(['/purchasing/sales-order/create']);
	$content = Html::a($label,$url, $options);
	return $content;
}

	/*
	 * Tombol Modul View
	 * permission View [BTN_VIEW==1]
	 * Check By User login
	*/
	function tombolViewInbox($url, $model){
		if(getPermissionInbox()){
			if(getPermissionInbox()->BTN_VIEW==1){
				$title = Yii::t('app', 'View');
				$options = [ 'id'=>'ro-view'];
				$icon = '<span class="glyphicon glyphicon-zoom-in"></span>';
				$label = $icon . ' ' . $title;
				$url = Url::toRoute(['/purchasing/sales-order/view','kd'=>$model->KD_RO]);
				$options['tabindex'] = '-1';
				return '<li>' . Html::a($label, $url, $options) . '</li>' . PHP_EOL;
			}
		}
	}

	/*
	 * Tombol Modul Edit -> Check By User login
	 * Permission Edit [BTN_VIEW==1] & [Status 0=process 103=Approved]
	 * EMP_ID=UserLogin & BTN_EDIT==1 &  Status 0 = Action Edit Show/bisa edit
	 * EMP_ID=UserLogin & BTN_EDIT==1 &  Status 0 = Action Edit Hide/tidak bisa edit
	 * 1. Hanya User login yang bisa melakukan Edit Request Order yang sudah di Create user tersebut (Tanpa Kecuali)
	 * 2. Action EDIT Akan close atau tidak bisa di lakukan jika sudah Approved | status Approved =103 | Permission sign1
	*/
	function tombolEditInbox($url, $model){
		if(getPermissionInbox()){
			if(getPermissionInboxEmp()->EMP_ID == $model->ID_USER AND getPermissionInbox()->BTN_EDIT==1){
				 if($model->STATUS == 0){ // 0=process 101=Approved
					$title = Yii::t('app', 'Edit Detail');
					$options = [ //'id'=>'ro-edit',
								//'data-toggle'=>"modal",
								//'data-target'=>"#add-ro",
								//'data-confirm'=>'Anda yakin ingin menghapus RO ini?',
					];
					$icon = '<span class="fa fa-pencil-square-o fa-lg"></span>';
					$label = $icon . ' ' . $title;
					$url = Url::toRoute(['/purchasing/sales-order/edit','kd'=>$model->KD_RO]);
					$options['tabindex'] = '-1';
					return '<li>' . Html::a($label, $url, $options) . '</li>' . PHP_EOL;
				}
			}
		}
	}

	/*
	 * Tombol Modul Delete -> Check By User login
	 * Permission Edit [BTN_DELETE==1] & [Status 0=process 103=Approved]
	 * EMP_ID=UserLogin & BTN_DELETE==1 &  Status 0 = Action Edit Show/bisa edit
	 * EMP_ID=UserLogin & BTN_DELETE==1 &  Status 0 = Action Edit Hide/tidak bisa edit
	 * 1. Hanya User login yang bisa melakukan DELETE Request Order yang sudah di Create user tersebut (Tanpa Kecuali)
	 * 2. Action DELETE  Akan close atau tidak bisa di lakukan jika sudah Approved | status Approved =103 | Permission sign1
	*/
	function tombolDeleteInbox($url, $model){
		if(getPermissionInbox()){
			if(getPermissionInboxEmp()->EMP_ID == $model->ID_USER AND getPermissionInbox()->BTN_DELETE==1){
				if($model->STATUS == 0){ // 0=process 101=Approved
					$title = Yii::t('app', 'Delete');
					$options = [ 'id'=>'ro-delete',
								'data-confirm'=>'Anda yakin ingin menghapus RO ini?',
					];
					$icon = '<span class="fa fa-trash-o fa-lg"></span>';
					$label = $icon . ' ' . $title;
					$url = Url::toRoute(['/purchasing/sales-order/hapusro','kd'=>$model->KD_RO]);
					$options['tabindex'] = '-1';
					return '<li>' . Html::a($label, $url, $options) . '</li>' . PHP_EOL;
				}
			}
		}
	}

	/*
	 * Tombol Modul Approval -> Check By User login
	 * Permission Edit [BTN_SIGN1==1] & [Status 0=process 101=Approved]
	 * EMP_ID=UserLogin & BTN_SIGN1==1 &  Status 0 = Action Edit Show/bisa edit
	 * EMP_ID=UserLogin & BTN_SIGN1==1 &  Status 0 = Action Edit Hide/tidak bisa edit
	 * 1. Hanya User login dengan permission modul RO=1 dengan BTN_SIGN1==1 dan Permission Jabatan SVP keatas yang bisa melakukan Approval (Tanpa Kecuali)
	 * 2. Action APPROVAL Akan close atau tidak bisa di lakukan jika sudah Approved | status Approved =101 | Permission sign1
	*/
	function tombolReviewInbox($url, $model){
		//$kd=($model['KD_SO_HEADER']!='' AND $model['KD_SO_DETAIL']=='')?$model['KD_SO_HEADER']:($model['KD_SO_HEADER']!='' AND $model['KD_SO_DETAIL']!='')?$model['KD_SO_HEADER']:$model['KD_SO_DETAIL'];
		$kd=($model['KD_SO_HEADER']=='' AND $model['KD_SO_DETAIL']=='')?$model['ID']:($model['KD_SO_HEADER']!='' AND $model['KD_SO_DETAIL']=='')?$model['KD_SO_HEADER']:$model['KD_SO_HEADER'];
		$kdstt=($model['KD_SO_HEADER']=='' AND $model['KD_SO_DETAIL']=='')!=''?0:1;
		$title = Yii::t('app', 'Review');
				$options = [ 'id'=>'so-review-inbox'];
				$icon = '<span class="glyphicon glyphicon-ok"></span>';
				$label = $icon . ' ' . $title;
				$url = Url::toRoute(['/purchasing/salesman-order/review','id'=>$kd,'stt'=>$kdstt]);
				$options['tabindex'] = '-1';
				return '<li>' . Html::a($label, $url, $options) . '</li>' . PHP_EOL;
	}


	//Pjax::end();
	/*
	 * STATUS FLOW DATA
	 * 1. NEW		= 0 	| Create First
	 * 2. APPROVED	= 1 	| Item Approved
	 * 3. PROCESS	= 101	| Sign Auth1 | Data Sudah di buat dan di tanda tangani
	 * 4. CHECKED	= 102	| Sign Auth2 | Data Sudah Di Check  dan di tanda tangani
	 * 5. APPROVED	= 103	| Sign Auth3 | Data Sudah Di disetujui dan di tanda tangani
	 * 6. DELETE	= 3 	| Data Hidden | Data Di hapus oleh pembuat petama, jika belum di Approved
	 * 7. REJECT	= 4		| Data tidak di setujui oleh manager atau Atasan  lain
	 * 8. UNKNOWN	<>		| Data Tidak valid atau tidak sah
	*/
	function statusProcessRo($model){
		if($model->STATUS==0){
			return Html::a('<i class="glyphicon glyphicon-retweet"></i> New', '#',['class'=>'btn btn-info btn-xs', 'style'=>['width'=>'100px'],'title'=>'Detail']);
		}elseif($model->STATUS==1){
			return Html::a('<i class="glyphicon glyphicon-ok"></i> Approved', '#',['class'=>'btn btn-success btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
		}elseif ($model->STATUS==3){
			return Html::a('<i class="glyphicon glyphicon-remove"></i> DELETE', '#',['class'=>'btn btn-danger btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
		}elseif ($model->STATUS==4){
			return Html::a('<i class="glyphicon glyphicon-thumbs-down"></i> REJECT', '#',['class'=>'btn btn-danger btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
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

	$Combo_Dept = ArrayHelper::map(Dept::find()->orderBy('SORT')->asArray()->all(), 'DEP_NM','DEP_NM');
	
	$columnIndexInbox= [
		/*No Urut*/
		[
			'class'=>'kartik\grid\SerialColumn',
			'contentOptions'=>['class'=>'kartik-sheet-style'],
			'width'=>'10px',
			'header'=>'No.',
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'10px',
					'font-family'=>'verdana, arial, sans-serif',
					'font-size'=>'7pt',
					'background-color'=>'rgba(97, 211, 96, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'10px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
				]
			],
		],
		[
			'class'=>'kartik\grid\ExpandRowColumn',
			'width'=>'50px',
			'header'=>'Detail',
			'value'=>function ($model, $key, $index, $column) {
				return GridView::ROW_COLLAPSED;
			},
			'detail'=>function ($model, $key, $index, $column){


				/* $aryProviderSoDetailInbox= new ArrayDataProvider([
					'allModels'=>Yii::$app->db_esm->createCommand("
						SELECT x1.ID,x1.TGL,x1.WAKTU_INPUT_INVENTORY,x1.CUST_KD,x1.CUST_NM,x1.KD_BARANG,x1.NM_BARANG,x1.SO_QTY,x1.SO_TYPE,x1.POS,x1.STATUS,x1.ID_GROUP,
							x1.HARGA_PABRIK,x1.HARGA_DIS,x1.HARGA_LG,x1.HARGA_SALES,
							x1.KODE_REF,x1.USER_ID,x2.username,x3.NM_FIRST,x1.SUBMIT_QTY,x1.SUBMIT_PRICE,x1.NOTED,x4.ISI_MESSAGES,x5.CHECKIN_TIME,x5.CHECKOUT_TIME,
							x6.PIC,x6.TLP1,x6.KTP,x6.NPWP,x6.SIUP,x6.ALAMAT,x6.JOIN_DATE,x6.TLP1,x6.TLP2,x8.NM_UNIT,x8.QTY AS UNIT_QTY,x7.HARGA_SALES,
							(x1.SO_QTY/x8.QTY) AS UNIT_BRG,
							(x1.SO_QTY * x7.HARGA_SALES) as SUB_TOTAL,
							(x1.SUBMIT_QTY * x1.SUBMIT_PRICE) as SUBMIT_SUB_TOTAL,
							x1.KODE_REF
						FROM so_t2 x1 
							LEFT JOIN dbm001.user x2 ON x2.id=x1.USER_ID
							LEFT JOIN dbm_086.user_profile x3 ON x3.ID_USER=x2.id
							LEFT JOIN c0014 x4 on x4.TGL=x1.TGL AND x4.ID_USER=x1.USER_ID
							LEFT JOIN c0002scdl_detail x5 on x5.TGL=x1.TGL AND x5.CUST_ID=x1.CUST_KD
							LEFT JOIN c0001 x6 on x6.CUST_KD=x1.CUST_KD
							LEFT JOIN b0001 x7 on x7.KD_BARANG=x1.KD_BARANG
							LEFT JOIN ub0001 x8 on x8.KD_UNIT=x7.KD_UNIT
							LEFT JOIN so_0001 x9 on x9.KD_SO=x1.KODE_REF
						WHERE x1.SO_TYPE=".$model['SO_TYPE']." AND x1.TGL='".$model['TGL']."' AND x1.CUST_KD='".$model['CUST_KD']."';#CUS.2016.000638,CUS.2016.000619
					")->queryAll(),
					'pagination' => [
						'pageSize' => 1000,
					]
				]); */
				$searchModelDetailx = new SoDetailSearch([
					// 'TGL'=>$model['TGL'],

					'KODE_REF'=>$model['KODE_REF'],
					'CUST_KD'=>$model['CUST_KD'],
					'USER_ID'=>$model['USER_ID'],
				]);
				$aryProviderSoDetailInbox = $searchModelDetailx->searchDetail1(Yii::$app->request->queryParams);
				return Yii::$app->controller->renderPartial('_indexInboxExpand1',[
					'model'=>$model,
					'aryProviderSoDetailInbox2'=>$aryProviderSoDetailInbox,
					'searchModelDetailx'=>$searchModelDetailx
				]); 
			},
			'collapseTitle'=>'Close Exploler',
			'expandTitle'=>'Click to views detail',
			
			//'headerOptions'=>['class'=>'kartik-sheet-style'] ,
			// 'allowBatchToggle'=>true,
			'expandOneOnly'=>true,
			// 'enableRowClick'=>true,
			//'disabled'=>true,
			'headerOptions'=>[
				'style'=>[
					
					'text-align'=>'center',
					'width'=>'10px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
					'background-color'=>'rgba(74, 206, 231, 1)',
				]
			],
			'contentOptions'=>[
				'style'=>[
				
					'text-align'=>'center',
					'width'=>'10px',
					'height'=>'10px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
				]
			],
		],
		/*KD_RO*/
		[
			'attribute'=>'KODE_REF',
			'label'=>'Kode SO',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			//'group'=>true,
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'130px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
					'background-color'=>'rgba(97, 211, 96, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
					'width'=>'130px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
				]
			],
		],
		/*CREATE_AT Tanggal Pembuatan*/
		[
			'attribute'=>'TGL',
			'label'=>'Create At',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			//'value'=>function($model){
				/*
				 * max String Disply
				 * @author ptrnov <piter@lukison.com>
				*/
			//	return substr($model->username, 0, 10);
			//},
			'filterType'=> \kartik\grid\GridView::FILTER_DATE_RANGE,
						'filterWidgetOptions' =>([
							'attribute' =>'CREATED_AT',
							'presetDropdown'=>TRUE,
							'convertFormat'=>true,
							'pluginOptions'=>[
								'id'=>'tglpo',
								'format'=>'Y/m/d',
								'separator' => ' - ',
								'opens'=>'right'
							]
			]),
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'90px',
					'font-family'=>'verdana, arial, sans-serif',
					'font-size'=>'7pt',
					'background-color'=>'rgba(97, 211, 96, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
					'width'=>'90px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt'
				]
			],
		],
		/*CUSTOMER*/
		[
			'attribute'=>'CUST_NM',
			'label'=>'Customer',
			//'filter' => $Combo_Dept,
			'hAlign'=>'left',
			'vAlign'=>'middle',
			//'group'=>true,
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'190px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
					'background-color'=>'rgba(97, 211, 96, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
					'width'=>'190px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
				]
			],
		],
		/*Chck.IN*/
		[
			'attribute'=>'CHECKIN_TIME',
			'label'=>'Time.IN',
			//'filter' => $Combo_Dept,
			'hAlign'=>'left',
			'vAlign'=>'middle',
			//'group'=>true,
			'value'=>function($model){
				return substr($model['CHECKIN_TIME'], 8, 8);
			},
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'50px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
					'background-color'=>'rgba(97, 211, 96, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
					'width'=>'50px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
				]
			],
		],
		/*Chck.OUT*/
		[
			'attribute'=>'CHECKOUT_TIME',
			'label'=>'Time.IN',
			//'filter' => $Combo_Dept,
			'hAlign'=>'left',
			'vAlign'=>'middle',
			//'group'=>true,
			'value'=>function($model){
				return substr($model['CHECKOUT_TIME'], 8, 8);
			},
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'50px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
					'background-color'=>'rgba(97, 211, 96, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
					'width'=>'50px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
				]
			],
		],
		/*DIBUAT*/
		[
			'attribute'=>'NM_FIRST',
			'label'=>'Created',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			//'group'=>true,
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'120px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
					'background-color'=>'rgba(97, 211, 96, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
					'width'=>'120px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
				]
			],
		],
		/*DIPERIKSA*/
		[
			'attribute'=>'SIG2_NM',
			'label'=>'Checked',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			//'group'=>true,
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'120px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
					'background-color'=>'rgba(97, 211, 96, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
					'width'=>'120px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
				]
			],
		],
		/*DISETUJUI*/
		[
			'attribute'=>'SIG3_NM',
			'label'=>'Approved',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			//'group'=>true,
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'120px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
					'background-color'=>'rgba(97, 211, 96, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
					'width'=>'120px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
				]
			],
		],
		/*Action*/
		[
			'class'=>'kartik\grid\ActionColumn',
			'dropdown' => true,
			'template' => '{view}{tambahEdit}{delete}{review}{closed}',
			'dropdownOptions'=>['class'=>'pull-right dropup'],
			//'headerOptions'=>['class'=>'kartik-sheet-style'],
			'dropdownButton'=>['class'=>'btn btn-default btn-xs'],
			'buttons' => [
				/* View RO | Permissian All */
				'view' => function ($url, $model) {
								return tombolViewInbox($url, $model);
						  },

				/* View RO | Permissian Status 0; 0=process | User created = user login  */
				'tambahEdit' => function ($url, $model) {
								return tombolEditInbox($url, $model);
							},

				/* Delete RO | Permissian Status 0; 0=process | User created = user login */
				'delete' => function ($url, $model) {
								return tombolDeleteInbox($url, $model);
							},

				/* Approved RO | Permissian Status 0; 0=process | Dept = Dept login | GF >= M */
				'review' => function ($url, $model) {
								return tombolReviewInbox($url, $model);
							},
				 'closed' => function ($url, $model) use ($getPermissionInboxCheeck){
								if ($getPermissionInboxCheeck['BTN_VIEW']==0) {
									return Html::label('<i class="glyphicon glyphicon-lock dm"></i> LOCKED','',['class'=>'label label-danger','style'=>['align'=>'center']]);
									//return  tombolKonci($url, $model);
								}
							},

			],
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'140px',
					'font-family'=>'verdana, arial, sans-serif',
					'font-size'=>'7pt',
					'background-color'=>'rgba(97, 211, 96, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'140px',
					'height'=>'10px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
				]
			],
		],
		[
			'label'=>'Notification',
			'mergeHeader'=>true,
			'format' => 'raw',
			'hAlign'=>'center',
			'value' => function ($model) {
							return statusProcessRo($model);
			},
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'130px',
					'font-family'=>'verdana, arial, sans-serif',
					'font-size'=>'7pt',
					'background-color'=>'rgba(97, 211, 96, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'130px',
					'height'=>'10px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
				]
			],
		],

	];

	
	
	/*
	 * INBOX SALESAN ORDER - MD Sales
	 * ACTION CHECKED or APPROVED
	 * @author ptrnov [piter@lukison]
	 * @since 1.2
	*/
	$_gvInboxSo= GridView::widget([
		'id'=>'gv-so-md-inbox',
		'dataProvider'=> $apSoHeaderInbox,
		// 'filterModel' => $searchModel,
		'filterRowOptions'=>['style'=>'background-color:rgba(97, 211, 96, 0.3); align:center'],
		'columns' =>$columnIndexInbox,		
		'pjax'=>false,
		'pjaxSettings'=>[
			'options'=>[
				'enablePushState'=>false,
				'id'=>'gv-so-md-inbox',
			   ],
		],
		'hover'=>true, //cursor select
		'responsive'=>true,
		'responsiveWrap'=>true,
		'bordered'=>true,
		'striped'=>'4px',
		'autoXlFormat'=>true,
		'export' => false,
		'toolbar'=> [''
				//['content'=>''],
				//'{export}',
				//'{toggleData}',
			],
		'panel'=>[
			'type'=>GridView::TYPE_DANGER,
			'heading'=>"<span class='fa fa-cart-plus fa-xs'><b> LIST SALES ORDER</b></span>",
		],
	]);
	?>


	<?php
	$this->registerJs("
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};
			$('#confirm-permission-alert-so').on('show.bs.modal', function (event) {
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
			'id' => 'confirm-permission-alert-so',
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
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};
			$('#new-so').on('show.bs.modal', function (event) {
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
			'id' => 'new-so',
			//'header' => '<h4 class="modal-title">Entry Request Order</h4>',
			'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">Entry Items Sales Order</h4></div>',
			'size' => 'modal-md',
			'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
			]
		]);
		Modal::end();

		$this->registerJs("
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};
			$('#add-ro').on('show.bs.modal', function (event) {
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
			'id' => 'add-ro',
			'header' => '<h4 class="modal-title">Entry Request Order</h4>',
			'size' => 'modal-lg',
			'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color:rgba(97, 211, 96, 0.3);'
			]
		]);
		Modal::end();

		$this->registerJs("
			/* $(document).on('click', '[data-toggle-reviewinbox1]', function(e){
				e.preventDefault();
				var id = $(this).data('toggle-reviewinbox');
				$.ajax({
					url: '/purchasing/salesman-order/review',
					type: 'POST',
					data:'kd='+id,
					dataType: 'json',
					success: function(response) {
						console.log('sukses');						
					}					
				});
			}); */
		",$this::POS_READY);

	?>
<?=$_gvInboxSo?>
