var pre = "";
var pathname = window.location.pathname;
var patharr = pathname.split("/");
//3=>0 4=>1 ,5=>2, 6=>3
//

if (window.location.host == "localhost") {
    
    if (patharr.length <= '3') {
        pre = "";
    } else {
        pre = "../";
    }
} else {
    if (patharr.length <= '3') {
        pre = "";
    } else {
        if (patharr.length >= 5) {
            var count = parseInt(patharr.length) - parseInt(4);
            var i = 1;
            for (i; i <= count; i++) {
                pre += "../"
            }
        } else {
            pre = "";
        }

    }
}

function checkUser(uid){
    //if(currentpage ==true){}else{
    if (uid == "") {
        
        window.location = pre + 'index';
    } else if (uid == null) {
         window.location = pre + 'index';
    }
    //}
}
function checkUserPopUp(uid){
	 if (uid == "") {
        window.opener.location = "./index";
        window.parent.location = "./index";
        window.close();
    }
}
function checkUserPopUpL3(uid){
	if (uid == "") {
        window.opener.location = "./index";
        window.parent.opener.location = "/index";
        window.parent.close();
        window.close();
    }
}
/*function checkUserPopUpBlank(uid){
	if(uid==""){
		window.opener.location="/Fentons/ICT/index";
		//window.parent.location="./index.php";
		window.close();
	}
}*/
function checkUserPopUpBlank(uid) {
    //alert('checkUser');
    if (uid == "") {
        window.opener.location = "/index";
        window.parent.location = "./index";
        window.close();
    }
}
function numbers(id) {
    $(id).keydown(function (e) {

        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
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
                }
            });
}