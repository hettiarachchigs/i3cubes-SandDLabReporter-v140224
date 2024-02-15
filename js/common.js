function datepicker(id){
     $(id).datepicker({format:'yyyy-mm-dd'})
				.on('changeDate', function(ev){
					/*if (ev.date.valueOf() > endDate.valueOf()){
						$('#alert').show().find('strong').text('The start date can not be greater then the end date');
					} else {
						$('#alert').hide();
						startDate = new Date(ev.date);
						//$('#startDate').text($('#dateofjoin').data('date'));
					}*/
					$(id).datepicker('hide');
				});
}

function numbers (id){
       $(id).keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [ 46, 8, 9, 27, 13, 110]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
            
             return;
        
        }
         
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
            console.log(this.value);
        }
    });
}
function decimalinput(id){
   
           $(id).keydown(function (event) {
        if (event.shiftKey == true) {
            event.preventDefault();
        }

        if ((event.keyCode >= 48 && event.keyCode <= 57) || 
            (event.keyCode >= 96 && event.keyCode <= 105) || 
            event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 ||
            event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190 || event.keyCode == 110) {

        } else {
            event.preventDefault();
        }

        if($(this).val().indexOf('.') !== -1 && (event.keyCode == 190 | event.keyCode == 110))
            event.preventDefault(); 
        //if a decimal has been added, disable the "."-button

    
    });
}