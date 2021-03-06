// calculate the balance of each family
computeBalance();

// change background color for the current family in
// balance sheet table. Then, the user can see his/her
// family balance easily
changeBgColorForCurrentFamily ();

function validateFamilyData(formname) {
	var headcount;
	var senior ;
	var children ;
	var expenses = formname.expenses.value ;
	var error_count = 0;
	var error_msg = "";

	// still not able to access headcount via formname,
	// so I use document.getElementById
	e = document.getElementById('headcount');
	headcount = e.options[e.selectedIndex].value;

	e = document.getElementById('senior');
	senior = e.options[e.selectedIndex].value;

	e = document.getElementById('children');
	children = e.options[e.selectedIndex].value;

	if ( parseInt(headcount) < (parseInt(senior) + parseInt(children)) ) {
		error_msg = error_msg  + "Headcount must not be lesser than the sum of senior and children.\n";
		error_count++;
	}
	
	var reg = new RegExp("^[-]?[0-9]+[\.]?[0-9]+$");
	if (!reg.test(expenses)) {
		error_msg = error_msg  + "Expenses must be a number.\n";		
		error_count++;
	}
	
	if (error_count) {
		alert (error_msg);
		// console.log(error_count + ":" + error_msg);
		return false;
	}
	else {
		return true;
	}
}


function computeBalance(family_name) {

	// console.log ("want to see something when the button is click");
	var totalHeadcount = calTotalHeadcount ();
	// console.log ("totalHeadcount: " + totalHeadcount);

	var totalSenior = calTotalSenior ();
	var totalChildren = calTotalChildren ();
	var totalExpenses = calTotalExpenses();
	// senior and childre under 12 are free
	// calculate how many people who need to pay
	var needToPay = parseInt(totalHeadcount) - parseInt(totalSenior) - parseInt(totalChildren) ;
	// only calculate how much for those who need to pay
	var feePerPerson = parseFloat(totalExpenses) / parseFloat(needToPay);
	// console.log ("Fee per person: " + feePerPerson);
	calFamilyBalance(feePerPerson);

	// this step is to double-check the total balance - it should be zero all the time
	calTotalBalance();
}

// calculate total number of people who participate the BBQ
function calTotalHeadcount() {
	var sum = 0;
	$('#balancesheet .headcount').each(function() {
		// var headcount = $(this).find(".headcount").html();
		var headcount = $(this).html();
		sum += parseInt(headcount);
	 });
	$('#total_headcount').html(sum);
	return sum;
}

// calculate the total number of seniors - they are free
function calTotalSenior() {
	var sum = 0;
	$('#balancesheet .senior').each(function() {
		var senior = $(this).html();
		sum += parseInt(senior);
	 });
	$('#total_senior').html(sum); 
	return sum;
}

// calculate the total number of children - they are free	
function calTotalChildren() {
	var sum = 0;
	$('#balancesheet .children').each(function() {
		var children = $(this).html();
		sum += parseInt(children);
	 });
	$('#total_children').html(sum); 
	return sum;
}

// calculate the total expenses of this BBQ
function calTotalExpenses() {
	var sum = 0;
	$('#balancesheet .expenses').each(function() {
		var expenses = $(this).html();
		sum += parseFloat(expenses);
	 });
	$('#total_expenses').html(sum); 
	return sum;
}

// calculte balances of each family
function calFamilyBalance(feePerPerson) {

	$('#balancesheet .balance').each(function() {
		var headcount = $(this).closest('tr').find(".headcount").html();
		var senior = $(this).closest('tr').find(".senior").html();
		var children = $(this).closest('tr').find(".children").html();
		var expenses = $(this).closest('tr').find(".expenses").html();
		var needToPay = parseInt(headcount) - parseInt(senior) - parseInt(children) ;
		var balance = needToPay * parseFloat(feePerPerson) - parseFloat(expenses); 
		// console.log (balance);
		// write back to the balance sheet after computation
		// $(this).closest('tr').find(".balance").html(balance.toFixed(2)); 
		$(this).html(balance.toFixed(2)); 
		if (parseFloat(balance) > 0) {
			$(this).css('color', 'red');
		}
	});
}

// double-check the total balance - it should be zero all the time
function calTotalBalance() {
	var sum = 0;
	$('#balancesheet .balance').each(function() {
		var balance = $(this).html();
		sum += parseFloat(balance);
	 });
	$('#total_balance').html(sum.toFixed(2)); 
}

// highlight the current family in the balancesheet
// by changing the row's background color
function changeBgColorForCurrentFamily() {

	// console.log("In changeBgColorForCurrentFamily");
	$('#balancesheet tr').each(function() {
		if ($(this).attr("class")) {
			var familyName = $(this).attr("class");
			var currentFamilyName = $("#family_input_data input[name=family_name]").val();
			if (familyName == currentFamilyName) {
			// console.log("className: " + className);
				$(this).css('background-color', 'yellow');
			}
		}		
	});
}



