<form method='POST' action='/admin/p_add_user/' onsubmit="return validateAddUser(this)">
<h3>Add new user:</h3>
<label class="label">Family:</label>
<select name="family_name" id="family_name_dd">
	<option >Select a family</option>
	<?php foreach ($families as $family): ?>
		<option value="<?php echo $family['family_name'];?>"><?php echo $family['family_name'];?></option>
	<?php endforeach; ?>>
</select><br>
 &nbsp;&nbsp;Note: If a family is not here, please add the family first.
<div class='error_msg' id='family_name_error'></div>

Email: <input type='text' name='email' id="email"><br>
&nbsp;&nbsp;Note: Must be a valid email address format

<div class='error_msg' id='email_error'></div>
First name: <input type='text' name='first_name'><br>
<div class='error_msg' id='first_name_error'></div>
Last name: <input type='text' name='last_name'><br>
<div class='error_msg' id='last_name_error'></div>
Password: <input type='password' name='password' id="password"><br>
&nbsp;&nbsp;Note: At least 6 char long containing 1+ digit and 1+ special char like ($%#@&)
<div class='error_msg' id='password_error'></div>


Retype password: <input type='password' name='password2' id="password2"><br>
<div class='error_msg' id='password2_error'></div>
<input type='submit' value='Add new user'>
<br><br>
</form>

<hr>


<form method='POST' action='/admin/p_add_family/' id="form_add_new_family" onsubmit="return validateFamily(this)">
<h3>Add new family:</h3>
Family name: <input type='text' name='family_name'><br>
<input type='submit' value='Add new family'>
</form>
<br>
<hr>

<!-- that will be great if this part can be hidden (optional view) -->
<!--
<h3>Current members</h3>
<table border="1" id="current_member_table" >
    <tr>
        <th>Faimly</th>
        <th>Last name</th>
        <th>First name</th>
        <th>Email</th>
	</tr>

	<?php foreach($familymembers as $familymember): ?>
	<tr>
        <td class="family_name"> <?php echo $familymember['family_name'];?> </td>
        <td class="last_name"> <?php echo $familymember['last_name'];?> </td>
        <td class="first_name"> <?php echo $familymember['first_name'];?> </td>
		<td class="email"> <?php echo $familymember['email'];?> </td>
	</tr>
	<?php endforeach; ?>
</table>
<br>
<hr>
-->

<h2>Update Family BBQ Data</h2>
<?php foreach ($families as $family) { ?>
	<form method='POST' class="update_family_bba_data_admin" action='/admin/p_admin_family_data_edit' >
		Family: <input type='text' name='family_name' value="<?php echo $family['family_name']?>" readonly>&nbsp;&nbsp; 
		Headcount: 
		<select class="admin_update_family_headcount" name="headcount" style="width: 60px">
			<?php for ($i = 0; $i <=6; $i++ ) { ?>
			<option  <?php if ($i == $family['headcount']) { echo 'selected'; } ?> > <?php echo $i;?> </option>
			<?php } ?>
		</select> &nbsp;&nbsp; 

		Senior:  
		<select class="admin_update_family_senior" name="senior" style="width: 60px">
			<?php for ($i = 0; $i <=2; $i++ ) { ?>
			<option  <?php if ($i == $family['senior']) { echo 'selected'; } ?> > <?php echo $i;?> </option>
			<?php } ?>
		</select> &nbsp;&nbsp; 

		Children: 
		<select class="admin_update_family_children" name="children" style="width: 60px">
			<?php for ($i = 0; $i <=4; $i++ ) { ?>
			<option  <?php if ($i == $family['children']) { echo 'selected'; } ?> > <?php echo $i;?> </option>
			<?php } ?>
		</select> &nbsp;&nbsp; 

		Expenses: <input type='text' name='expenses' value="<?php echo $family['expenses']?>" class="admin_update_family_expenses">&nbsp;&nbsp; 
		<input type='submit' value='UPDATE' hidden="hidden"><br>
		<br>
		<hr>
	</form>
	<div id="result"> </div>
	
<?php } ?>


