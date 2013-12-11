<?php if ($message) { echo $message; } ?>

<h1><?php echo APP_NAME;?></h1>
<p>This is a private site for privileged members only.</p>
<p>Need a login, please contact Torman at torman_cheng@yahoo.com</p>

<p>
Every year, we have a BBQ gathering with over 10 families. 
There are lot of calculations of who have paid how much and who need to pay thier share.
</p> 
<p>Each family just needs to enter the headcount of family, number of senior, number of children and the expenses so far. BBQ Planner will do the rest (how much each family has to pay their shares).</p>
<p>Note: senior and children under 12 are free of charge.</p>


<hr>

<?php if (!$user) { ?>
<form method='POST' action='/users/p_login/'>

	Email : <input type="text" name="email"> <br><br>
	Password : <input type="password" name="password"> <br><br>

    <input type='submit' value='Login'>
</form>
<hr>
<?php } ?>


<p>Note for instructors: This application has two modes. One is for ordinary users 
while the other is for administrator. Only admin has privilege of creating user and family.
Each user belongs a family. One family can have more than one members/users who can access 
the application. For example, Ethan and Emily are the family member of Kuen. Either Ethan 
or Emily can update their family information for the BBQ. </p>
<p>You can use some user accounts listed below to test the application.</p>
<table border=1 id="example_users">
<tr>
	<th class="email_col">user email</th>
	<th>password</th>
	<th>role</th>	
</tr>
<tr>
	<td class="email_col">"emily@abcd.com"</td>
	<td>"asdf2@"</td>
	<td>admin</td>	
</tr>
<tr>
	<td class="email_col">"justin@abcd.com"</td>
	<td>"asdf3#"</td>
	<td>basic user</td>	
</tr>
<tr>
	<td class="email_col">"ethan@abcd.com"</td>
	<td>"asdf2@"</td>
	<td>basic user</td>	
</tr>
</table>








