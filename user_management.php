<div style="border:1px solid black;" class='close_donate_box'>
Please report any bugs/issues <a href="http://hiteshjoshi.com/wordpress-plugins/client_document_monitoring.html">here</a> on comments (Please don't mail).
</div>

<input type='submit' id="add_new_user" value='Add New User' class='button-secondary' />


<!--include function file and style sheet --->
<link rel="stylesheet" href=<?php echo plugins_url('user_management_style.css',__FILE__); ?> type="text/css">
<script type="text/javascript" src="<?php echo plugins_url('js/user_management.js',__FILE__); ?>"></script>
<div class="ajax_load_user">
<?php include 'user_load_ajax.php'; ?>
</div>
<div class="foofoo"></div>
<div class="email_send" id="hiddenDiv">
<table class="widefat">
<thead>
	<tr>
		<th>Send Email</th>
                <th><div id="close_me">Close</div></th>

	</tr>
</thead>
<tbody>
   <tr>
     <td>
<form method="POST" action="" name="email_send">
<ul>
<li><label for="to">To</label> <input class="get_email_client" readonly/></li>
<li><label for="sub">Subject</label>
<input id="sub" maxlength="45" size="50" /></li>
<li><label for="Message">Message </label>
<textarea id="message" style="height: 200px; width:300px" > </textarea>
</li>
<li><label for="Message">&nbsp;</label>
<input class='button-primary' type='button' name='send_mail' value='Send' id='submitbutton' />
</li>
</ul>
</form>
</td>
</tr>
</tbody>
</table>
</div>
<div class="edit_user" id="hiddenDiv">
<table class="widefat" width="550">
<thead>
	<tr>
		<th>Edit User</th>

<th><div id="close_me">Close</div></th>
	</tr>
</thead>
<tbody>
   <tr>
     <td>
<form id="your-profile" action="http://localhost/wp3/wp-admin/user-edit.php" method="post">
<h3>Name</h3>

<table class="form-table widefat">
	<tbody>

<tr>
	<th><label for="first_name">First Name</label></th>
	<td><input type="text" name="first_name" id="first_name" class="regular-text"></td>
</tr>

<tr>
	<th><label for="last_name">Last Name</label></th>
	<td><input type="text" name="last_name" id="last_name" class="regular-text"></td>
</tr>
</tbody></table>

<h3>Contact Info</h3>

<table class="form-table widefat">
<tbody><tr>
	<th><label for="email">E-mail <span class="description">(required)</span></label></th>
	<td><input type="text" name="email" id="email" value="" class="regular-text">
		</td>
</tr>
</tbody></table>

<h3>About the user</h3>

<table class="form-table widefat">
<tbody><tr>
	<th><label for="description">Biographical Info</label></th>
	<td><textarea name="description" id="description" rows="5" cols="30"></textarea><br>
	</td>
</tr>

<tr id="password">
	<th><label for="pass1">New Password</label></th>
	<td>
	<input type="password" name="pass1" id="pass1" size="16" value="" autocomplete="off"> <span class="description">
	</td>
</tr>
<tr id="password">
	<th><label for="pass1"></label></th>
	<td>
	<input class='button-primary' type='button' name='update_user' value='Update' id='update_user' />
	</td>
</tr>
</tbody></table>
</form>
</td>
</tr><tr></tr>
</tbody>
</table>
</div>



<!-- this div is for adding new user -->
<div class="add_user" id="hiddenDiv">
<table class="widefat">
<thead>
	<tr>
		<th>Add New User</th>
                <th><div id="close_me">Close</div></th>

	</tr>
</thead>
<tbody>
   <tr>
     <td>
<form method="POST" action="" name="add_user">
<table class="form-table">
	<tbody><tr class="form-field form-required">
		<th scope="row"><label for="user_login">Username <span class="description">(required)</span></label>
		<input name="action" type="hidden" id="action" value="adduser"></th>
		<td><input name="user_login" type="text" id="user_login" value="" aria-required="true"></td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="first_name">First Name </label></th>
		<td><input name="first_name" type="text" id="u_first_name" value=""></td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="last_name">Last Name </label></th>
		<td><input name="last_name" type="text" id="u_last_name" value=""></td>
	</tr>
	<tr class="form-field form-required">
		<th scope="row"><label for="email">E-mail <span class="description"></span></label></th>
		<td><input name="email" type="text" id="useremail" value=""></td>
	</tr>
	<tr class="form-field form-required">
		<th scope="row"><label for="pass1">Password <span class="description"></span></label></th>
		<td>
                <input name="pass1" type="password" id="pass" autocomplete="off">
		</td>
	</tr>
<input name="role" type="hidden" id="role" value="<?php echo $default_role; ?>" />
        <tr class="form-field form-required">
		<th scope="row"> </th>
		<td>
                	<input name="adduser" type="button" id="addusersub" class="button-primary" value="Add User"></td>
	</tr>
</tbody></table>


</form>
</td>
</tr>
</tbody>
</table>
</div>



<div class="loading"></div>
