<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use yii\db\ActiveQuery;
use yii\helpers\Url;

use lukisongroup\purchasing\models\Podetail;
use lukisongroup\purchasing\models\Purchasedetail;
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
            ['class' => 'yii\grid\SerialColumn'],
			'KD_BARANG',
            'NM_BARANG',
            'SQTY',
            'UNIT',
			[
				'class'=>'kartik\grid\CheckboxColumn',
				'headerOptions'=>['class'=>'kartik-sheet-style'], 
				
				/* 'checkboxOptions' => function($model, $key, $index, $column) {
					 return ['checked' => true];
				},  */
				 
				'checkboxOptions' => [
					'is'=>'ck-gv',
                    'class' => 'simple'
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
					return ['checked' => $model->TMP_CK];
				}  
			],
        ],
		'pjax'=>true,
		'pjaxSettings'=>[
		 'options'=>[
			'enablePushState'=>true,
			'id'=>'ck-gv',	
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

	$this->registerJs("	
		$(document).ready(function(){
			var keysRslt = $('#gv-ropo').yiiGridView('getSelectedRows');
			
			$('#gv-ropo input[type=checkbox]').change(function(){
				if (this.checked){
					var roKode = $('input:checkbox:checked').val();
				 };
				
				//var keys = $('#gv-ropo').yiiGridView('getSelectedRows');
				//var roKode = $('input:checkbox:checked').val();
				var roKode=\"".$kd_ro."\";
				var keysSelect = $('#gv-ropo').yiiGridView('getSelectedRows');
			
				$.ajax({
					url: '/purchasing/purchase-order/ck',
					type: 'POST',
					//data:{keylist: keys},//+'&value='+nilaick,
					data:{keyRslt: keysRslt,keysSelect:keysSelect,kdRo:roKode},//+'&value='+nilaick,
					dataType: 'json',
					success: function(result) {
						 if (result == 1){
							$.pjax.reload({container:'#gv-ropo'});
						}  
					}
				});
			});
		});
	
	
	/* $('#gv-ropo').on('click', function(e){
		e.preventDefault();
		var keys = $('#gv-ropo').yiiGridView('getSelectedRows');
		$.ajax({
				url: '/purchasing/purchase-order/ck',
				type: 'POST',
				data:'keylist='+keys,
				dataType: 'json',
				success: function(result) {
					 if (result == 1){
						//$.pjax.reload({container:'#gv-ropo'});
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
