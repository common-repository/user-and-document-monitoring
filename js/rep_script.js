$(document).ready(function(){

$('select#role_change').change(
function(){
    var myval = $(this).val();



  var data = {
		action: 'role_update',
		myval: myval
	};

	// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
	jQuery.post(ajaxurl, data, function(response) {

if(response) {

    $("div.rolename").fadeOut('slow',function(){

    $("div.rolename").html(myval);
    $("div.rolename").fadeIn('slow');
    });
    
    

}

	});

}


);
    
})