<form method='POST' action='/users/p_family_data_edit' onsubmit="return validateFamilyData(this)">
	Family Name : <input type="text" name="family_name" value="<?php echo $user_family_data["family_name"];?>" readonly>can't be edited here <br><br>
	Headcount : 		
	<select name="headcount" style="width: 60px">
		<?php for ($i = 0; $i <=6; $i++ ) { ?>
		<option  <?php if ($i == $user_family_data['headcount']) { echo 'selected'; } ?> > <?php echo $i;?> </option>
		<?php } ?>
	</select> &nbsp;&nbsp; sum of senior and children can't be larger than headcount <br><br>
	Senior :  
	<select name="senior" style="width: 60px">
		<?php for ($i = 0; $i <=2; $i++ ) { ?>
		<option  <?php if ($i == $user_family_data['senior']) { echo 'selected'; } ?> > <?php echo $i;?> </option>
		<?php } ?>
	</select> &nbsp;&nbsp;	sum of senior and children can't be larger than headcount<br><br>
	Children : 
	<select name="children" style="width: 60px">
		<?php for ($i = 0; $i <=4; $i++ ) { ?>
		<option  <?php if ($i == $user_family_data['children']) { echo 'selected'; } ?> > <?php echo $i;?> </option>
		<?php } ?>
	</select> &nbsp;&nbsp; sum of senior and children can't be larger than headcount<br><br>
	Expenses : <input type="text" name="expenses" value="<?php echo $user_family_data["expenses"];?>"> must be a number<br><br>

    <input type='submit' value='Save'>
</form>
<hr>

<h2>BBQ Balance Sheet</h2>
* click Compute to calculate the balance of each family<br>
* positive balance means the family needs to pay the amount<br>
* negative balance means the family overpaid and will get the amount back<br><br>
<button type="button" onclick="computeBalance(<?php echo "'" . $user_family_data["family_name"] . "'";?>)">Compute</button><br><br>
<!--button type="button" onclick="computeBalance()">Compute</button><br><br-->
<table border=1 id="balancesheet" onload="computeBalance(<?php echo "'" . $user_family_data["family_name"] . "'";?>)">

	<tr>
		<th>Family Name</th> 
		<th>Headcount</th>  
		<th>Senior</th>  
		<th>Children</th> 
		<th>Expenses</th> 
		<th>Balance</th>
	</tr>
	<?php
	foreach ($families_data as $family_data) { ?>
		<tr class="<?php echo $family_data["family_name"] ?>">
			<td>  <?php echo $family_data["family_name"] ?> </td>
			<td class="headcount" align="center">  <?php echo $family_data["headcount"] ?> </td>
			<td class="senior" align="center">  <?php echo $family_data["senior"] ?> </td>
			<td class="children" align="center">  <?php echo $family_data["children"] ?> </td>
			<!--td class="expenses" align="right">  <?php echo $family_data["expenses"] ?> </td-->
			<td class="expenses" align="right" >  <?php echo number_format($family_data["expenses"], 2) ?> </td>
			<!--td class="balance">  <?php echo $family_data["balance"] ?> </td-->
			<td class="balance" align="right">  <?php echo "" ?> </td>
		</tr>
	<?php } ?>
	<tr>
		<th>Total</th> 
		<th id='total_headcount'>--</th>  
		<th id='total_senior'>--</th>  
		<th id='total_children'>--</th> 
		<th id='total_expenses'>--</th> 
		<th id='total_balance'>--</th>
	</tr>

</table>
<script>
window.onload="computeBalance(<?php echo "'" . $user_family_data["family_name"] . "'";?>)"
</script>
<br>
<br>
<br>