<?php if ($message) { echo $message; } ?>

<h1><?php echo APP_NAME;?></h1>
<p>This is a private site for privileged members only. Need a login, please contact Torman at torman_cheng@yahoo.com</p>

<!--p>
Every year, we have a BBQ gathering with over 10 families. 
There are lot of calculations of who have paid how much and who need to pay thier share.
</p> 
<p>Each family just needs to enter the headcount of family, number of senior, number of children and the expenses so far. BBQ Planner will do the rest (how much each family has to pay their shares).</p>
<p>Note: senior and children under 12 are free of charge.</p-->

<?php if (!$user) { ?>
<form method='POST' id="login_form" action='/users/p_login/'>

	Email : <input type="text" name="email"> <br><br>
	Password : <input type="password" name="password"> <br><br>

    <input type='submit' value='Login'>
</form>

<?php } ?>











