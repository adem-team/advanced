/**
 * ===============================
 * JS Modal SalesPromo
 * Author	: ptr.nov2gmail.com
 * Update	: 21/01/2017
 * Version	: 2.1
 * ===============================
*/

/*
 * SalesPromo-Create.
*/
$.fn.modal.Constructor.prototype.enforceFocus = function(){};	
$(document).on('click','#salespromo-button-create', function(ehead){ 			  
	$('#salespromo-modal-create').modal('show')
	.find('#salespromo-modal-content-create').html('<i class=\"fa fa-2x fa-spinner fa-spin\"></i>')
	.load(ehead.target.value);
});

/*
 * SalesPromo-View.
*/
$.fn.modal.Constructor.prototype.enforceFocus = function(){};	
$(document).on('click','#salespromo-button-view', function(ehead){ 			  
	$('#salespromo-modal-view').modal('show')
	.find('#salespromo-modal-content-view').html('<i class=\"fa fa-2x fa-spinner fa-spin\"></i>')
	.load(ehead.target.value);
});

/*
 * SalesPromo-REview.
*/
$.fn.modal.Constructor.prototype.enforceFocus = function(){};	
$(document).on('click','#salespromo-button-review', function(ehead){ 			  
	$('#salespromo-modal-review').modal('show')
	.find('#salespromo-modal-content-review').html('<i class=\"fa fa-2x fa-spinner fa-spin\"></i>')
	.load(ehead.target.value);
});

/*
 * SalesPromo-Remainder.
*/
$.fn.modal.Constructor.prototype.enforceFocus = function(){};	
$(document).on('click','#salespromo-button-remainder', function(ehead){ 			  
	$('#salespromo-modal-remainder').modal('show')
	.find('#salespromo-modal-content-remainder').html('<i class=\"fa fa-2x fa-spinner fa-spin\"></i>')
	.load(ehead.target.value);
});

/*
 * SalesPromo-Export-Excel.
*/
$.fn.modal.Constructor.prototype.enforceFocus = function(){};	
$(document).on('click','#salespromo-button-export-excel', function(ehead){ 			  
	$('#salespromo-modal-export-excel').modal('show')
	.find('#salespromo-modal-content-export-excel').html('<i class=\"fa fa-2x fa-spinner fa-spin\"></i>')
	.load(ehead.target.value);
});


/**
 * ======================================== TIPS ========================================
 * HELPER INCLUDE FILE
 * include 	: index.php [MODAL JS AND CONTENT].
 * File		: modal_salespromo.js And modal_salespromo.php
 * Version	: 2.1
*/
/* 
	$this->registerJs($this->render('modal_salespromo.js'),View::POS_READY);
	echo $this->render('modal_salespromo');
*/

/**
 * HELPER BUTTON 
 * Action 	: Button
 * include	: View
 * Version	: 2.1
*/
/* 
	return  Html::button(Yii::t('app', 
		'<span class="fa-stack fa-xs">																	
			<i class="fa fa-circle fa-stack-2x " style="color:#f08f2e"></i>
			<i class="fa fa-cart-arrow-down fa-stack-1x" style="color:#fbfbfb"></i>
		</span> View Customers'
	),
	['value'=>url::to(['/marketing/sales-promo/view','id'=>$model->ID]),
	'id'=>'salespromo-button-view',
	'class'=>"btn btn-default btn-xs ",      
	'style'=>['text-align'=>'left','width'=>'170px', 'height'=>'25px','border'=> 'none'],
	]); 
*/

/*=========================================================================================*/