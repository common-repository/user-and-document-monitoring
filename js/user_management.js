$(document).ready(function(){
 
function close_me(){

    $('div#hiddenDiv').stop().animate({'height':'0px'},1000,function(){
$('div#hiddenDiv').css({'opacity':'0','display':'none'});
$("div.foofoo").stop().animate({'opacity':'0'},1000,function(){
$('div.foofoo').height(0);
$('div.foofoo').width(0);

    });

});
}
    $("img.options").live('click',function(){


    

var element = $(this);
var value = element.attr('id');
var purpose = element.attr('purpose');
if(purpose=='edit'){

//this will invoke the foofoo element / A MASK
var height = $(document).height();
var width = $(document).width();

$('div.foofoo').height(height);
$('div.foofoo').width(width);
$('div.foofoo').css({'position':'absolute','top':'0px','left':'0px','opacity':'0'});
$('div.foofoo').stop().animate({'opacity':'0.5'},1000,function(){

var top = height/2 - 250;
var left = width/2 - 250;

$("div.edit_user").css({'position':'absolute','top':top,'left':left,'opacity':'1'});
$("div.edit_user").stop().animate({'height':'500px'},2000);

});



var get_user_data = {
action: 'rep_get_user_data',
rep_userid: value
};
jQuery.post(ajaxurl,get_user_data, function(response) {
 response = response.slice(0,-1);
 var name = response.split('?');
$("input#first_name").val(name[0]);
$("input#last_name").val(name[1]);
$("input#email").val(name[2]);
$("#description").val(name[3]);
});

}


//To send out emails
if(purpose== 'email'){

//this will invoke the foofoo element / A MASK
var height = $(document).height();
var width = $(document).width();

$('div.foofoo').height(height);
$('div.foofoo').width(width);
$('div.foofoo').css({'position':'absolute','top':'0px','left':'0px','opacity':'0'});
$('div.foofoo').stop().animate({'opacity':'0.5'},1000,function(){

var top = height/2 - 250;
var left = width/2 - 250;

$("div.email_send").css({'position':'absolute','top':top,'left':left,'opacity':'1'});
$("div.email_send").stop().animate({'height':'500px'},2000);

});
    
$("input.get_email_client").val(value);

$("input@[name=send_to_all]").click(function(){
 $("input.get_email_client").stop().animate({'color':'green','fontSize':'15px'},1000,function(){
     $(this).stop().animate({'color':'black','fontSize':'12px'});
 });
var is_checked = $(this).attr('checked');
  if(is_checked)
      {
          $("input.get_email_client").val('All Users');
      }
     else
          $("input.get_email_client").val(value);
});
}

//To send out emails
if(purpose== 'activate'){

//wp_delete_user( $id, $reassign )
var userid = $(element).attr("ID");

var delete_user_data = {
action: 'rep_delete_user',
rep_userid: userid
};

// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
jQuery.post(ajaxurl, delete_user_data, function(response) {


if(response){
$("div.loading").animate({'bottom':'-100px'});

close_me();

var load_key = {
action: 'ajax_user_load',
key:'yes'
}
jQuery.post(ajaxurl, load_key, function(response) {

$("div.ajax_load_user").html('');
$("div.ajax_load_user").html(response);
});

}
else
    $("div.errorbox").html("There is some error processing your request");

});


}


    });


//to deactivate the user temporarily
$("div#active_deactive").live('click',function(){

$("div.loading").animate({'bottom':'100px'});
var element = $(this);

var get_class = $(this).attr('class');
var get_id = $(this).attr('userid');
var deactivate;var new_class;
if(get_class=='active') {
deactivate = 0;new_class = 'deactive'}
else {
deactivate = 1;new_class = 'active'
}
var data = {
action: 'user_active',
is_deactive: deactivate,
theid : get_id
};

// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
jQuery.post(ajaxurl, data, function(response) {

if(response){
$(element).removeClass(get_class);
$(element).addClass(new_class);
$("div.loading").animate({'bottom':'-100px'});
} else {
    $("div.errorbox").html("There is some error processing your request");
}
});



});

$("div#close_me").live('click',function(){

close_me();


});


//this will send email to user
$("input@[name=send_mail]").click(function(){
var element = $(this);


var to = $("input.get_email_client").val();
var sub = $("input#sub").val();
var message = $("textarea#message").val();
var send_to_all = $("input#send_to_all").attr('checked');

var email_form_data = {
action: 'email_to_user',
email_to: to,
email_sub: sub,
email_message: message,
email_send_to_all: send_to_all
};

// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
jQuery.post(ajaxurl, email_form_data, function(response) {

$("div.loading").animate({'bottom':'-100px'});

close_me();


});

//alert("submitting form to "+to+"<br/>"+sub+"<br/>"+message+"<br/>"+send_to_all);
});
//wp_mail( $to, $subject, $message, $headers, $attachments );




//To add new user this function wll be used
$("input#add_new_user").click(function(){

//this will invoke the foofoo element / A MASK
var height = $(document).height();
var width = $(document).width();

$('div.foofoo').height(height);
$('div.foofoo').width(width);
$('div.foofoo').css({'position':'absolute','top':'0px','left':'0px','opacity':'0'});
$('div.foofoo').stop().animate({'opacity':'0.5'},1000,function(){

var top = height/2 - 250;
var left = width/2 - 250;

$("div.add_user").css({'position':'absolute','top':top,'left':left,'opacity':'1'});
$("div.add_user").stop().animate({'height':'500px'},2000);

});


});





//To Register a new user
$("input#addusersub").live('click',function(){


$("div.loading").animate({'bottom':'100px'});

var user_login = $("input#user_login").val();
var first_name = $("input#first_name").val();
var last_name = $("input#last_name").val();
var email = $("input#useremail").val();
var pass = $("input#pass").val();
var role = $("input#role").val();

$("form table.form-table tbody tr td input@[type=text]").each(function(){
$(this).val('');
});
var user_register_data = {
action: 'rep_user_register',
rep_user_login: user_login,
rep_first_name: first_name,
rep_last_name: last_name,
rep_email: email,
rep_pass: pass,
rep_role: role
};

jQuery.post(ajaxurl, user_register_data, function(response) {

if(response){
$("div.loading").animate({'bottom':'-100px'});

close_me();

var load_key = {
action: 'ajax_user_load',
key:'yes'
}
jQuery.post(ajaxurl, load_key, function(response) {
response = response.slice(0,-1);
$("div.ajax_load_user").html('');
$("div.ajax_load_user").html(response);
});

}
else
    $("div.errorbox").html("There is some error processing your request");



});

return false;
});
});

