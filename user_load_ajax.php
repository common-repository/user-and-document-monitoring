<?php include 'functions.php'; ?>

<?php
$get_repOptions = new rep_database();
$default_role = $get_repOptions->options('default_role');
global $wpdb;
$aUsersID = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->users"));

echo "<table class=\"widefat\" >
<thead>
	<tr>
		<th>Username</th>
                <th>Name</th>
                <th>Email</th>
                <th>Registration</th>
                <th>Email</th>




	</tr>
</thead>
<tbody>
   <tr>";

foreach($aUsersID as $iUserID) :

$user_info = new WP_User($iUserID);

if ( !empty( $user_info->roles ) && is_array( $user_info->roles ) ) {
	foreach ( $user_info->roles as $role )
		$userlevel = $role;
}
if($default_role == $userlevel) {

    $user_info->user_registered = substr($user_info->user_registered , 0, -9);  // returns "cde"

echo "<td>$user_info->user_login</td>
        <td>$user_info->first_name $user_info->last_name</td>
        <td>$user_info->user_email</td>
        <td>$user_info->user_registered </td>
        <td >
        <img src=".plugins_url('/images/email.gif',__FILE__)." id=$user_info->user_email  class='options' purpose=email  />



</td>

   </tr>";
   //<img src=".plugins_url('/images/edit_user.png',__FILE__)." id=$user_info->ID  class='options' purpose=edit  />
   }
endforeach;
echo "
</tbody>
</table>";

?><?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
