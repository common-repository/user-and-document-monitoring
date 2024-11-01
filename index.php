<?php
/*
Plugin Name: Client Document Monitoring
Plugin URI: http://hiteshjoshi.com/wordpress/client_document_monitoring.html
Description: <p>This plugin helps in managing document and users more easily and effectively.Features :- <br>*You can create users more faster than wordpress default user system.<br> *You can upload documents and can assign to different users.<br> *Users can login and download/view their document.<br> *Everything AJAX based.
</p>
Version: 3.0
Author: Hitesh Joshi
Author URI: http://hiteshjoshi
License: A "Slug" license name e.g. GPL2
*/

//this will install the plugin, create tables and insert necessary sample data
function rep_install(){
global $wpdb;
$wpdb->query( $wpdb->prepare("CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."rep_options` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `default_role` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;
") );
$wpdb->query( $wpdb->prepare("CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."rep_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uID` int(11) NOT NULL,
  `pID` int(11) NOT NULL,
  `date` varchar(7) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;") );
//Plese don't remove this sample data.
$wpdb->query( $wpdb->prepare("INSERT INTO `".$wpdb->prefix."rep_options` (`id`, `default_role`) VALUES ('1', 'administrator');") );
} // This will delete tables when user will deactivate the plugin
function rep_uninstall(){
global $wpdb;
$wpdb->query( $wpdb->prepare("DROP TABLE `".$wpdb->prefix."rep_options`, `".$wpdb->prefix."rep_mortgage`, `".$wpdb->prefix."rep_user`;"));
}
register_activation_hook(__FILE__,'rep_install');
register_deactivation_hook(__FILE__,'rep_uninstall');



//this will load wp tiny mice on setting page
add_filter('admin_head','rep_ShowTinyMCE');
function rep_ShowTinyMCE() {
    if(isset($_GET['page']) && $_GET['page']=='rep_settings'){
	// conditions here
	wp_enqueue_script( 'common' );
	wp_enqueue_script( 'jquery-color' );
	wp_print_scripts('editor');
	if (function_exists('add_thickbox')) add_thickbox();
	wp_print_scripts('media-upload');
	if (function_exists('wp_tiny_mce')) wp_tiny_mce();
	wp_admin_css();
	wp_enqueue_script('utils');
	do_action("admin_print_styles-post-php");
	do_action('admin_print_styles');

        wp_enqueue_script('editor');
add_thickbox();
wp_enqueue_script('media-upload');
wp_enqueue_script('word-count');

} }

//this will load javscript of rep
add_filter('admin_head','rep_js');
function rep_js(){
if(isset($_GET['page']) && ( $_GET['page']=='rep_settings' || $_GET['page']=='rep_manage_document' || $_GET['page']=='rep_manage_users')){
echo "<script type=\"text/javascript\" src=\"http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js\"></script>";
if($_GET['page']=='rep_settings') {
echo "<script type=\"text/javascript\" src=".plugins_url('js/rep_script.js',__FILE__)."></script>";
}
}}


//menu

// Hook for adding admin menus
add_action('admin_menu', 'rep_menu_pages');

// action function for above hook
function rep_menu_pages() {
//add_menu_page(__('Client Login'), 'Real Estate Property Monitor', 'manage_options', 'rep_toplevel_menu', 'rep_toplevel_page' );
add_menu_page(__('Client Login'), 'Client Login', 'manage_options', 'rep_manage_document', 'rep_manage_document','',3);
add_submenu_page('rep_manage_document','Document Upload','Document Upload', 'manage_options', 'rep_document', 'rep_document');
add_submenu_page('rep_manage_document','Manage Users','Users', 'manage_options', 'rep_manage_users', 'rep_manage_users');
add_submenu_page('rep_manage_document','Settings','Settings', 'manage_options', 'rep_settings', 'rep_settings');

// add_submenu_page('rep_manage_document','Mortgage Manager','Mortgage Manager', 'manage_options', 'rep_mortgage', 'rep_mortgage');
// add_submenu_page('rep_manage_document','Mortgage Notes','Mortgage Notes', 'manage_options', 'rep_mortgage_notes', 'rep_mortgage_notes');

}
function rep_settings() {
    echo "<h2>Settings</h2>";

include 'rep_options.php';

    }
function rep_manage_users() {
    echo "<h2>User Management</h2>";
    include 'user_management.php';
}
function rep_manage_document() {
    echo "<h2>Document Management</h2>";
    include 'document_management.php';
}

function rep_document() {
    echo "<h2>Upload Document</h2>";
    include 'document_upload.php';
}


function rep_mortgage(){
    echo "<h2>Create User</h2>";
    include 'mortgage_management.php';
}

function rep_mortgage_notes(){
    echo "<h2>Mortgage Notes</h2>";
    include 'mortgage_notes.php';
}


function user_post($text){

if ( is_user_logged_in() ) {

$post = get_option('post');
global $current_user;
get_currentuserinfo();

$user = $current_user->ID;

$content ='';
 $content .= "<script type=\"text/javascript\" src=\"http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js\"></script>";
 $show_yearly = get_option('show_yearly');
 if(!$show_yearly){
 $content .= "<script type=\"text/javascript\">
var content_html;
function search_post(){

 var month = $('select#month').val();
 var year = $('select#year').val();
$('div#load_image').html('<div id=loading_image><img src=".plugins_url('images/ajax-loader.gif',__FILE__)."></div>');
 var search_post = {
action: 'search_post',
search_month: month,
search_year: year,
user_id : $user
};

 jQuery.post('".admin_url('admin-ajax.php')."', search_post, function(response) {

 if(response==0){
 $('div#file').html('<h2>No File Found For '+month+'-'+year+'</h2>');
 } else {

 $('div.no_file').html('');
 response = response.slice(0, -1);
 $('div#file').html(response);

 }
 $('div#loading_image').hide(1000);


 });

return false;
}
 $('#search_submit').live('click',search_post);
 $(document).ready(function(){
 search_post();
 });


</script>"; } else{
$loading_text = get_option('loading_text');
$content .= "<script type=\"text/javascript\">
var content_html;
var monthloop = 1;
var secondloop=1;

$('#search_submit').live('click',yearloop);
function yearloop(){
$('#search_submit').attr('disabled','true');
var year = $('select#year').val();
if(monthloop==1) { $('div#file').html(''); }

$('div#load_image').html('<div id=loading_image><img src=".plugins_url('images/ajax-loader.gif',__FILE__).">$loading_text</div>');


if(monthloop<10)
{
var monthnumber = '0'+monthloop;
} else {var monthnumber = monthloop;}

var search_post = {
action: 'search_post',
search_month: monthnumber,
search_year: year,
user_id : $user
};
 jQuery.post('".admin_url('admin-ajax.php')."', search_post, function(response) {
$('div#loading_image').hide(1000);

if(monthloop==12){
var content_html = $('div#file').html();
if(content_html=='') {
$('div.no_file').html('<h2>Sorry No File Found!</h2>'); }
$('#search_submit').removeAttr('disabled');;
}
if(response==0){
 //$('div#file').append('<h2>No File Found for year '+year+'</h2>');
 } else {
 $('div.no_file').html('');
 response = response.slice(0, -1);

 var month=new Array(13);
month[1]='January';
month[2]='February';
month[3]='March';
month[4]='April';
month[5]='May';
month[6]='June';
month[7]='July';
month[8]='August';
month[9]='September';
month[10]='October';
month[11]='November';
month[12]='December';

 $('div#file').append(response+' :  <em>'+month[monthloop]+' '+year+'</em><br/>');

 }
 monthloop++;
 if(monthloop<=12){yearloop();}
 if(monthloop>12){ monthloop=1; }
 });

 }
$(document).ready(function(){
yearloop();
});


</script>";

}
 $first_name = $current_user->user_firstname;
 if($first_name!=null)
 $content .= "<h2>Welcome ".$first_name."</h2>";
 else
 $content .= "<h2>Welcome ".$current_user->user_login."</h2>";

 $content .= get_option('content');

$content .= '<form id="myForm1" method="post" action="'.$post.'">';
if(!$show_yearly) :

$content .= '<p>Select month and date to filter <br/>
Month : <select id="month" name="month">';
for($month=1;$month<=12;$month++) {
if($month<10) $is_zero=0; else $is_zero='';
$content .= "<option value=$is_zero$month >$is_zero$month</option>"; }
$content .= '</select>';
endif;

if($show_yearly){
$content .= '<p>Select Year and press filter <br/>'; }
$content .= 'Year : <select id="year" name="year">';
$year=date('Y');
for($l_year=$year-10;$l_year<=$year;$l_year++) {
$year = date('Y');
if($l_year==$year){
$content .= "<option value=$l_year selected>$l_year</option>"; }

else{
$content .= "<option value=$l_year selected>$l_year</option>";
}
}
$content .= '</select>';
if($show_yearly){
$content .= '<input type="button" id="search_submit" value="Filter" class="button-primary" />'; }
else{
$content .= '<input type="button" id="search_submit" value="Filter" class="button-primary" />'; }
$content .= '</p>
</form><hr/><div id="load_image"></div><div class="no_file"></div><div class="download_content">';

$content .= "<div id='file'>".get_option('loading_text')."</div>";
$content .= "<br/><a href=".wp_logout_url( $post ). ">Logout</a></div>";

$text = str_replace('[ClientLogin]',$content,$text);


return $text;
} else {
$login_form = '<h2>Please Login First</h2>';
$post = get_option('post');


if(function_exists('wp_login_form'))
{

$args = array(
        'echo' => false,
        'redirect' => $post,
        'form_id' => 'loginform',
        'label_username' => __( 'Username' ),
        'label_password' => __( 'Password' ),
        'label_remember' => __( 'Remember Me' ),
        'label_log_in' => __( 'Log In' ),
        'id_username' => 'user_login',
        'id_password' => 'user_pass',
        'id_remember' => 'rememberme',
        'id_submit' => 'wp-submit',
        'remember' => true,
        'value_remember' => false );
$login_form .=  wp_login_form($args);
} else{
		$login_form .= '



		<form method="post" action="'.get_option('home').'/wp-login.php" id="loginform" name="loginform">

			<p class="login-username">
				<label for="user_login">Username</label>
				<input type="text" tabindex="10" size="20" value="" class="input" id="user_login" name="log">
			</p>
			<p class="login-password">
				<label for="user_pass">Password</label>
				<input type="password" tabindex="20" size="20" value="" class="input" id="user_pass" name="pwd">
			</p>

			<p class="login-remember"><label><input type="checkbox" tabindex="90" value="forever" id="rememberme" name="rememberme"> Remember Me</label></p>
			<p class="login-submit">
				<input type="submit" tabindex="100" value="Log In" class="button-primary" id="wp-submit" name="wp-submit">
				<input type="hidden" value=" '.$post.'" name="redirect_to">
			</p>

		</form>';

}

$text = str_replace('[ClientLogin]', $login_form,$text);
return $text;
		}



		}
add_filter('the_content','user_post');



//---------------------------------Below is AJAX part of this plugin -----------------------------------------//
//this part is totally for AJAX used in backend. Please don't touch this
add_action('wp_ajax_unlink_doc', 'unlink_doc_callback');
function unlink_doc_callback(){
$document_id = $_POST['document_id'];
$user_id = $_POST['user_id'];
global $wpdb;
$wpdb->query(" DELETE FROM ".$wpdb->prefix."rep_user WHERE pID = '$document_id'");
}
add_action('wp_ajax_role_update', 'role_update_callback');
function role_update_callback(){

    global $wpdb;
    $is_update = $wpdb->update( $wpdb->prefix.'rep_options', array( 'default_role' => $_POST['myval']),array( 'id' => 1 ),array( '%s' ),array( '%d' ) );

}
add_action('wp_ajax_email_to_user', 'email_to_user_callback');
function email_to_user_callback(){
    $to = $_POST['email_to'];
    $subject = $_POST['email_sub'];
    $message = $_POST['email_message'];
	$email = get_option('email');
    $headers = 'From: '.$email.'' . "\r\n\\";
    //$attachments = array(WP_CONTENT_DIR . '/uploads/file_to_attach.zip');
    wp_mail( $to, $subject, $message, $headers); /*, $attachments );*/

echo "true";
}
add_action('wp_ajax_rep_user_register', 'rep_user_register_callback');
function rep_user_register_callback(){
    global $wpdb;
    $user_login = $_POST['rep_user_login'];
    $first_name = $_POST['rep_first_name'];
    $last_name = $_POST['rep_last_name'];
    $email = $_POST['rep_email'];
    $pass = $_POST['rep_pass'];
    $role = $_POST['rep_role'];
    $registered_date = date('Y-m-d H:i:s');
$userdata = array(
    "user_login"=>$user_login,
    "user_nicename"=>$first_name,
    "user_email"=>$email,
    "display_name"=>$first_name." ".$last_name,
    "first_name"=>$first_name,
    "last_name"=>$last_name,
    "user_registered"=>$registered_date,
    "role"=>$role,
"user_pass"=>$pass
);

    $registerID = wp_insert_user($userdata);

}

add_action('wp_ajax_rep_user_update', 'rep_user_update_callback');
function rep_user_update_callback(){


};
add_action('wp_ajax_rep_get_user_data', 'rep_get_user_data_callback');
function rep_get_user_data_callback(){
    $userid = $_POST['rep_userid'];
	$user_info = get_userdata($userid);
	$send_data = $user_info->first_name.'?'.$user_info->last_name.'?'.$user_info->user_email.'?'.$user_info->description;
    echo $send_data;
};

//    $registerID = wp_insert_user($userdata);





add_action('wp_ajax_ass_user', 'ass_user_callback');
function ass_user_callback(){
$documentid = $_POST['document_id'];
$user_id = $_POST['user_id'];
global $wpdb;
$date = $_POST['post_year'].'-'.$_POST['post_month'];
$insert = $wpdb->insert( $wpdb->prefix.'rep_user', array( 'uID' => $user_id, 'pID' => $documentid, 'date' =>$date), array( '%d', '%d','%s' ) );
if($insert):
echo "true";
else : echo "false";
endif;
}


add_action('wp_ajax_ajax_user_load', 'ajax_user_load_callback');
function ajax_user_load_callback(){

    include 'user_load_ajax.php';
}

add_action( 'admin_init', 'rep_template_setting' );
function rep_template_setting(){
register_setting( 'rep_template-group', 'content' );
register_setting( 'rep_template-group', 'post' );
register_setting( 'rep_template-group', 'application_type' );
register_setting( 'rep_template-group', 'email' );
register_setting( 'rep_template-group', 'show_yearly' );
register_setting( 'rep_template-group', 'loading_text' );
}

add_action('wp_ajax_search_post', 'search_post_callback');
function search_post_callback(){

if($_POST['search_year']){
$year = $_POST['search_year'];
$month = $_POST['search_month'];
$user = $_POST['user_id'];
global $wpdb;
//$uID = $wpdb->query("SELECT pID FROM ".$wpdb->prefix."rep_user where uID = $user AND date = '$year-$month'");
//$uID =$wpdb->get_var($wpdb->prepare("SELECT pID FROM ".$wpdb->prefix."rep_user where uID = $user AND date = '$year-$month' "));
//$link= wp_get_attachment_url($uID);
//echo $link;
$uID = $wpdb->get_col("SELECT pID FROM ".$wpdb->prefix."rep_user where uID = $user AND date = '$year-$month'",0);
foreach($uID as $ID)
{
$link= wp_get_attachment_url($ID);
$title = get_the_title($ID);

echo "<strong><a href=\"$link\">".$title."</a></strong>";
}

} ;

}


?>
