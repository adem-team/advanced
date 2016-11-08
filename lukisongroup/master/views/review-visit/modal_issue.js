  $.fn.modal.Constructor.prototype.enforceFocus = function(){};	
		$(document).on('click','#modalButtonIssueTgl', function(ehead){ 			  
			$('#modal-issue-tgl').modal('show')
			.find('#modalContentIssueTgl')
			.load(ehead.target.value);
		});

 $.fn.modal.Constructor.prototype.enforceFocus = function(){};	
		$(document).on('click','#modal-btn-issue', function(ehead){ 			  
			$('#modal-issue').modal('show')
			.find('#modalContentIssue')
			.load(ehead.target.value);
		});


