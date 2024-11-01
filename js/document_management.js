$(document).ready(function(){
$("input#add_user").live('click',function(){
var postid = $(this).attr('postid');
var element = this;
var documentId = $("input#document_id"+postid).val();
var userId = $("select#user_doc_id"+postid).val();
var newmonth;
var username = $("select#user_doc_id"+postid+" option:selected").attr('class');
var month = $("select#month"+postid).val();
var newyear = $("select#year"+postid).val();
if(month<10){
newmonth = '0'+month;
} else { newmonth = month; }


var ass_user = {
action: 'ass_user',
document_id : documentId,
user_id : userId,
post_month : newmonth,
post_year : newyear
};
 
 jQuery.post(ajaxurl, ass_user, function(response) {
response = response.slice(0, -1);
 if(response){
 
 $(element).parent().fadeOut(500).html("File Associated with "+username+" <a href='#' id='remove_user' class='button-primary'>Unlink</a>").fadeIn(500);
 } else{
 $("div.error").html('Please Try Again! I think server timeout?.<br/>If you contiue getting this message. Please contact me at <a href=http://hiteshjoshi.com/contact-me>here</a>');
 $("div.error").show(1000);
 }
 
 });

});
$("a#remove_user").live('click',function(){
var linkelement = $(this);
documentId = $(this).parent().attr('postid');
var unlink = {
action: 'unlink_doc',
document_id : documentId
};
 
jQuery.post(ajaxurl, unlink, function(response) {
linkelement.parent().html('This file is no more associated with any user');
});

})

});

