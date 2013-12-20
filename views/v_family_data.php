<form method='POST' id="family_input_data" action='/users/p_family_data_edit' onsubmit="return validateFamilyData(this)">

	<div class="family-input-data-field"> <label>Family Name :</label>
		<input type="text" name="family_name" id="familyname" value="<?php echo $user_family_data["family_name"];?>" readonly>
	</div>
		
	<div class="family-input-data-field"><label>Headcount :</label> 		
	<select name="headcount" id="headcount" style="width: 60px">
		<?php for ($i = 0; $i <=6; $i++ ) { ?>
		<option  <?php if ($i == $user_family_data['headcount']) { echo 'selected'; } ?> > <?php echo $i;?> </option>
		<?php } ?>
	</select>
	</div>
	
	<div class="family-input-data-field">
	<label class="label">Senior :</label>   
	<select name="senior" id="senior" style="width: 60px">
		<?php for ($i = 0; $i <=2; $i++ ) { ?>
		<option  <?php if ($i == $user_family_data['senior']) { echo 'selected'; } ?> > <?php echo $i;?> </option>
		<?php } ?>
	</select>
	</div>
	
	<div class="family-input-data-field">
	<label class="label">Children :</label>  
	<select name="children" id="children" style="width: 60px">
		<?php for ($i = 0; $i <=4; $i++ ) { ?>
		<option  <?php if ($i == $user_family_data['children']) { echo 'selected'; } ?> > <?php echo $i;?> </option>
		<?php } ?>
	</select> 
	</div>
	
		<div class="family-input-data-field">
			<label class="label">Expenses :</label>
			<input type="text" name="expenses" id="expenses" value="<?php echo $user_family_data["expenses"];?>"> 
		</div>

		
			
	<!--div class="family-input-data-field"-->		
	<label class="label">Tasks:</label>  <input type="textarea" name="tasks" id="tasks" value="<?php echo $user_family_data["tasks"];?>"> 
	<!--/div-->
		
	<div>
		<input type='submit' value='SAVE' id="save-button-holder">
	</div>
	
	
</form>


<br><br><br><br><br><br><br><br><br><br><br><br>
<h3>Balance Sheet</h3>


<table border=1 id="balancesheet">

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
			<td class="balancesheet_family_name">  <?php echo $family_data["family_name"] ?> </td>
			<td class="headcount" align="center">  <?php echo $family_data["headcount"] ?> </td>
			<td class="senior" align="center">  <?php echo $family_data["senior"] ?> </td>
			<td class="children" align="center">  <?php echo $family_data["children"] ?> </td>
			<!--td class="expenses" align="right">  <?php echo $family_data["expenses"] ?> </td-->
			<td class="expenses" align="right" >  <?php echo number_format($family_data["expenses"], 2) ?> </td>
			<!--td class="balance">  <?php echo $family_data["balance"] ?> </td-->
			<td class="balance" align="right">  <?php echo "" ?> </td>
		</tr>
	<?php } ?>

		<th>Total</th> 
		<th id='total_headcount'>--</th>  
		<th id='total_senior'>--</th>  
		<th id='total_children'>--</th> 
		<th id='total_expenses'>--</th> 
		<th id='total_balance'>--</th>
	</tr>

</table>
<div class="balancesheet_notes">
* positive balance means the family needs to pay the amount<br>
* negative balance means the family overpaid and will get the amount back<br>
</div>