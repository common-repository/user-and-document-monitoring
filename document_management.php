<div style="border:1px solid black;" class='close_donate_box'>
<a href='https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=YQ8ZTAUGSF8C4'>Click here to buy me a coffee</a>Or <a href="http://hiteshjoshi.com/wordpress-all/client_document_monitoring.html" class="twitter-share-button" data-count="none" data-via="HiteshJoshi">Tweet this</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script> Or <fb:like href="http://hiteshjoshi.com/wordpress-all/client_document_monitoring.html" layout="button_count" show_faces="true" font="trebuchet ms" action=recommend></fb:like>
<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
    FB.init({appId: '135747146459780', status: true, cookie: true,
             xfbml: true});
  };
  (function() {
    var e = document.createElement('script'); e.async = true;
    e.src = document.location.protocol +
      '//connect.facebook.net/en_US/all.js';
    document.getElementById('fb-root').appendChild(e);
  }());
</script>
        Also, Please report any bug on comments at <a href="http://hiteshjoshi.com/wordpress-all/client_document_monitoring.html">http://hiteshjoshi.com/wordpress-all/client_document_monitoring.html</a>
</div>
<?php include 'functions.php';
echo "<script type=\"text/javascript\" src=\"http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js\"></script>";
?>
<script type="text/javascript" src="<?php echo plugins_url('js/document_management.js',__FILE__); ?>"></script>
<?php

if(isset($_POST['submit'])) :
$month = $_POST['month'];
$year = $_POST['year'];
else :
$year = date('Y');
$month = date('n');

endif;

?>
<div class="demo">
<form method="post" action="">
<p>Select month and date to filter <br/>
Month : <select name="month" id="month">
<option value='false' ></option>
<?php for($months=1;$months<=12;$months++) {
if($months==date('m')){echo "<option value=$months selected>$months</option>";} else {
echo "<option value=$months >$months</option>"; }}?>
</select>

Year : <select name="year">
<?php $years=date('Y'); ?>
<?php for($l_year=$years-10;$l_year<=$years;$l_year++) {
if($l_year==$years){echo "<option value=$l_year selected>$l_year</option>";}
echo "<option value=$l_year >$l_year</option>"; }?>
</select>

<input type="submit" name="submit" value="Filter" class="button-primary" />
</p>
</form>
</div><!-- End demo -->


<table class="widefat">
<thead>
	<tr>
		<th>File Name</th>
		<th>Link</th>
		<th>Uploaded on</th>
                <th>Associate with user</th>

	</tr>
</thead>
<tfoot>
    <tr>
                <th>File Name</th>
		<th>Link</th>
		<th>Uploaded on</th>
                <th>Associated with user</th>    </tr>
</tfoot>
<?php $application_type = get_option('application_type'); ?>
<?php
query_posts('year=' .$year. '&monthnum=' .$month. "&post_type=attachment&post_status=inherit&post_mime_type=$application_type");
?><tbody>



<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php
$thisuID = new users();
$the_uID = $thisuID->get_uID(get_the_ID());

if(!$the_uID=='' OR !empty($the_uID)) :
$user_info = get_userdata($the_uID);
$userID = $user_info->ID;
$username = $user_info->user_login;
$is_true = true;
$postid = get_the_ID();
else :
$postid = get_the_ID();
$is_true = false;
endif;
?>
<div <?php post_class() ?> id="post-<?php the_ID(); ?>">


   <tr >
     <td><?php the_attachment_link()?></td>
     <td><a href="<?php the_permalink() ?>" >Click To See </a></td>
     <td><?php the_date() ?></td>
     <td postid="<?php echo $postid;?>">
	 <?php


	 if($is_true) :
	 echo $username." <a href='#' id='remove_user' class='button-primary'>Unlink</a>";  else :

	 echo "<form method=\"post\" action=\"\"> ";
	 if(isset($_POST['month'])) :
$date = $_POST['dateselect'];
echo "<input type=\"hidden\" name=\"month\" value=\"true\" />";
echo "<input type=\"hidden\" name=\"dateselect\" value=\"$date\" />";
endif;
	 echo "
	 <input type=\"hidden\" name='document_id' id='document_id$postid' value='$postid' />
	<div id='user_div' postid='$postid'><select name='user_doc_id' id='user_doc_id$postid' >";

$get_repOptions = new rep_database();
$default_role = $get_repOptions->options('default_role');
global $wpdb;
$aUsersID = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->users"));

foreach($aUsersID as $iUserID) :

$user_info = new WP_User($iUserID);

if ( !empty( $user_info->roles ) && is_array( $user_info->roles ) ) {
	foreach ( $user_info->roles as $role )
		$userlevel = $role;
}
if($default_role == $userlevel) {

    $user_info->user_registered = substr($user_info->user_registered , 0, -9);  // returns "cde"

	echo "
  <option id='username' value=\"$user_info->ID\" class='$user_info->user_login'>$user_info->user_login</option>
";
}
	endforeach;



echo "</select> Date : <select name=\"month\" id=\"month$postid\">";
for($month=1;$month<=12;$month++) {
if($month==date('m')){
echo "<option value=$month selected>$month</option>"; } else{
echo "<option value=$month >$month</option>"; } }
echo "</select>";

echo "<select name=\"year\" id=\"year$postid\">";
$year=date('Y');
for($l_year=$year-10;$l_year<=$year;$l_year++) {
if($l_year==date('Y')){
echo "<option value=$l_year selected>$l_year</option>";
}
else{
echo "<option value=$l_year >$l_year</option>"; } }
echo "</select>";



echo "<input type='button' class=\"button-primary\" id='add_user' postid=\"$postid\"name=\"add_user\" value=\"Add\" /></div></form>";
	endif;

?>
     </td>





</div>
</tr>
<?php endwhile;
else : echo "<h2>Sorry No Document for this date</h2>";
endif;?>

</tbody>
</table>
<div class='error' style="display:none;"></div>