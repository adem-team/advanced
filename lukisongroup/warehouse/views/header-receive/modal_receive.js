/**
 * ===============================
 * JS Modal wh-tab1-receive
 * Author	: ptr.nov2gmail.com
 * Update	: 21/01/2017
 * Version	: 2.1
 * ===============================
*/

/*
 * wh-tab1-receive-Create.
*/
$.fn.modal.Constructor.prototype.enforceFocus = function(){};	
$(document).on('click','#wh-tab1-receive-button-create', function(ehead){ 			  
	$('#wh-tab1-receive-modal-create').modal('show')
	.find('#wh-tab1-receive-modal-content-create').html('<i class=\"fa fa-2x fa-spinner fa-spin\"></i>')
	.load(ehead.target.value);
});

/*
 * wh-tab1-receive-View.
*/
$.fn.modal.Constructor.prototype.enforceFocus = function(){};	
$(document).on('click','#wh-tab1-receive-button-view', function(ehead){ 			  
	$('#wh-tab1-receive-modal-view').modal('show')
	.find('#wh-tab1-receive-modal-content-view').html('<i class=\"fa fa-2x fa-spinner fa-spin\"></i>')
	.load(ehead.target.value);
});

/*
 * wh-tab1-receive-Remainder.
*/
$.fn.modal.Constructor.prototype.enforceFocus = function(){};	
$(document).on('click','#wh-tab1-receive-button-remainder', function(ehead){ 			  
	$('#wh-tab1-receive-modal-remainder').modal('show')
	.find('#wh-tab1-receive-modal-content-remainder').html('<i class=\"fa fa-2x fa-spinner fa-spin\"></i>')
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
	'id'=>'wh-tab1-receive-button-view',
	'class'=>"btn btn-default btn-xs ",      
	'style'=>['text-align'=>'left','width'=>'170px', 'height'=>'25px','border'=> 'none'],
	]); 
*/

/*=========================================================================================*/