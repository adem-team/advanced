<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use yii\db\ActiveQuery;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use lukisongroup\purchasing\models\Podetail;
use lukisongroup\purchasing\models\Purchasedetail;
use lukisongroup\master\models\Unitbarang;	
?>

<?php 
/* $form = ActiveForm::begin([
    'method' => 'post',
    'action' => ['/purchasing/purchase-order/simpan'],
]); */


	echo GridView::widget([
		'id'=>'gv-ropo',
        'dataProvider' => $roDetailProvider,
        'columns' => [
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
					'is'=>'kd-brg',
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
				'attribute'=>'SQTY',
				'label'=>'SQty',						
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
				]
			],	
			[/* Attribute Unit Barang */
				'attribute'=>'UNIT',
				'mergeHeader'=>true,
				'label'=>'UoM',										
				'vAlign'=>'middle',	
				'hAlign'=>'right',	
				'value'=>function($model){
							$model=Unitbarang::find()->where('KD_UNIT="'.$model->UNIT. '"')->one();
							if (count($model)!=0){
								$UnitNm=$model->NM_UNIT;
							}else{
								$UnitNm='Not Set';
							}
							return $UnitNm;
				},
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
          	[/* Attribute TMP_CK CheckboxColumn */
				'class'=>'kartik\grid\CheckboxColumn',
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
					'readonly'=>true, 
					'style'=>[
							'text-align'=>'center',		
							'width'=>'150px',
							'font-family'=>'tahoma',
							'font-size'=>'8pt',	
							'border-left'=>'0px',									
					]
				],					
				/* 'checkboxOptions' => function($model, $key, $index, $column) {
					 return ['checked' => true];
				},  */				 
				'checkboxOptions' => [
					'is'=>'ck-gv',
                    'class' => 'simple',
					'style'=>[
						'text-align'=>'left',		
						'width'=>'150px',
						'font-family'=>'tahoma',
						'font-size'=>'8pt',	
						'border-left'=>'0px',									
					],
					//'value' =>function ($model, $key, $index, $column){ return ['value' => $model->KD_RO];}
                ],	  	
				'rowSelectedClass' => GridView::TYPE_WARNING, 
				
				//'class'=>'kartik\grid\EditableColumn',
				//'attribute'=>'STT_SEND_PO',
			/* 	'editableOptions' => function($model, $key, $index, $widget) { 
					return [
						'id'=>'cek-stt-po',
						'header' => 'Buy Amount',
						'inputType' => kartik\editable\Editable::INPUT_CHECKBOX_X,
						
					];
				}, */
				
				'checkboxOptions' => function ($model, $key, $index, $column) {
					$poDetail=Purchasedetail::find()->where(['KD_RO'=>$model->KD_RO,'KD_BARANG'=>$model->KD_BARANG])->one();
					if ($poDetail){
						return ['checked' => $model->TMP_CK, 'hidden'=>true];
						
					}else{
						return ['checked' => $model->TMP_CK];
					}
				}  
			],
        ],
		'pjax'=>true,
		'pjaxSettings'=>[
		 'options'=>[
			'enablePushState'=>true,
			'id'=>'gv-ropo',	
		   ],						  
		], 
		'hover'=>true, //cursor select
		'responsive'=>true,
		'responsiveWrap'=>true,
		'bordered'=>true,
		'striped'=>'4px',
		'autoXlFormat'=>true,
		'export' => false, 		
    ]); 
	
	
?>



<!--
	<input type="hidden" name="kdpo" value="<?php echo $kdpo; ?>" />
	<input type="hidden" name="kdro" value="<?php echo $kd_ro; ?>" />
	 input type="hidden" name="_csrf" value="< ?=Yii::$app->request->getCsrfToken()?>" 
	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-primary">Pilih Barang</button>
	</div>/ -->

<?php
/*  ActiveForm::end();  */

	/*
	 * JS GRIDVIEW SEND_TO_PO | CheckboxColumn
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.2
	*/
	/* $this->registerJs("	
		//$(document).ready(function(){
				//var keysRslt = $('#gv-ropo').yiiGridView('getSelectedRows');
			
			$('#gv-ropo input[type=checkbox]').change(function(e){	
				e.preventDefault();			
				//var keys = $('#gv-ropo').yiiGridView('getSelectedRows');
				//var roKode = $('input:checkbox:checked').val();
				var roKode=\"".$kd_ro."\";
				var keysSelect = $('#gv-ropo').yiiGridView('getSelectedRows');
				//var keysKdBrg = $('#gv-ropo').yiiGridView('getSelectedRows');
				//var kdBrg=$('#kd-brg input[type=text]').val();
				$.ajax({
					
					url: '/purchasing/purchase-order/ck',
                    //cache: true,
					type: 'POST',
					//data:{keylist: keys},//+'&value='+nilaick,
					//data:{keyRslt: keysRslt,keysSelect:keysSelect,kdBrg:keysKdBrg[1],kdRo:roKode},//+'&value='+nilaick,
					data:{keysSelect:keysSelect,kdRo:roKode},
					dataType: 'json',
					success: function(response) {
						if (response.status==true){
							$('#ck-gv').val();
							 //location.reload();
							//$.pjax.refresh('#ck-gv');
							//$(url).modal('open');
							alert(response.status);
							//print_r(data);
							 // $('#ro-sendpo .modal-body').load(target, function() { 
							//	 $('#ro-sendpo').modal('show'); 
							//});
						}else {
							alert(response.status);
						}
					} 
				});
			});
		//});
	",$this::POS_READY); */
	
	$this->registerJs("	
		
			var target = $(this).attr('href');
				$('#gv-ropo input[type=checkbox]').change(function(){	
					var roKode=\"".$kd_ro."\";
					var keysSelect = $('#gv-ropo').yiiGridView('getSelectedRows');		
					$.ajax({					
						url: '/purchasing/purchase-order/ck',
						//cache: true,
						type: 'POST',
						//data:{keylist: keys},//+'&value='+nilaick,
						//data:{keyRslt: keysRslt,keysSelect:keysSelect,kdBrg:keysKdBrg[1],kdRo:roKode},//+'&value='+nilaick,
						data:{keysSelect:keysSelect,kdRo:roKode},
						dataType: 'json',
						success: function(response) {
							if (response.status==true){
									//$.pjax.reload('#gv-ropo');
									//$.reload({container:'#gv-ropo', timeout: 2000});
									//alert(response.status);
									
							}else {
								//alert(response.status);							
								//$.pjax.reload('#gv-ropo');
								//$('this').checked = false
								//document.getElementById('gv-ropo').checked = false;
								//$('#ck-gv').checked = false;
								//$('input:checkbox[name=checkme]').attr('checked',false);
							}
						} 
					});
				});			
			
	",$this::POS_READY);
	
	$this->registerJs("		
	/* $('#gv-ropo').on('click', function(e){
		e.preventDefault();
		var keys = $('#gv-ropo').yiiGridView('getSelectedRows');
		if (this.checked){
					''var roKode = $('input:checkbox:checked').val();
				 }; 
		$.ajax({
				url: '/purchasing/purchase-order/ck',
				type: 'POST',
				data:'keylist='+keys,
				dataType: 'json',
				success: function(respo) {
					 if (result === true){
						//$.pjax.reload({container:'#gv-ropo'});
					} else {
						 alert('I did it! Processed checked rows.')
					} 
				}
			});
	}); */
	
	
	 /* $('#gv-ropo').on('click',function(){
			var keys = $('#gv-ropo').yiiGridView('getSelectedRows');
			$.post({
			   url: '/purchasing/purchase-order/ck', // your controller action
			   dataType: 'json',
			   data: {keylist: keys},
			   success: function(data) {
				  alert('I did it! Processed checked rows.')
			   },
			});		
	});  */
	 
	/* $(document).ready(function(){
		$('#gv-ropo input[type=checkbox]').click(function(){
			var keys = $('#gv-ropo').yiiGridView('getSelectedRows');
			alert(keys[0]);
		});
	});   */
	

	
	
	/* var checkedVal = [];
	$('input.new-module').each(function() {
        // get only those not disabled
        if(!$(this).prop('disabled'))
        {      
            console.log($(this).val() + ' checked is ' + $(this).prop('checked'));

            if($(this).prop('checked') === true)
            {
                checkedVal.push($(this).val());
            }
            else // if the checkbox is not checked
            {           
                var indexInArray = $.inArray($(this).val(), checkedVal)

                // if found in array
                if (indexInArray >= 0){
                    checkedVal.splice(indexInArray, 1); // remove ONE unchecked checkbox value in current page from the array using index of array
                }

            }
        }
        else if($(this).prop('disabled'))
        {
            console.log($(this).val() + ' disabled is ' + $(this).prop('disabled'));
            console.log($(this).val() + ' checked is ' + $(this).prop('checked'));
        }

    }); */
	",$this::POS_READY);













 ?>
