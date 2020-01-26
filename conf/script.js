$(document).ready(function() {
	$('.form-horizontal').submit(function(event) {
		if(confirm("ดำเนินการต่อหรือไม่ ?") != true){
			event.preventDefault();
		}
	});
	$('input').each(function() {
		let check = $('#product_id').attr('id');
		if(check != "product_id" ){
		 	$('input[type=text]').attr('required',true);
		}
	});
	$('textarea').each(function() {
		 $(this).attr('required',true);
	});
});
	